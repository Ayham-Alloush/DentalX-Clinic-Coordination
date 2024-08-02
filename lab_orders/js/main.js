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
  }
});

// selecting all cards footers , each card footer has data-status=status 
const cards_footers = document.querySelectorAll('.change-status');

// we will make just one button visible depending on status .
cards_footers.forEach(card_footer => {
  const status = card_footer.dataset.status;
  const confirm_form = card_footer.querySelector('#confirm-form');
  const ready_form = card_footer.querySelector('#ready-form');
  const waiting_deliver_button = card_footer.querySelector('#waiting-deliver');

  if (status === 'بانتظار الموافقة') {
    confirm_form.classList.remove('d-none');
  } else if (status === 'قيد التحضير') {
    ready_form.classList.remove('d-none');
  } else {
    waiting_deliver_button.classList.remove('d-none') ;
  }
});
