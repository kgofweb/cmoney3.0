<script>
  window.onload = (event) => {
    let myToast = document.querySelector('.toast');
    let alertToast = new bootstrap.Toast(myToast);
    alertToast.show();
  }

  // DOM Elements
  const pdfDownload = document.getElementById('pdf');
  const downloadPDF = document.getElementById('download-pdf');
  const checkDownload = document.getElementById('checkNotion');

  pdfDownload.addEventListener('click', (event) => {
    event.preventDefault();
  });

  // Options
  const opt = {
    margin: 10,
    filename: 'reçuChapmoney.pdf',
    image: { type: 'jpeg', quality: 5 },
    html2canvas: { scale: 2 },
    jsPDF: { format: 'a5', orientation: 'portrait' }
  };

  // Generate pdf
  function generateCheck() {
    html2pdf(checkDownload, opt);
  }
  downloadPDF.addEventListener('click', () => {
    generateCheck();
  });
</script>