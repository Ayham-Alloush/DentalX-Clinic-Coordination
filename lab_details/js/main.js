  addOrderButton = document.getElementById("show-inputs") ;
  nextBtn = document.getElementById("next") ;
  cancelBtn = document.getElementById("cancel") ;
  // Get all inputs with name="count"
  const countInputs = document.querySelectorAll("input[name^='count']");

  addOrderButton.addEventListener("click", function() {

  // Loop through each input and remove (d-none) 
  for (const input of countInputs) {
    input.classList.remove("d-none") ;
  }

  // making (add-order) button invisible 
  this.classList.add("d-none");

  // making (next, cancel) buttons visible 
  nextBtn.classList.remove("d-none") ;
  cancelBtn.classList.remove("d-none") ;

  // without this function we will not see the opacity transition because of the browsers rendering.
  setTimeout(function() {
    nextBtn.style.opacity = 1 ;
    cancelBtn.style.opacity = 1 ;
  }, 0.1);
});

cancelBtn.addEventListener("click", function() {
  // Loop through each input and remove (d-none) 
  for (const input of countInputs) {
    input.classList.add("d-none") ;
  }

  // making (add-order) button visible 
  addOrderButton.classList.remove("d-none");

  // making (next, cancel) buttons invisible 
  nextBtn.classList.add("d-none") ;
  cancelBtn.classList.add("d-none") ;

  nextBtn.style.opacity = 0 ;
  cancelBtn.style.opacity = 0 ;
});

// preventing adding order if there is no items added , so we will not activate (next) button 
const form = document.getElementById("prices-form");
const errorDiv = document.getElementById("alert") ;

form.addEventListener("submit", function(event) {
  let hasPositiveValue = false;
  for (const input of countInputs) {
    if (input.value > 0) { // Check if the value is greater than 0
      hasPositiveValue = true;
      break; // Stop iterating once a positive value is found
    }
  }

  if (!hasPositiveValue) {

    // Prevent form submission if no positive value is found
    event.preventDefault();

    // Show the error div
    errorDiv.classList.remove("d-none") ;

    // we will wait 0.5s before changing alerts opacity to 0 , it will be visible for 0.5s and after
    // that it  will start to change from opacity 1 to 0  , 
    // in CSS we made transition on opacity 1s , so after 1s the alert will be disappeared , 
    // and after this 1s we made it d-none and its opacity 1 so if we repeat the process 
    // the opacity will start with 1 and not 0 . 
    setTimeout(function() {
      errorDiv.style.opacity = 0;
      setTimeout(function(){
        errorDiv.classList.add("d-none") ;
        errorDiv.style.opacity = 1 ;
      },1000)} , 500) ;
  }
});



