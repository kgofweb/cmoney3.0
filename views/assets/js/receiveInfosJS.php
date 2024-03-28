<script>
  window.onload = (event) => {
    let myToast = document.querySelector('.toast');
    let alertToast = new bootstrap.Toast(myToast);
    alertToast.show();
  }

  (function() {
    $("#number_phone_withdrawal").inputmask($('#number_phone_withdrawal').data('mask'));
  })()

  const bankField = document.getElementById('bank_field')
  const numberPhoneField = document.getElementById('number_phone_field')
  const nameField = document.getElementById('name_field')
  const commentsField = document.getElementById('comments_field')

  bankField.addEventListener('change', () => {
    switch (bankField.options[bankField.selectedIndex].value) {
      case 'SberBank':
        numberPhoneField.style.display = 'block'
        nameField.style.display = 'block'
        commentsField.style.display = 'none'
        break;
      case 'VTB':
        numberPhoneField.style.display = 'block'
        nameField.style.display = 'block'
        commentsField.style.display = 'none'
        break;
      case 'Tinkoff':
        numberPhoneField.style.display = 'block'
        nameField.style.display = 'block'
        commentsField.style.display = 'none'
        break;
      case 'PotchtaBank':
        numberPhoneField.style.display = 'block'
        nameField.style.display = 'block'
        commentsField.style.display = 'none'
        break;
      case 'Autre':
        numberPhoneField.style.display = 'block'
        nameField.style.display = 'block'
        commentsField.style.display = 'block'
        break;
      default:
        numberPhoneField.style.display = 'none'
        nameField.style.display = 'none'
        commentsField.style.display = 'none'
        break;
    }
  })
</script>