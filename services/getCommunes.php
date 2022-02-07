<?php
    set_include_path('..'.PATH_SEPARATOR);
    require_once('lib/common_service.php');
    require_once('lib/initDataLayer.php');
    
    try{
      $territoires = (int)$_GET['territoire'];
      $nom = $_GET['nom'];
      $surface = (float)$_GET['surface'];

      $population = (int)$_GET['population'];
      
      
      if ($territoires < 0 && isset($_GET['territoire']) ){
        produceError("territoire ou nom fourni est incorrect");
      }

      else if((!isset($_GET['territoire']) || $_GET['territoire'] ==="" ) 
      && (!isset($_GET['surface']) || $_GET['surface'] ==="" ) 
      && (!isset($_GET['nom']) || $_GET['nom'] ==="") 
      && (!isset($_GET['population']) || $_GET['population'] ==="")){
        $communes = $data->getCommunes(NULL, NULL, NULL, NULL);
      }
      
      else if((!isset($_GET['territoire']) || $_GET['territoire'] ==="" ) 
      && (!isset($_GET['surface']) || $_GET['surface'] ==="" ) 
      && (isset($_GET['nom']) || $_GET['nom'] !=="") 
      && (!isset($_GET['population']) || $_GET['population'] ==="")){
        $communes = $data->getCommunes(NULL, $nom, NULL, NULL);
    }
      
     else if((isset($_GET['territoire']) || $_GET['territoire'] !=="" ) 
     && (!isset($_GET['surface']) || $_GET['surface'] ==="" ) 
     && (!isset($_GET['nom']) || $_GET['nom'] ==="") 
     && (!isset($_GET['population']) || $_GET['population'] ==="")){
        $communes = $data->getCommunes($territoires, NULL, NULL, NULL);
      }

     else if((!isset($_GET['territoire']) || $_GET['territoire'] ==="" ) 
     && (isset($_GET['surface']) || $_GET['surface'] !=="" ) 
     && (!isset($_GET['nom']) || $_GET['nom'] ==="") 
     && (!isset($_GET['population']) || $_GET['population'] ==="")){
        $communes = $data->getCommunes(NULL, NULL, $surface, NULL);
      }
     
     else if((!isset($_GET['territoire']) || $_GET['territoire'] ==="" ) 
     && (!isset($_GET['surface']) || $_GET['surface'] ==="" ) 
     && (!isset($_GET['nom']) || $_GET['nom'] ==="") 
     && (isset($_GET['population']) || $_GET['population'] !=="")){
        $communes = $data->getCommunes(NULL, NULL, NULL, $population);
      }

      else if((!isset($_GET['territoire']) || $_GET['territoire'] ==="" ) 
      && (isset($_GET['surface']) || $_GET['surface'] !=="" ) 
      && (isset($_GET['nom']) || $_GET['nom'] !=="") 
      && (!isset($_GET['population']) || $_GET['population'] ==="")){
        $communes = $data->getCommunes(NULL, $nom, $surface, NULL);
        
      }

      else if((!isset($_GET['territoire']) || $_GET['territoire'] ==="" ) 
      && (isset($_GET['surface']) || $_GET['surface'] !=="" ) 
      && (isset($_GET['nom']) || $_GET['nom'] !=="") 
      && (isset($_GET['population']) || $_GET['population'] !=="")){
        $communes = $data->getCommunes(NULL, $nom, $surface, $population);
        
      }

      else if((isset($_GET['territoire']) || $_GET['territoire'] !=="" ) 
      && (!isset($_GET['surface']) || $_GET['surface'] ==="" ) 
      && (isset($_GET['nom']) || $_GET['nom'] !=="") 
      && (!isset($_GET['population']) || $_GET['population'] ==="")){
      $communes = $data->getCommunes($territoires, $nom, NULL, NULL);
      }
  
      else{
        $communes = $data->getCommunes($territoires, $nom, $surface, $population);
      }
       
      produceResult($communes);

    }
    catch (PDOException $e){
        produceError($e->getMessage());
    }

?>