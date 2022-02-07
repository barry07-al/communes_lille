window.addEventListener('load',initForm);
function initForm(){
  
  document.forms.forme.addEventListener("submit", sendForm);
  
}




function sendForm(ev){ // form event listener
  ev.preventDefault() ;
  let args = new FormData(this) ;
  fetchFromJson('services/createUser.php',{method:'post',body:args})
  .then(makeMessagesItems) ;
}


function makeMessagesItems(tab){
  element = document.getElementById('info') ;
  element.textContent = '' ;
  let option = document.createElement('li');
  if (tab.status == "ok"){
    option.textContent = "le login " + tab.result['login'] + " est bien créé";}
  else
     {
      option.textContent = tab.message;
    }
  

  

  element.appendChild(option);
}
  

