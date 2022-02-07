<?php
    session_name('ident') ;
    session_start() ;
    set_include_path('..'.PATH_SEPARATOR);
    require_once('lib/common_service.php');
    require_once('lib/initDataLayer.php');
    require_once('lib/fonctions_parms.php');

    try {

        $login = $_SESSION['ident']['login'] ;
        if ($login === NULL) {
            produceError("Utilisateur non connecté") ;
        }
        else {
            $res = $data->getFavoris($login) ;
            produceResult($res) ;
        }
    }
    catch(ParmsException $e) {
        produceError("Le login est inéxistant") ;
    }
?>