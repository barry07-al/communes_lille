<?php
    session_name('ident') ;
    session_start() ;
    set_include_path('..'.PATH_SEPARATOR);
    require_once('lib/common_service.php');
    require_once('lib/initDataLayer.php');
    require_once('lib/fonctions_parms.php');

    if (isset($_SESSION['ident'])) {
        produceResult($_SESSION['ident']) ;
    }
    else {
        produceError("Personne n\'est connecté") ;
    }

?>