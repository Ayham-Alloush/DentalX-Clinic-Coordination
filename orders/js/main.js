const elements = document.querySelectorAll('.status');

elements.forEach(element => {
  const textContent = element.textContent.trim();

  if (textContent === 'بانتظار الموافقة') {
    element.classList.add('bg-warning');
    element.classList.add('text-black');
  } else if (textContent === 'قيد التحضير') {
    element.classList.add('bg-primary');
    element.classList.add('text-light');
  } else if (textContent === 'جاهز للتسليم') {
    element.classList.add('bg-success');
    element.classList.add('text-light');
  } else if (textContent === 'تم الرفض') {
    element.classList.add('bg-danger');
    element.classList.add('text-light');
  } else if (textContent === 'تم التسليم'){
    element.classList.add('bg-secondary');
    element.classList.add('text-light');
  }
  
});

const errorDiv = document.getElementById("alert") ;

let isProcessing = false;
function checkStatus(status,modal_id){
  if(status=="بانتظار الموافقة" || status=="تم الرفض"){
    const myModal = new bootstrap.Modal(document.getElementById(modal_id));
    myModal.show();
  }
  // displaying an alert .
  else if(!isProcessing){
      isProcessing = true  ;
      errorDiv.classList.remove("d-none") ;
      setTimeout(function() {
        errorDiv.style.opacity = 0;
        setTimeout(function(){
          errorDiv.classList.add("d-none") ;
          errorDiv.style.opacity = 1 ;
        },1000)} , 1000) ;
      setTimeout(function() {
        isProcessing = false ;
        },2000) ;
  }
}