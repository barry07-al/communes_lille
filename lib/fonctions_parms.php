<?php
 //require(__DIR__."/color_defs.php"); // definit la constante COLOR_KEYWORDS

 /**
  *  prend en compte le paramètre $name passé en mode GET
  *   qui doit représenter une couleur CSS
  *  @return : valeur retenue
  *   - si le paramètre est absent ou vide, renvoie  $defaultValue
  *   - si le paramètre est incorrect, déclenche une exception ParmsException
  *
  */
  /*
 function checkColor(string $name, string $defaultValue) : string {
     if (preg_match(COLOR_REGEXP,$_GET[$name])==1 || $_GET[$name]=="transparent") {
          return $_GET[$name] ;
     }

     elseif (isset(COLOR_KEYWORDS[$_GET[$name]])) {
          return COLOR_KEYWORDS[$_GET[$name]] ;
     }

     elseif (isset($_GET[$name])==false || $_GET[$name]=="") {
          return $defaultValue ;
     }
     
     else {
          throw new ParmsException ;
     }
  }
  
 /**
  *  prend en compte le paramètre $name passé en mode GET
  *   qui doit représenter un entier sans signe
  *  @return : valeur retenue, convertie en int.
  *   - si le paramètre est absent ou vide, renvoie  $defaultValue
  *   - si le paramètre est incorrect, déclenche une exception ParmsException
  *
  */
  /*
  function checkUnsignedInt(string $name, ?int $defaultValue=NULL, bool $mandatory=TRUE) : ?int {
	if ((isset($_GET[$name])==false || $_GET[$name]=="") && $defaultValue==NULL && $mandatory==TRUE) {
		throw new ParmsException ;
	}
	else if ((isset($_GET[$name])==false || $_GET[$name]=="") && $defaultValue==NULL && $mandatory==FALSE) {
		return NULL ;
     }
     else if (isset($_GET[$name])==false || $_GET[$name]=="") {
          return $defaultValue ;
     }
	else if (ctype_digit($_GET[$name])){
		return (int) ($_GET[$name]) ;
     }
     else {
          throw new ParmsException ;
     }
 }

 /**
  *  prend en compte le paramètre $name passé en mode GET
  *   qui doit représenter un string
  *  @return : valeur retenue.
  *   - si le paramètre est absent ou vide, renvoie  NULL
  *
  */
 function checkUnsignedString(string $name) { 
     if (!(isset($_POST[$name])) || trim($_POST[$name])==""){
          throw new ParmsException ;
     }
     else {
          return trim($_POST[$name]) ;
     }
}


 /**
  *  prend en compte le paramètre $name passé en mode GET
  *   qui doit représenter un string
  *  @return : valeur retenue.
  *   - si le paramètre est absent ou vide, renvoie  NULL
  *
  */
 function checkUnsigned(string $name) { 
     if (!(isset($_GET[$name])) || $_GET[$name]==""){
          throw new ParmsException ;
     }
     else {
          return $_GET[$name] ;
     }
}
?>