<?php
    /* Permet de démarrer une session sur le serveur pour l'utilisateur courant, ou la récupérer s'il en avait déjà une */
    session_start();

    /* On a indiqué dans index que le mot clé pour récupérer action s'appelle "action"*/
    $action = $_GET["action"];

    $ref = (isset($_GET['ref'])) ? $_GET['ref'] : "";
    // $menu = $_SESSION['menuSemaine'][0];



    switch($action) {

        case "ajouterProduit":
              /* Vérifier si la clé "submit" correspond bien à l'attribut "name" du bouton du formulaire : cela limite l'accès à traitement.php. Seules les requêtes HTTP provenant de la soumission de notre formulairesont acceptées */
            if(isset($_POST['submit'])){
                /* Vérification de l'intégralité des valeurs transmises dans le tableau $_POST en fonction de celles que nous attendons */
                $nom = filter_input(INPUT_POST, "nom", FILTER_SANITIZE_SPECIAL_CHARS);
                $prenom = filter_input(INPUT_POST, "prenom", FILTER_SANITIZE_SPECIAL_CHARS);
                // $price = filter_input(INPUT_POST, "price", FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $telephone = $_POST['telephone'];
                $nombrePersonne = filter_input(INPUT_POST, "nombrePersonne", FILTER_VALIDATE_INT);
                $mail = filter_input(INPUT_POST, "mail", FILTER_VALIDATE_EMAIL);
                $sujet = filter_input(INPUT_POST, "sujet", FILTER_SANITIZE_SPECIAL_CHARS);
                $jourReservation = filter_input(INPUT_POST, "jour-reservation", FILTER_SANITIZE_SPECIAL_CHARS);
                $creneauReservation = filter_input(INPUT_POST, "creneau-reservation", FILTER_SANITIZE_SPECIAL_CHARS);
                /* Comme les options sont déjà définies, il suffit de lire l'option choisie dans select */
                $heureReservation = $_POST['creneau-heure'];
                
                //Nous devons conserver chaque produit renseigné, donc les stocker esession. On décide d'abord de leur organisation au sein de la session 
                if($nom && $prenom && $telephone && $nombrePersonne && $mail && $sujet && $jourReservation && $creneauReservation && $heureReservation){

                    $reservation = [
                        "nom" => $nom,
                        "prenom" => $prenom,
                        "telephone" => $telephone,
                        "nombrePersonne" => $nombrePersonne,
                        "mail" => $mail,
                        "sujet" => $sujet,
                        "jourReservation" => $jourReservation,
                        "creneauReservation" => $creneauReservation,
                        "heureReservation" => $heureReservation
                    ];
                
                    /* On enregistre le produit en session */
                    /* On appelle le tableau session fournit par php, on y indique un clé "products" */
                    $_SESSION['reservations'][] = $reservation;                    
                }
                
            }


            /* Redirection vers le formulaire, qu'il soit saisi ou non */
            header("Location:panier.php");
        break;
        
        case "afficherMenu":
            $_SESSION['hello'] = "Hello";
            // switch($menu) {
            //     case 'lundi':
            //         $_SESSION['result'] = $_SESSION['menuSemaine'][0]['lundi']['plat'];
            //         break;
            // }
            header("Location:panier.php");
        break;

        case "viderPanier":
            unset($_SESSION['reservations']);  
            header("Location:panier.php");
        break;

        case "baisserNombrePersonne":
            $_SESSION['reservations'][$ref]["nombrePersonne"]--;
            header("Location:panier.php");         
        break;

        case "augmenterNombrePersonnes":
            $_SESSION['reservations'][$ref]["nombrePersonne"]++;
            header("Location:panier.php");
        break;


        case "suppprimerReservation":  
            unset($_SESSION['reservations'][$ref]);
            header("Location:panier.php");
        break;
    }


      

    switch($reservation['jourReservation']) {
        case 'lundi':
            $_SESSION['resultat'] = $_SESSION['menuSemaine'][0]['lundi']['plat'];
            break;
        case 'mardi':
            $_SESSION['resultat'] = $_SESSION['menuSemaine'][1]['mardi']['plat'];
            break;
        case 'mercredi':
            $_SESSION['resultat'] = $_SESSION['menuSemaine'][2]['mercredi']['plat'];
            break;
        case 'jeudi':
            $_SESSION['resultat'] = $_SESSION['menuSemaine'][3]['jeudi']['plat'];
            break;
        case 'vendredi':
            $_SESSION['resultat'] = $_SESSION['menuSemaine'][4]['vendredi']['plat'];
            break;
        case 'samedi':
            $_SESSION['resultat'] = $_SESSION['menuSemaine'][5]['vendredi']['plat'];
            break;
        case 'dimanche':
            $_SESSION['resultat'] = $_SESSION['menuSemaine'][6]['vendredi']['plat'];
            break;
    }

  
?>