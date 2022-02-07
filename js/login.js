window.addEventListener('load',initForm);
function initForm(){
  fetchFromJson('services/check.php')
  .then(processCheckAnswer) ;
  
}

function makeLoginForm() {
    div = document.getElementById("identite") ;
    div.innerHTML = "" ;
    var fieldset = document.createElement("fieldset") ;
    var login = document.createElement("input") ;
    login.setAttribute("type", "text") ;
    login.setAttribute("name", "login") ;
    login.setAttribute("required", "required") ;
    login.setAttribute("placeholder", "login") ;
    login.setAttribute("id","login") ;

    var password = document.createElement("input") ;
    password.setAttribute("type", "password") ;
    password.setAttribute("name", "password") ;
    password.setAttribute("required", "required") ;
    password.setAttribute("placeholder", "password") ;
    password.setAttribute("id","password") ;

    var inscription = document.createElement("p") ;
    inscription.textContent = "Pas encore inscrit ? " ;
    var element = document.createElement("a") ;
    element.setAttribute("href","register.php") ;
    element.textContent = "Créer un compte" ;

    inscription.appendChild(element) ;

    var button = document.createElement("button") ;
    button.setAttribute("type", "submit") ;
    //button.setAttribute("name", "valid") ;
    //button.setAttribute("id","submit") ;
    button.textContent = "connexion" ;

    form = document.createElement("form") ;
    form.setAttribute("method","post") ;
    form.setAttribute("action","") ;

    fieldset.appendChild(login) ;
    fieldset.appendChild(password) ;
    form.appendChild(fieldset) ;
    form.appendChild(button) ;
    div.appendChild(form) ;
    div.appendChild(inscription) ;

    form.addEventListener("submit",sendFormLogin) ;

    document.getElementById("infos").textContent = "" ;
}

function makeLogoutForm(user) {
  
  div = document.getElementById("identite") ;
  div.innerHTML = "" ;
  var res = document.createElement("p") ;
  res.textContent = user.nom + " " + user.prenom + "  " + "(" + user.login + ")  " ;

  var disconnect = document.createElement("button") ;
  disconnect.setAttribute("type", "submit") ;
  //disconnect.setAttribute("name", "valid") ;
  disconnect.setAttribute("id","submit") ;
  disconnect.textContent = "Deconnexion" ;

  div.appendChild(res) ;
  var form = document.createElement("form") ;
  //forme.setAttribute("method","") ;
  //forme.setAttribute("action","") ;
  form.appendChild(disconnect) ;
  div.appendChild(form) ;

  getFavoris() ;
  form.addEventListener("submit",sendFormLogout) ;
}


function processAnswer(tab) {
  if (tab.status == "ok"){
    return tab.result ;
  }
  else {
    throw new Error(tab.message) ;
  }
}

function processAnswerlogout(tab) {
  if (tab.status == "ok") {
    makeLoginForm() ;
  }
  else{
    throw new Error(tab.message) ;
  }
}

function processCheckAnswer(tab) {
  if (tab.status == "ok") {
    makeLogoutForm(tab.result) ;
  }
  else {
    makeLoginForm() ;
  }
}

function sendFormLogin(user) {
  user.preventDefault() ;
  let args = new FormData(this) ;
  fetchFromJson('services/login.php', {method:"post",body:args})
  .then(processAnswer)
  .then(makeLogoutForm) ;
}

function sendFormLogout(ev) {
  ev.preventDefault() ;
  fetchFromJson('services/logout.php')
  .then(processAnswerlogout) ;
}