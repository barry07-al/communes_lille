<?php
set_include_path('..'.PATH_SEPARATOR);
require_once('lib/common_service.php');
require_once('lib/initDataLayer.php');

try{

    $insee = $_GET['insee'] ;

    $result = $data->getDetails($insee) ;

    if (!isset($insee) || $insee==="" || $result===NULL) {
        produceError('Le paramètre insee fourni est incorect') ;
    }
    else {
        produceResult($result) ;
    }
}
catch (PDOException $e){
    produceError($e->getMessage());
}

?>