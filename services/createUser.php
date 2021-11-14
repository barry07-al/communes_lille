<?php
    set_include_path('..'.PATH_SEPARATOR);
    require_once('lib/common_service.php');
    require_once('lib/initDataLayer.php');
    require_once('lib/fonctions_parms.php');

   

    try {

        $login = checkUnsignedString('login') ;
        $password = checkUnsignedString('password') ;
        $nom = checkUnsignedString('nom') ;
        $prenom = checkUnsignedString('prenom') ;

        $res = $data->createUser($login,$password,$nom,$prenom) ;

        if (!$res) {
            produceError('Le login utilisé existe déjà') ;
        }
        else {
            produceResult(['login'=>$login]) ;
        }
        
    }

    catch (ParmsException $e){
        produceError("l'un des paramètres est incorrect ou manquant") ;
    }

?>