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
  if(status=="بانتظار الموافقة" || status=="تم الرفض" || status=="تم التسليم"){
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

// enabling tooltips
const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

// displaying info icon when status is "تم الرفض" .
const infoIcons = document.querySelectorAll('.reject-reason');

infoIcons.forEach(icon => {
  const status = icon.dataset.status ;
  if (status === 'تم الرفض') {
    icon.classList.remove("d-none") ;
  }
});

// selecting all cards footers , each card footer has data-status=status 
const cards_footers = document.querySelectorAll('.order-footer');

// we will make just one button visible depending on status .
cards_footers.forEach(card_footer => {
  const status = card_footer.dataset.status;
  const cancel_form = card_footer.querySelector('#cancelForm');
  const remove_form = card_footer.querySelector('#removeForm');

  if (status === 'تم التسليم' || status === 'تم الرفض') {
    remove_form.classList.remove('d-none');
  } else{
    cancel_form.classList.remove('d-none');
  }  
});