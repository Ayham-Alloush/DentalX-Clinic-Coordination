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

  const urlParams = new URLSearchParams(window.location.search);
  const user = urlParams.get('user');
  if(user=="exist"){
    alert("اسم المستخدم الذي أدخلته مستخدم من قبل. يرجى اختيار اسم آخر.");
  }

  // Remove the 'user' parameter from the URL
  const newUrl = window.location.href.split('?')[0]; // Remove query string
  window.history.replaceState({}, document.title, newUrl);