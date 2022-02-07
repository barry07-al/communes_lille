<?php
    session_name('ident') ;
    session_start() ;
    set_include_path('..'.PATH_SEPARATOR);
    require_once('lib/common_service.php');
    require_once('lib/initDataLayer.php');
    require_once('lib/fonctions_parms.php');

    
    try {

        $login = checkUnsignedString('login') ;
        $password = checkUnsignedString('password') ;

        $res = $data->authentification($login,$password) ;

        if($res===NULL) {
            produceError("login ou password incorrect") ;
        }

        else if(isset($_SESSION['ident'])){
            produceError("Utilisateur déjà connecté") ;
        }

        else{
            produceResult($res) ;
            $_SESSION['ident'] = $res ;
        }

    }
    catch(ParmsException $e) {
        produceError("l'un des paramètre est incorrect ou manquant") ;
    }

?>