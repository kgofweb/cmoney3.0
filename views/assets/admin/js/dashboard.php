<script>
  $(document).ready(function () {
    $('#example').DataTable({
      "pagingType": "full_numbers",
      "lengthMenu": [
        [6, 25, 50, -1],
        [10, 25, 50, "All"]
      ],
      responsive: true,
      language: {
        search: "_INPUT_",
        searchPlaceholder: 'Search'
      }
    });
  });

  window.onload = (event) => {
    let myToast = document.querySelector('.toast')
    let alertToast = new bootstrap.Toast(myToast)
    alertToast.show()
  }
</script>