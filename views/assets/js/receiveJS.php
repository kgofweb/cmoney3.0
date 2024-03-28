<script>
  window.onload = (event) => {
    let myToast = document.querySelector('.toast')
    let alertToast = new bootstrap.Toast(myToast)
    alertToast.show()
  }

  function move(e, p, c, n) {
    const length = document.getElementById(c).value.length;
    const maxlength = document.getElementById(c).getAttribute('maxlength');

    // Next input
    if (length == maxlength) {
      if (n !== '') {
        document.getElementById(n).focus();
      }
    }
    // Remove
    if (e.key === 'Backspace') {
      if (p !== '') {
        document.getElementById(p).focus();
      }
    }
  }

  (function() {
    $("#phone_number").inputmask($('#phone_number').data('mask'));
  })()
</script>