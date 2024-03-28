<script>
  window.onload = (event) => {
    let myToast = document.querySelector('.toast')
    let alertToast = new bootstrap.Toast(myToast)
    alertToast.show()
  }

  const sr = ScrollReveal({
    distance: '60px',
    duration: 1300
  });
  sr.reveal(`.logo`, { origin: 'top', delay: 300 })
  sr.reveal(`.title`, { origin: 'top', delay: 400 })
  sr.reveal(`.send`, { origin: 'top', delay: 500 })
  sr.reveal(`.receive`, { origin: 'top', delay: 600 })
  sr.reveal(`.tracker`, { origin: 'bottom', delay: 650 })
  sr.reveal(`.helps`, { origin: 'bottom', delay: 750 })
  sr.reveal(`.footer`, { origin: 'bottom', delay: 850 })
</script>