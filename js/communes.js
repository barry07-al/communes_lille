
window.addEventListener('load',initForm);
function initForm(){
  fetchFromJson('services/getTerritoires.php')
  .then(processAnswer)
  .then(makeOptions);
  
  document.forms.form_communes.addEventListener("submit", sendForm);
  
  // dÃ©commenter pour le recentrage de la carte :
  document.forms.form_communes.territoire.addEventListener("change",function(){
    centerMapElt(this[this.selectedIndex]);
  });
}


function processAnswer(answer){
  if (answer.status == "ok") 
    return answer.result;
  else
    throw new Error(answer.message);
}


function makeOptions(tab){
  for (let territoire of tab){  
    let option = document.createElement('option');
    option.textContent = territoire.nom;
    option.value = territoire.id;
    document.forms.form_communes.territoire.appendChild(option);
    for (let k of ['min_lat','min_lon','max_lat','max_lon']){
      option.dataset[k] = territoire[k];
    }
  }
}


function sendForm(ev){ // form event listener
  ev.preventDefault() ;
  let args = new FormData(this) ;
  queryString = new URLSearchParams(args).toString() ;
  let url = 'services/getCommunes.php?' + queryString ;
  fetchFromJson(url)
  .then(processAnswer)
  .then(makeCommunesItems) ;
}


function makeCommunesItems(tab){
  element = document.getElementById('liste_communes') ;
  element.textContent = '' ;
  for (let commune of tab){
    let li = document.createElement('li') ;
    let button = document.createElement("button") ;
    button.type = "submit" ;
    button.textContent = "+" ;
    //button.className = "check" ;
    
    li.textContent = commune.nom ;
   // li.value = commune.id ;
   // document.forms.form_communes.commune.appendChild(li) ;
    element.appendChild(li) ;
    element.appendChild(button) ;

    for (let k of ['insee','min_lat','min_lon','max_lat','max_lon']){
      li.dataset[k] = commune[k] ;
      
    }
    button.dataset['insee'] = commune['insee'] ;

    li.addEventListener('mouseover',function(){
      centerMapElt(li)
    }) ;
    //button.addEventListener("submit",checkFavoris) ;
    li.addEventListener('click',fetchCommune) ;

    button.addEventListener('click',addFavoris)
    
  }
  
}

function fetchCommune(){
  let url = 'services/getDetails.php?insee='+this.dataset.insee ;
  fetchFromJson(url)
  .then(processAnswer)
  .then(displayCommune) ;
}

function displayCommune(commune){
  info = document.getElementById('details') ;
  info.textContent = 'Informations' ;

  let li1 = document.createElement('li') ;
  let li2 = document.createElement('li') ;
  let li3 = document.createElement('li') ;
  let li4 = document.createElement('li') ;
  let li5 = document.createElement('li') ;
  let li6 = document.createElement('li') ;
  let li7 = document.createElement('li') ;
  let li8 = document.createElement('li') ;

  li1.textContent = "Insee : " + commune.insee ;
  li2.textContent = "Nom de la commune : " + commune.nom ;
  li3.textContent = "Nom du territoire : " + commune.nom_terr;
  li4.textContent = "Surface : " + commune.surface ;
  li5.textContent = "Perimetre : " + commune.perimetre ;
  li6.textContent = "Latitude : " + commune.lat ;
  li7.textContent = "Longitude : " + commune.lon ;
  li8.textContent = "Population totale : " + commune.pop2016 ;

  info.appendChild(li1) ;
  info.appendChild(li2) ;
  info.appendChild(li3) ;
  info.appendChild(li4) ;
  info.appendChild(li5) ;
  info.appendChild(li6) ;
  info.appendChild(li7) ;
  info.appendChild(li8) ;

  //elem = document.getElementById('carte') ;
  createDetailMap(commune) ;

}

/**
 * Recentre la carte principale autour d'une zone rectangulaire
 * elt doit comporter les attributs dataset.min_lat, dataset.min_lon, dataset.max_lat, dataset.max_lon, 
 */
function centerMapElt(elt){
  let ds = elt.dataset;
  map.fitBounds([[ds.min_lat,ds.min_lon],[ds.max_lat,ds.max_lon]]);
}


function getFavoris() {
  fetchFromJson('services/getFavoris.php')
  .then(processAnswer)
  .then(loadFavori) ;
} 

function loadFavori(ev) {
  var element = document.getElementById("infos") ;
  element.textContent = "Villes favorites" ;
  var ul = document.createElement("ul") ;
  ul.setAttribute('id',"villesfavorites") ;
  for (let commune of ev){
    let li = document.createElement('li') ;
    let remove = document.createElement("button") ;
    remove.type = "submit" ;
    remove.textContent = "-" ;
    remove.className = "check" ;
    
    li.textContent = commune.nom ;
   // li.value = commune.id ;
   // document.forms.form_communes.commune.appendChild(li) ;
    

    ul.appendChild(li) ;
    ul.appendChild(remove) ;

    for (let k of ['insee','min_lat','min_lon','max_lat','max_lon']){
      li.dataset[k] = commune[k] ;
    }

    remove.dataset['insee'] = commune['insee'] ;
    li.addEventListener('mouseover',function(){
      centerMapElt(li)
    }) ;
    //button.addEventListener("submit",checkFavoris) ;
    li.addEventListener('click',fetchCommune) ;
    
    remove.addEventListener("click",removeFavoris) ;


  }
  element.appendChild(ul) ;
}

/*
function checkFavoris(button) {
  button.preventDefault() ;
  if (button.className != "check") {
    addFavoris(button.parentNode) ;
    button.className = "check" ;
  }
  else {
    removeFavoris(button.parentNode) ;
    button.className = "" ;
  }
}*/

function addFavoris() {
  fetchFromJson('services/addFavori.php?insee='+this.dataset.insee)
  .then(processAnswer) ;
  getFavoris() ;
}

function removeFavoris(){
  fetchFromJson('services/removeFavori.php?insee='+this.dataset.insee)
  .then(processAnswer) ;
  getFavoris() ;
}

/*
function recharger() {
  setTimeout(() => {
    fetchFromJson('services/getFavoris.php')
    .then(processAnswer)
    .then(loadFavori) ;
    recharger() ;
  },1000)
}

function processAnswerforRecharger(answer) {
  if (answer.status == "ok") {
    recharger() ;
    return answer.result ;
  }
  else {
    throw new Error(answer.message) ;
  }
}*/