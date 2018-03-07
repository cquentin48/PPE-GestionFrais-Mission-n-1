<?php
/**
 * Classe d'accès aux données.
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Cheri Bibi - Réseau CERTA <contact@reseaucerta.org>
 * @author    José GIL - CNED <jgil@ac-nice.fr>
 * @copyright 2017 Réseau CERTA
 * @license   Réseau CERTA
 * @version   GIT: <0>
 * @link      http://www.php.net/manual/fr/book.pdo.php PHP Data Objects sur php.net
 */

/**
 * Classe d'accès aux données.
 *
 * Utilise les services de la classe PDO
 * pour l'application GSB
 * Les attributs sont tous statiques,
 * les 4 premiers pour la connexion
 * $monPdo de type PDO
 * $monPdoGsb qui contiendra l'unique instance de la classe
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Cheri Bibi - Réseau CERTA <contact@reseaucerta.org>
 * @author    José GIL <jgil@ac-nice.fr>
 * @copyright 2017 Réseau CERTA
 * @license   Réseau CERTA
 * @version   Release: 1.0
 * @link      http://www.php.net/manual/fr/book.pdo.php PHP Data Objects sur php.net
 */
//namespace pdogsb;

class PdoGsb
{
    private static $serveur = 'mysql:host=localhost';
    private static $bdd = 'dbname=gsb_frais';
    private static $user = 'userGsb';
    private static $mdp = 'secret';
    private static $monPdo;
    private static $monPdoGsb = null;

    /**
     * Constructeur privé, crée l'instance de PDO qui sera sollicitée
     * pour toutes les méthodes de la classe
     */
    private function __construct()
    {
        PdoGsb::$monPdo = new PDO(
            PdoGsb::$serveur . ';' . PdoGsb::$bdd,
            PdoGsb::$user,
            PdoGsb::$mdp,
            array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)    
        );
        PdoGsb::$monPdo->query('SET CHARACTER SET utf8');
    }

    /**
     * Méthode destructeur appelée dès qu'il n'y a plus de référence sur un
     * objet donné, ou dans n'importe quel ordre pendant la séquence d'arrêt.
     */
    public function __destruct()
    {
        PdoGsb::$monPdo = null;
    }

    /**
     * Fonction statique qui crée l'unique instance de la classe
     * Appel : $instancePdoGsb = PdoGsb::getPdoGsb();
     *
     * @return l'unique objet de la classe PdoGsb
     */
    public static function getPdoGsb()
    {
        if (PdoGsb::$monPdoGsb == null) {
            PdoGsb::$monPdoGsb = new PdoGsb();
            //Affichage des erreurs dans les requêtes SQL
            PdoGsb::$monPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return PdoGsb::$monPdoGsb;
    }

    /**
     * Retourne les informations d'un visiteur
     *
     * @param String $login Login du visiteur
     * @param String $mdp   Mot de passe du visiteur
     *
     * @return l'id, le nom et le prénom sous la forme d'un tableau associatif
     */
    public function getInfosVisiteur($login, $mdp)
    {
        $mdp = hash('sha256',$mdp);
        echo $mdp;
        $requetePrepare = PdoGsb::$monPdo->prepare(
            'SELECT visiteur.id AS id, visiteur.nom AS nom, '
            . 'visiteur.prenom AS prenom, '
            . 'visiteur.comptable AS comptable '
            . 'FROM visiteur '
            . 'WHERE visiteur.login = :unLogin AND visiteur.mdp = :unMdp'
        );
        $requetePrepare->bindParam(':unLogin', $login, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unMdp', $mdp, PDO::PARAM_STR);
        $requetePrepare->execute();
        return $requetePrepare->fetch();
    }

    /**
     * Retourne sous forme d'un tableau associatif toutes les lignes de frais
     * hors forfait concernées par les deux arguments.
     * La boucle foreach ne peut être utilisée ici car on procède
     * à une modification de la structure itérée - transformation du champ date-
     *
     * @param String $idVisiteur ID du visiteur
     * @param String $mois       Mois sous la forme aaaamm
     *
     * @return tous les champs des lignes de frais hors forfait sous la forme
     * d'un tableau associatif
     */
    public function getLesFraisHorsForfait($idVisiteur, $mois)
    {
        $requetePrepare = PdoGsb::$monPdo->prepare(
            'SELECT * FROM lignefraishorsforfait '
            . 'WHERE lignefraishorsforfait.idvisiteur = :unIdVisiteur '
            . 'AND lignefraishorsforfait.mois = :unMois'
        );
        $requetePrepare->bindParam(':unIdVisiteur', $idVisiteur, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unMois', $mois, PDO::PARAM_STR);
        $requetePrepare->execute();
        $lesLignes = $requetePrepare->fetchAll();
        for ($i = 0; $i < count($lesLignes); $i++) {
            if(!(strstr($lesLignes[$i]['libelle'], 'REFUSE : '))){
                $date = $lesLignes[$i]['date'];
                $lesLignes[$i]['date'] = dateAnglaisVersFrancais($date);
            }else{
                unset($lesLignes[$i]);
            }
        }
        return $lesLignes;
    }
    
    /*public function getMdp(){
        $requetePrepare = PdoGsb::$monPdo->prepare(
            'SELECT `id`, `mdp` FROM `visiteur` '
        );
        $requetePrepare->execute();
        $lesLignes = $requetePrepare->fetchAll();
        $tabMdp = array();
        for($i = 0; $i< count($lesLignes);$i++){
            $key = $lesLignes[$i]['id'];
            $value = hash('sha256', $lesLignes[$i]['mdp']);
            $tabMdp[$key] = $value;
            $requetePrepare = PdoGsb::$monPdo->prepare(
                "UPDATE `visiteur` "
              . "SET `mdp` = '$value'"
              . "WHERE `id` = '$key'"
            );
            $requetePrepare->execute();
        }
        echo "<pre>";
        print_r($tabMdp);
        return $tabMdp;
    }*/
    
    /**
     * Retourne toutes les fiches validées
     * @param type $idVisiteur l'identifiant du visiteur
     * @return array la liste des fiches validées
     */
    public function getFichesValides($idVisiteur){
        //Création de la variable de retour
        $ficheFrais = array();
        //Préparation de la requête sql pour la sélection des fiches validées
        $requetePrepare = PdoGsb::$monPdo->prepare(
             "SELECT `mois`, `nbjustificatifs`, `montantvalide`"
           . " from `fichefrais`"
           . "where `idetat` = 'VA' AND `idVisiteur` = '$idVisiteur';"
        );
        //Exécution de la requête
        $requetePrepare->execute();
        //Capture des données de la requête
        $rows = $requetePrepare->fetchAll();
        //Formattage des données reçus de la requête sql dans la variable 'ficheFrais' => mois, nbjustificatifs, et montantvalide
        for($i = 0; $i<sizeof($rows); $i++){
            $ficheFrais[$i]['mois'] = $rows[$i]['mois'];
            $ficheFrais[$i]['nbjustificatifs'] = $rows[$i]['nbjustificatifs'];
            $ficheFrais[$i]['montantvalide'] = $rows[$i]['montantvalide'];
        }
        
        //Pour chaque fiche, on ajoute les frais forfaitisés et les frais hors-forfait
        for($i = 0; $i<sizeof($ficheFrais);$i++){
            $mois = $ficheFrais[$i]['mois'];
            $requetePrepare = PdoGsb::$monPdo->prepare(
                         "SELECT `libelle`, `quantite`, (`quantite`*`montant`) as 'somme', `montant`"
                       . "FROM `lignefraisforfait` INNER JOIN `fraisforfait`"
                       . "on `lignefraisforfait`.`idfraisforfait` = `fraisforfait`.`id`"
                       . "where `mois` = '$mois' AND `idVisiteur` = '$idVisiteur';"
            );
            $requetePrepare->execute();
            $rows = $requetePrepare->fetchAll();
            
            if(sizeof($rows)!=0){//Si la requête retourne un résultat
                $listeFraisForfaitises = array();
                for($j = 0; $j<sizeof($rows);$j++){
                    $listeFraisForfaitises[$j]['quantite'] = $rows[$j]['quantite'];
                    $listeFraisForfaitises[$j]['montantunitaire'] = $rows[$j]['somme'];
                    $listeFraisForfaitises[$j]['idfraisforfait'] = $rows[$j]['libelle'];
                    $listeFraisForfaitises[$j]['somme'] = $rows[$j]['somme'];
                }
                $ficheFrais[$i]['listeFraisForfaitises'] = $listeFraisForfaitises;
            }
            
            $requetePrepare = PdoGsb::$monPdo->prepare(
                 "SELECT `libelle`, `date`, `montant`"
               . "FROM `lignefraishorsforfait`"
               . "where `mois` = '$mois' AND `idVisiteur` = '$idVisiteur';"
            );
            $requetePrepare->execute();
            $rows = $requetePrepare->fetchAll();
            
            if(sizeof($rows)!=0){//Si la requête retourne un résultat
                $listeFraisHorsForfait = array();
                for($j = 0; $j<sizeof($rows);$j++){
                    $listeFraisHorsForfait[$j]['libelle'] = $rows[$j]['libelle'];
                    $listeFraisHorsForfait[$j]['date'] = $rows[$j]['date'];
                    $listeFraisHorsForfait[$j]['montant'] = $rows[$j]['montant'];
                }
                $ficheFrais[$i]['listeFraisHorsForfait'] = $listeFraisHorsForfait;
            }
        }
        $_SESSION['ficheFrais'] = $ficheFrais;
        return $ficheFrais;
    }

    /**
     * Retourne le nombre de justificatif d'un visiteur pour un mois donné
     *
     * @param String $idVisiteur ID du visiteur
     * @param String $mois       Mois sous la forme aaaamm
     *
     * @return le nombre entier de justificatifs
     */
    public function getNbjustificatifs($idVisiteur, $mois)
    {
        $requetePrepare = PdoGsb::$monPdo->prepare(
            'SELECT fichefrais.nbjustificatifs as nb FROM fichefrais '
            . 'WHERE fichefrais.idvisiteur = :unIdVisiteur '
            . 'AND fichefrais.mois = :unMois'
        );
        $requetePrepare->bindParam(':unIdVisiteur', $idVisiteur, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unMois', $mois, PDO::PARAM_STR);
        $requetePrepare->execute();
        $laLigne = $requetePrepare->fetch();
        return $laLigne['nb'];
    }

    /**
     * Retourne sous forme d'un tableau associatif toutes les lignes de frais
     * au forfait concernées par les deux arguments
     *
     * @param String $idVisiteur ID du visiteur
     * @param String $mois       Mois sous la forme aaaamm
     *
     * @return l'id, le libelle et la quantité sous la forme d'un tableau
     * associatif
     */
    public function getLesFraisForfait($idVisiteur, $mois)
    {
        $requetePrepare = PdoGSB::$monPdo->prepare(
            'SELECT fraisforfait.id as idfrais, '
            . 'fraisforfait.libelle as libelle, '
            . 'lignefraisforfait.quantite as quantite '
            . 'FROM lignefraisforfait '
            . 'INNER JOIN fraisforfait '
            . 'ON fraisforfait.id = lignefraisforfait.idfraisforfait '
            . 'WHERE lignefraisforfait.idvisiteur = :unIdVisiteur '
            . 'AND lignefraisforfait.mois = :unMois '
            . 'ORDER BY lignefraisforfait.idfraisforfait'
        );
        $requetePrepare->bindParam(':unIdVisiteur', $idVisiteur, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unMois', $mois, PDO::PARAM_STR);
        $requetePrepare->execute();
        return $requetePrepare->fetchAll();
    }

    /**
     * Retourne tous les id de la table FraisForfait
     *
     * @return un tableau associatif
     */
    public function getLesIdFrais()
    {
        $requetePrepare = PdoGsb::$monPdo->prepare(
            'SELECT fraisforfait.id as idfrais '
            . 'FROM fraisforfait ORDER BY fraisforfait.id'
        );
        $requetePrepare->execute();
        return $requetePrepare->fetchAll();
    }
    
    /**
     * Vérifie si le compte est visiteur ou comptable
     * @param integer $idCompte l'identifiant du compte dans la base de données
     * @return boolean 0-> Visiteur \n 1-> Comptable
     */
    public function estComptable($idCompte){
        $requetePrepare = PdoGsb::$monPdo->Prepare(
          "SELECT `comptable`"
        . "from `visiteur`"
        . "where `id` = '$idCompte'"        
        );
        $requetePrepare->execute();
        $laLigne = $requetePrepare->fetch();
        return $laLigne['comptable'];
    }

    /**
     * Met à jour la table ligneFraisForfait
     * Met à jour la table ligneFraisForfait pour un visiteur et
     * un mois donné en enregistrant les nouveaux montants
     *
     * @param String $idVisiteur ID du visiteur
     * @param String $mois       Mois sous la forme aaaamm
     * @param Array  $lesFrais   tableau associatif de clé idFrais et
     *                           de valeur la quantité pour ce frais
     */
    public function majFraisForfait($idVisiteur, $mois, $lesFrais)
    {
        $lesCles = array_keys($lesFrais);
        foreach ($lesCles as $unIdFrais) {
            $qte = $lesFrais[$unIdFrais];
            $requetePrepare = PdoGSB::$monPdo->prepare(
                'UPDATE lignefraisforfait '
                . 'SET lignefraisforfait.quantite = :uneQte '
                . 'WHERE lignefraisforfait.idvisiteur = :unIdVisiteur '
                . 'AND lignefraisforfait.mois = :unMois '
                . 'AND lignefraisforfait.idfraisforfait = :idFrais'
            );
            $requetePrepare->bindParam(':uneQte', $qte, PDO::PARAM_INT);
            $requetePrepare->bindParam(':unIdVisiteur', $idVisiteur, PDO::PARAM_STR);
            $requetePrepare->bindParam(':unMois', $mois, PDO::PARAM_STR);
            $requetePrepare->bindParam(':idFrais', $unIdFrais, PDO::PARAM_STR);
            $requetePrepare->execute();
        }
    }

    /**
     * Met à jour la table ligneFraisHorsForfait
     * Met à jour la table ligneFraisHorsForfait pour un visiteur et
     * un mois donné en enregistrant le nouveau frais hors-forfait
     *
     * @param String $idVisiteur               ID du visiteur
     * @param String $idFraisHorsForfait       L'identifiant du frais hors-forfait
     * @param String $mois                     Le mois du frais hors-forfait
     * @param String $libelle                  La description du frais hors-forfait
     * @param String $date                     La date du frais hors-forfait
     * @param Numeric $montant                 Le montant du frais hors-forfait
     */
    public function majFraisHorsForfait($idVisiteur, $idFraisHorsForfait, $mois, $libelle, $date, $montant)
    {
        $requetePrepare = PdoGSB::$monPdo->prepare(
            'UPDATE lignefraishorsforfait '
          . 'SET lignefraishorsforfait.libelle = :unLibelle, '
          . 'lignefraishorsforfait.date = :uneDate, '
          . 'lignefraishorsforfait.montant = :unMontant '
          . 'WHERE lignefraishorsforfait.idvisiteur = :unIdVisiteur '
          . 'AND lignefraisforfait.mois = :unMois '
          . 'AND lignefraisforfait.idfraisforfait = :idFraisHorsForfait'
        );
        $requetePrepare->bindParam(':unLibelle', $libelle, PDO::PARAM_INT);
        $requetePrepare->bindParam(':uneDate', $date, PDO::PARAM_INT);
        $requetePrepare->bindParam(':unMontant', $montant, PDO::PARAM_INT);
        $requetePrepare->bindParam(':unIdVisiteur', $idVisiteur, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unMois', $mois, PDO::PARAM_STR);
        $requetePrepare->bindParam(':idFraisHorsForfait', $idFraisHorsForfait, PDO::PARAM_STR);
        $requetePrepare->execute();
    }

    /**
     * Met à jour le nombre de justificatifs de la table ficheFrais
     * pour le mois et le visiteur concerné
     *
     * @param String  $idVisiteur      ID du visiteur
     * @param String  $mois            Mois sous la forme aaaamm
     * @param Integer $nbJustificatifs Nombre de justificatifs
     */
    public function majNbJustificatifs($idVisiteur, $mois, $nbJustificatifs)
    {
        $requetePrepare = PdoGB::$monPdo->prepare(
            'UPDATE fichefrais '
            . 'SET nbjustificatifs = :unNbJustificatifs '
            . 'WHERE fichefrais.idvisiteur = :unIdVisiteur '
            . 'AND fichefrais.mois = :unMois'
        );
        $requetePrepare->bindParam(
            ':unNbJustificatifs',
            $nbJustificatifs,
            PDO::PARAM_INT
        );
        $requetePrepare->bindParam(':unIdVisiteur', $idVisiteur, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unMois', $mois, PDO::PARAM_STR);
        $requetePrepare->execute();
    }

    /**
     * Teste si un visiteur possède une fiche de frais pour le mois passé en argument
     *
     * @param String $idVisiteur ID du visiteur
     * @param String $mois       Mois sous la forme aaaamm
     *
     * @return vrai ou faux
     */
    public function estPremierFraisMois($idVisiteur, $mois)
    {
        $boolReturn = false;
        $requetePrepare = PdoGsb::$monPdo->prepare(
            'SELECT fichefrais.mois FROM fichefrais '
            . 'WHERE fichefrais.mois = :unMois '
            . 'AND fichefrais.idvisiteur = :unIdVisiteur'
        );
        $requetePrepare->bindParam(':unMois', $mois, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unIdVisiteur', $idVisiteur, PDO::PARAM_STR);
        $requetePrepare->execute();
        if (!$requetePrepare->fetch()) {
            $boolReturn = true;
        }
        return $boolReturn;
    }
    
    /**
     * Fonction qui retourne la liste des visiteurs
     *
     * @param PDO $pdo instance de la classe PDO utilisée pour se connecter
     *
     * @return Array de visiteurs
     */
    function getLesVisiteurs($pdo)
    {
        $requetePrepare = PdoGSB::$monPdo->prepare(
            'SELECT `id`, `nom`, `prenom` FROM `visiteur` order by nom asc, prenom asc'
        );
        $requetePrepare->execute();
        $lesVisiteurs = array();
        while ($laLigne = $requetePrepare->fetch()) {
            $id = $laLigne['id'];
            $lesVisiteurs[$id] = $laLigne['prenom']." ".$laLigne['nom'];
        }
        return $lesVisiteurs;
    }    

    /**
     * Retourne le dernier mois en cours d'un visiteur
     *
     * @param String $idVisiteur ID du visiteur
     *
     * @return le mois sous la forme aaaamm
     */
    public function dernierMoisSaisi($idVisiteur)
    {
        $requetePrepare = PdoGsb::$monPdo->prepare(
            'SELECT MAX(mois) as dernierMois '
            . 'FROM fichefrais '
            . 'WHERE fichefrais.idvisiteur = :unIdVisiteur'
        );
        $requetePrepare->bindParam(':unIdVisiteur', $idVisiteur, PDO::PARAM_STR);
        $requetePrepare->execute();
        $laLigne = $requetePrepare->fetch();
        $dernierMois = $laLigne['dernierMois'];
        return $dernierMois;
    }

    /**
     * Report d'un mois les éléments de frais hors-forfait
     * @param type $idFraisHorsForfait l'identifiant du frais hors-forfait
     * @param nouveauMois le mois reporté
     * @param type $nouveauMois
     */
    public function reporter($idFraisHorsForfait, $mois, $nouveauMois)
    {
        $monPdo = PdoGsb::getPdoGsb();
        //On récupère le libellé de la fiche dans la base de donnée
        $requetePrepare = PdoGsb::$monPdo->prepare(
             'SELECT `libelle`'
            .'from `lignefraishorsforfait`'
            .'where `id` = :idFraisHorsForfait'
        );
        $requetePrepare->bindParam(':idFraisHorsForfait', $idFraisHorsForfait, PDO::PARAM_INT);
        $requetePrepare->execute();
        //On copie le résultat dans une variable
        $laLigne = $requetePrepare->fetch();
        $libelle = $laLigne['libelle'];
        //On modifie ainsi les données
        $nouveauLibelle = "REFUSE : ".$libelle;
        $requetePrepare = PdoGsb::$monPdo->prepare(
            "UPDATE `lignefraishorsforfait`"
            . "set libelle = '$nouveauLibelle',"
            . "mois = $nouveauMois,"
            . "date = cast(now() as date)"    
            . "WHERE id = $idFraisHorsForfait"
        );
        $requetePrepare->execute();
        if($requetePrepare){
            echo "<script>console.log('Requête effectuée avec succès');</script>";
        }else{
            echo "<script>error.log('Il y a eu une erreur dans le report des frais-hors forfait au mois suivant');</script>";
        }
    }
    
    /**
     * Validation de la fiche
     * @param type $idVisiteur l'identifiant de l'utilisateur dans la base
     * @param type $mois le mois de la fiche en cours
     */
    public function validerFiche($idVisiteur, $mois){
        $monPdo = PdoGsb::getPdoGsb();
        $montantTotal = 0;
        
        //On calcul les frais forfaitisés
        $requetePrepare = PdoGsb::$monPdo->prepare(
          "SELECT `idfraisforfait`, `quantite` FROM `lignefraisforfait`"
        . "where `idvisiteur` = '$idVisiteur' and `mois` = '$mois'"              
        );
        $requetePrepare->execute();
        
        while($laLigne = $requetePrepare->fetch()){
            //Calcul des frais forfaitisé par la boucle switch
            switch($laLigne['idfraisforfait']){
                //Forfait étape
                case "ETP":
                    $montantTotal += $laLigne['quantite']*110;
                    break;
                //Frais Kilométrique
                case "KM":
                    $montantTotal += $laLigne['quantite']*0.62;
                    break;
                //Nuitée hotel
                case "NUI":
                    $montantTotal += $laLigne['quantite']*80.00;
                    break;
                //Repas restaurant
                case "REP":
                    $montantTotal += $laLigne['quantite']*25.00;
                    break;
                //En cas d'erreur
                default:
                    break;
            }
        }
        
        //Calcul du coût des frais forfaitisés
        $requetePrepare = PdoGsb::$monPdo->prepare(
            "SELECT `montant`"
          . "FROM `lignefraishorsforfait`"
          . "where `idvisiteur` = '$idVisiteur' and `mois` = '$mois'"
          );
        $requetePrepare->execute();
        while($laLigne = $requetePrepare->fetch()){
            $montantTotal += $laLigne['montant'];
        }
        
        //On transforme le montant total en variable flottante à deux chiffres
        $montantTotal = sprintf("%.2f", $montantTotal);
        //On récupère le libellé de la fiche dans la base de donnée
        $requetePrepare = PdoGsb::$monPdo->prepare(
            "UPDATE `fichefrais`"
            ."SET `montantvalide` = $montantTotal,\n"
            ."`datemodif` = cast(now() as date),\n"
            ."`idetat` = 'VA'\n"
            ."where `idvisiteur` = '$idVisiteur' AND `mois` = '$mois'"
        );
        $requetePrepare->execute();
        $requetePrepare = PdoGsb::$monPdo->prepare(
            "SELECT `nbjustificatifs`, `montantvalide`, `mois`, `prenom`, `nom` "
            . "from fichefrais inner join visiteur on fichefrais.idvisiteur = visiteur.id "
            . "where visiteur.id = '$idVisiteur' AND fichefrais.mois = '$mois'"    
        );
        $requetePrepare->execute();
        while($laLigne = $requetePrepare->fetch()){
            $mois = $laLigne['mois'];
            $visiteur = $laLigne['prenom']." ".$laLigne['nom'];
            $montantTotalFrais = $laLigne['montantvalide'];
            $nbJustificatifs = $laLigne['nbjustificatifs'];
            echo "La fiche du mois du mois '$mois' pour le visiteur '$visiteur' a été mis à jour.";
            echo "\n";
            echo "Montant total : $montantTotal || Nombre de justificatifs : $nbJustificatifs";
        }
    }
    
    /**
     * Crée une nouvelle fiche de frais et les lignes de frais au forfait
     * pour un visiteur et un mois donnés
     *
     * Récupère le dernier mois en cours de traitement, met à 'CL' son champs
     * idEtat, crée une nouvelle fiche de frais avec un idEtat à 'CR' et crée
     * les lignes de frais forfait de quantités nulles
     *
     * @param String $idVisiteur ID du visiteur
     * @param String $mois       Mois sous la forme aaaamm
     *
     * @return null
     */
    public function creeNouvellesLignesFrais($idVisiteur, $mois)
    {
        $dernierMois = $this->dernierMoisSaisi($idVisiteur);
        $laDerniereFiche = $this->getLesInfosFicheFrais($idVisiteur, $dernierMois);
        if ($laDerniereFiche['idEtat'] == 'CR') {
            $this->majEtatFicheFrais($idVisiteur, $dernierMois, 'CL');
        }
        $requetePrepare = PdoGsb::$monPdo->prepare(
            'INSERT INTO fichefrais (idvisiteur,mois,nbJustificatifs,'
            . 'montantValide,dateModif,idEtat) '
            . "VALUES (:unIdVisiteur,:unMois,0,0,now(),'CR')"
        );
        $requetePrepare->bindParam(':unIdVisiteur', $idVisiteur, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unMois', $mois, PDO::PARAM_STR);
        $requetePrepare->execute();
        $lesIdFrais = $this->getLesIdFrais();
        foreach ($lesIdFrais as $unIdFrais) {
            $requetePrepare = PdoGsb::$monPdo->prepare(
                'INSERT INTO lignefraisforfait (idvisiteur,mois,'
                . 'idFraisForfait,quantite) '
                . 'VALUES(:unIdVisiteur, :unMois, :idFrais, 0)'
            );
            $requetePrepare->bindParam(':unIdVisiteur', $idVisiteur, PDO::PARAM_STR);
            $requetePrepare->bindParam(':unMois', $mois, PDO::PARAM_STR);
            $requetePrepare->bindParam(
                ':idFrais',
                $unIdFrais['idfrais'],
                PDO::PARAM_STR
            );
            $requetePrepare->execute();
        }
    }

    /**
     * Crée un nouveau frais hors forfait pour un visiteur un mois donné
     * à partir des informations fournies en paramètre
     *
     * @param String $idVisiteur ID du visiteur
     * @param String $mois       Mois sous la forme aaaamm
     * @param String $libelle    Libellé du frais
     * @param String $date       Date du frais au format français jj//mm/aaaa
     * @param Float  $montant    Montant du frais
     *
     * @return null
     */
    public function creeNouveauFraisHorsForfait(
        $idVisiteur,
        $mois,
        $libelle,
        $date,
        $montant
    ) {
        $dateFr = dateFrancaisVersAnglais($date);
        $requetePrepare = PdoGSB::$monPdo->prepare(
            'INSERT INTO lignefraishorsforfait '
            . 'VALUES (null, :unIdVisiteur,:unMois, :unLibelle, :uneDateFr,'
            . ':unMontant) '
        );
        $requetePrepare->bindParam(':unIdVisiteur', $idVisiteur, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unMois', $mois, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unLibelle', $libelle, PDO::PARAM_STR);
        $requetePrepare->bindParam(':uneDateFr', $dateFr, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unMontant', $montant, PDO::PARAM_INT);
        $requetePrepare->execute();
    }

    /**
     * Supprime le frais hors forfait dont l'id est passé en argument
     *
     * @param String $idFrais ID du frais
     *
     * @return null
     */
    public function supprimerFraisHorsForfait($idFrais)
    {
        $requetePrepare = PdoGSB::$monPdo->prepare(
            'DELETE FROM lignefraishorsforfait '
            . 'WHERE lignefraishorsforfait.id = :unIdFrais'
        );
        $requetePrepare->bindParam(':unIdFrais', $idFrais, PDO::PARAM_STR);
        $requetePrepare->execute();
    }

    /**
     * Retourne les mois pour lesquel un visiteur a une fiche de frais
     *
     * @param String $idVisiteur ID du visiteur
     *
     * @return un tableau associatif de clé un mois -aaaamm- et de valeurs
     *         l'année et le mois correspondant
     */
    public function getLesMoisDisponibles($idVisiteur)
    {
        $requetePrepare = PdoGSB::$monPdo->prepare(
            'SELECT fichefrais.mois AS mois FROM fichefrais '
            . 'WHERE fichefrais.idvisiteur = :unIdVisiteur '
            . 'ORDER BY fichefrais.mois desc'
        );
        $requetePrepare->bindParam(':unIdVisiteur', $idVisiteur, PDO::PARAM_STR);
        $requetePrepare->execute();
        $lesMois = array();
        while ($laLigne = $requetePrepare->fetch()) {
            $mois = $laLigne['mois'];
            $numAnnee = substr($mois, 0, 4);
            $numMois = substr($mois, 4, 2);
            $lesMois['$mois'] = array(
                'mois' => $mois,
                'numAnnee' => $numAnnee,
                'numMois' => $numMois
            );
        }
        return $lesMois;
    }

    /**
     * Retourne les informations d'une fiche de frais d'un visiteur pour un
     * mois donné
     *
     * @param String $idVisiteur ID du visiteur
     * @param String $mois       Mois sous la forme aaaamm
     *
     * @return un tableau avec des champs de jointure entre une fiche de frais
     *         et la ligne d'état
     */
    public function getLesInfosFicheFrais($idVisiteur, $mois)
    {
        $requetePrepare = PdoGSB::$monPdo->prepare(
            'SELECT ficheFrais.idEtat as idEtat, '
            . 'ficheFrais.dateModif as dateModif,'
            . 'ficheFrais.nbJustificatifs as nbJustificatifs, '
            . 'ficheFrais.montantValide as montantValide, '
            . 'etat.libelle as libEtat '
            . 'FROM fichefrais '
            . 'INNER JOIN Etat ON ficheFrais.idEtat = Etat.id '
            . 'WHERE fichefrais.idvisiteur = :unIdVisiteur '
            . 'AND fichefrais.mois = :unMois'
        );
        $requetePrepare->bindParam(':unIdVisiteur', $idVisiteur, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unMois', $mois, PDO::PARAM_STR);
        $requetePrepare->execute();
        $laLigne = $requetePrepare->fetch();
        return $laLigne;
    }

    /**
     * Modifie l'état et la date de modification d'une fiche de frais.
     * Modifie le champ idEtat et met la date de modif à aujourd'hui.
     *
     * @param String $idVisiteur ID du visiteur
     * @param String $mois       Mois sous la forme aaaamm
     * @param String $etat       Nouvel état de la fiche de frais
     *
     * @return null
     */
    public function majEtatFicheFrais($idVisiteur, $mois, $etat)
    {
        $requetePrepare = PdoGSB::$monPdo->prepare(
            'UPDATE ficheFrais '
            . 'SET idEtat = :unEtat, dateModif = now() '
            . 'WHERE fichefrais.idvisiteur = :unIdVisiteur '
            . 'AND fichefrais.mois = :unMois'
        );
        $requetePrepare->bindParam(':unEtat', $etat, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unIdVisiteur', $idVisiteur, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unMois', $mois, PDO::PARAM_STR);
        $requetePrepare->execute();
    }
}
