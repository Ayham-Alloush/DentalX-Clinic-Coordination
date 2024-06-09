  "use strict" ;

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  const forms = document.querySelectorAll('.needs-validation')

  // Loop over them and prevent submission
  Array.from(forms).forEach(form => {
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.preventDefault()
        event.stopPropagation()
      }

      form.classList.add('was-validated')
    }, false)
  })




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