const fileInput = document.getElementById('fileInput');
const form = document.getElementById('myForm');

fileInput.addEventListener('change', () => {
  form.submit();
});