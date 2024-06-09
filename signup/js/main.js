function validateForm(){
  var checkboxes = document.querySelectorAll('input[type="radio"]');
  var checked = false;
  var feed = document.getElementById('options') ;
  
  for (var i = 0; i < checkboxes.length; i++) {
    if (checkboxes[i].checked) {
      checked = true;
      break;
    }
  }
  
  if (!checked) {
    feed.classList.add('d-block');
    return false;
  }
  
  return true;
}