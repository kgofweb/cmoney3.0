<?php require('../../backend/controllers/admin/activationAction.php'); ?>

<!DOCTYPE html>
<html lang="fr">
<?php 
  include './include/adminHead.php'; 
  include '../../views/assets/css/global.php';
  include '../../views/assets/admin/css/globalAdminCSS.php';
?>
<body>
  <div class="container">
  <div class="card mt-5">
      <div class="card-body">
        <form method="post">
          <div class="btn-prev message">
            <span>
              Id de transaction: <b> <?= $idOfTansaction; ?> </b>
            </span>
            <br>
            <span>
              Confirmer l'activation du code: <b style="font-size: 1.3rem;"> <?= $otpCode ?> </b>
            </span>
            <?php
              if (strlen($otpCode) == 8) {
                ?>
                  <div class="mt-2 d-flex align-items-center">
                    <i class="fa-solid fa-circle-exclamation me-2"></i>
                    Notez qu'il faudra effectuer directement le paiement
                  </div>
                <?php
              }
            ?>
          </div>

          <div class="float-end mt-4">
            <button name="drop_it" class="fw-bold me-2 btn btn-prev">
              Annuler
            </button>
            <button name="validate_code" class="fw-bold btn ">
              Activer
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
</html>