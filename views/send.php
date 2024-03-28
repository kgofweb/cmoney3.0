<?php require ('../backend/controllers/transaction/transfertAction.php'); ?>

<!DOCTYPE html>
<html lang="fr">
<?php include '../views/includes/sendHead.php'; ?>
<?php include '../views/assets/css/global.php'; ?>
<?php include '../views/assets/css/transaction.php'; ?>
<body>
  <div class="container">
    <!-- ======== Back ======== -->
    <?php include '../views/includes/back/backUp.php';?>
    <!-- ======== Alert Empty Fields ======== -->
    <?php include '../views/includes/alerts/alert_emptyFields.php';?>

    <div class="mt-4 text">
      En cas de préoccupation, <b>veuillez contacter l'assistance</b>
    </div>
    
    <!-- ======== Menu Transaction ======== -->
    <div class="cards justify-content-center mt-4">
      <div class="row row-cols justify-content-center">
        <!-- Envoi -->
        <div class="col">
          <div class="card send mb-3">
            <div class="card-body">
              <h6 class="text-start">
                <i class="icon fas fa-exchange-alt"></i>
                <b>Envoi</b>
              </h6>
              <div>
                <img src="../views/assets/img/transfert-money.jpg" alt="ChapMoney Online">
              </div>
              <a href="./sendTransaction" class="btn float-end">
                <i class="fa-solid fa-angle-right"></i>
              </a>
            </div>
          </div>
        </div>
        <!-- Retrait -->
        <div class="col">
          <div class="card receive mb-3">
            <div class="card-body">
              <h6 class="text-start">
                <i class="fa-solid fa-sack-dollar"></i>
                <b>Retrait</b>
              </h6>
              <div>
                <img src="../views/assets/img/receive.webp" alt="ChapMoney Online">
              </div>
              <a href="./receive" class="btn float-end">
                <i class="fa-solid fa-angle-right"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ========== Contact Button ========== -->
    <?php include '../views/includes/contact/contact.php'; ?>

  </div>

  <script src="../views/assets/js/scrollreveal.min.js"></script>

  <script>
    const sr = ScrollReveal({
      distance: '60px',
      duration: 1300
    });
    sr.reveal(`.text`, { origin: 'top', delay: 300 })
    sr.reveal(`.send`, { origin: 'top', delay: 400 })
    sr.reveal(`.receive`, { origin: 'top', delay: 500 })
  </script>

</body>
</html>