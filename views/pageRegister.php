<?php
/*
  Si la variable globale $erreurCreation est définie, un message d'erreur est affiché
  dans un paragraphe de classe 'message'
*/
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
  <head>
    <meta charset="UTF-8"/>
    <link rel="stylesheet" href="style/style.css" media="screen" type="text/css" />
    <script src="js/fetchUtils.js"></script>
    <script src="js/register.js"></script>
    <title>Création d'utilisateur</title>
</head>
<body>


<div id="info"></div>

<div id="container">

  <form method="POST" action="" id='forme'>
  <h2>Sign Up</h2>
  
    <fieldset>
      <label for="nom"></label>
      <input type="text" name="nom" id="nom" placeholder="Name" required="required" autofocus/>

      <label for="prenom"></label>
      <input type="text" name="prenom" id="prenom" placeholder="First Name" required="required" autofocus/>

      <label for="login"></label>
      <input type="text" name="login" id="login" placeholder="Login" required="required" autofocus/>
      
      <label for="password"></label>
      <input type="password" name="password" id="password" placeholder="Password" required="required" />

      <button type="submit" name="valid" value="bouton_valid">Sign Up</button>
    </fieldset>
  </form>
  <p>Déjà inscrit ? <a href="index.php">Authentifiez-vous</a></p>
</div>


</body>
</html>