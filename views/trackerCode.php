<?php require('../backend/controllers/transaction/trackerCodeAction.php'); ?>

<!DOCTYPE html>
<html lang="fr">
<?php
  include '../views/includes/globalHead.php';
  include '../views/assets/css/global.php';
?>
<style>
  .card {
    width: 40%; 
    margin: auto;
    border: none;
  }
  @media screen and (max-width: 767px) {
    .card {
      width: 100%;
      margin: auto;
    }
  }
</style>
<body>
  <div class="container">
    <!-- ========= Back ========= -->
    <div class="mt-4">
      <a href="./tracker" class="back__btn navbar-brand" style="font-weight: bold;">
        <i class="fa-solid fa-angle-left"></i>
        Retour
      </a>
    </div>

    <div class="card my-4">
      <div class="card-body">
        <form method="POST">
          <div class="container">
            <div class="card-title">
              <h5 class="d-flex align-items-center">
                <i class="icon fa-solid fa-location-crosshairs me-2"></i>
                Etat du code
              </h5>
              <hr>
            </div>
            <?php
              if (isset($errorMessage)) {
                ?>
                  <div class="alert alert-danger fw-bold alert-dismissible fade show" role="alert">
                    <?php echo $errorMessage; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
                <?php
              }
            ?>

            <div class="field mb-3">
              <span class="fw-bold">Votre code</span>
              <input name="code" type="text" class="form-control" style="border: none; background-color: #ecf0f1; border-radius: .5rem;">
            </div>

            <?php
              if (isset($codeVerified)) {
                ?>
                  <div>
                    <div class="filed mb-3">
                      <span class="fw-bold">Statut</span>
                      <div class="status_field mt-1">
                        <span id="status" class="fw-bold"></span>
                      </div>
                    </div>
                    <div class="filed">
                      <span class="fw-bold">Date d'activation</span>
                      <div class="status_field mt-1">
                        <?= $codeVerified ?>
                      </div>
                    </div>
                  </div>

                  <script>
                    document.querySelector('.field').style.display = 'none';
                    document.getElementById('status').innerHTML = '<i class="fa-solid fa-circle-check"></i> Code activé';
                    document.getElementById('status').style.color = '#20bf6b';
                  </script>
                <?php
              } else if (isset($codeNotVerified)) {
                ?>
                  <div>
                    <div class="filed mb-3">
                      <span class="fw-bold">Statut</span>
                      <div class="status_field mt-1">
                        <span id="status" class="fw-bold"></span>
                      </div>
                    </div>
                  </div>

                  <script>
                    document.querySelector('.field').style.display = 'none';
                    document.getElementById('status').innerHTML = '<i class="fa-solid fa-circle-minus"></i> En cours de vérification';
                    document.getElementById('status').style.color = '#fc5c65';
                  </script>
                <?php
              }
            ?>

            <!-- Button actions -->
            <div class="mt-3">
              <?php
                if (isset($codeVerified)) {
                  ?>
                    <?php
                      if (strlen($codeVerifiedAtHeight) == '8') {
                        ?>
                          <a href="./tracker" class="btn fw-bold w-100 mt-3">Vérifier le paiement</a>
                        <?php
                      } else {
                        ?>
                          <a href="./receive" class="btn fw-bold w-100 mt-3">Procéder au retrait</a>
                        <?php
                      }
                    ?>
                  <?php
                } else if (isset($codeNotVerified)) {
                  ?>
                    <a href="./home" class="btn btn-prev fw-bold w-100 mt-3">
                      Retour au menu
                    </a>
                  <?php
                } else {
                  ?>
                    <button name="code_status" class=" btn fw-bold w-100 mt-3">
                      Vérifier
                    </button>
                  <?php
                }
              ?>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
</html>