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

// Get the URL parameters
const urlParams = new URLSearchParams(window.location.search);

// Check if the "x" parameter exists and its value is "1"
if (urlParams.has('x') && urlParams.get('x') === '1') {
  // Display an alert indicating wrong password
  alert('Wrong password');
}

// Check if the "x" parameter exists and its value is "2"
if (urlParams.has('x') && urlParams.get('x') === '2') {
  // Display an alert indicating invalid user name
  alert('Invalid user name');
}