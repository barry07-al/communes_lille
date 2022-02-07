<?php
 
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
  <head>
    <meta charset="UTF-8"/>
    <title>Communes de la MEL</title>
    <link rel="stylesheet" type="text/css" href="style/style_td6.css" />
    <script src="js/fetchUtils.js"></script>
    <script src="js/communes.js"></script>
    <script src="js/carte.js"></script>
    <script src="js/login.js"></script>
    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
   integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
   crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
   integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
   crossorigin=""></script>

  </head>

<body>
<header>
<h1>
Communes de la MEL
</h1>
<div id="identite">
</div>
</header>


<section id="main">
  <div id="choix">
    <form id="form_communes" action="">
      <fieldset>
        <legend>Choix des communes</legend>
        <label>Territoire :
          <select name="territoire">
              <option value=""
                      data-min_lat="50.499" data-min_lon="2.789"
                      data-max_lat="50.794" data-max_lon="3.272"
              >
                Tous
              </option>
              <!-- les autres options seront crées en JS -->
          </select>
        </label>
      
        <label>Rechercher :
         <input name='nom' type='text'/>
              <!-- les autres options seront crées en JS -->
        </label>

        <label>Surface minimale :
         <input name='surface' type='text'/>
              <!-- les autres options seront crées en JS -->
        </label>

        <label>Population minimale :
         <input name='population' type='text'/>
              <!-- les autres options seront crées en JS -->
        </label>

        </fieldset>
      <button type="submit">Afficher la liste</button>
    </form>
  </div>
  <div id='carte'></div>
  <div id="Listes">
    <nav>
  <ul id="liste_communes"></ul>
</nav>
  </div>

  
  <div id="details"></div>
  <div id="infos"></div>
</section>

<footer>
</footer>
</body>
</html>