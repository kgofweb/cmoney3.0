<?php
  // Session
  require('../backend/security/security.php');
  // BACKEND
  require('../backend/controllers/transaction/checkAction.php');
  // Devises
  require('../backend/devise/moneyDevise.php');
  // Convertion Logic
  require('../backend/convert/convertion.php');
?>

<!DOCTYPE html>
<html lang="fr">
<?php
  include '../views/includes/globalHead.php';
  include '../views/assets/css/global.php';
  include '../views/assets/css/check.php'; 
?>
<body>
  <div class="container">
    <!-- ======== Back ======== -->
    <div class="mt-3 fw-bold">
      <a href="./send" class="back__btn navbar-brand">
        <i class="fa-solid fa-angle-left"></i>
        Retour
      </a>
    </div>
    <!-- ========== Contact Button ========== -->
    <?php include '../views/includes/contact/contact.php'; ?>

    <h4 class="mt-2 text-center">Vérification</h4>

    <div class="my-2">
      <div class="card bg-white">
        <div class="card-body text-center">
          <div class="container">
            <!-- ========== Logic ========== -->
            <?php include '../views/includes/check/checkData.php'; ?>

            <div class="d-flex float-end mt-4">
              <button name="backToForm" class="btn btn-prev fw-bold" style="margin-right: .8rem;" data-bs-toggle="modal" data-bs-target="#staticBackdropCancel">
                Annuler
              </button>
              <button class="btn btn-next fw-bold" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                Continuer
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <form method="POST" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]);?>">
      <div class="modal fade" id="staticBackdrop"  data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content text-center">
            <div class="mt-4">
              <i class="fa-solid fa-circle-check validate__icon"></i>
            </div>
            <h4 class="fw-bold modal-title my-3">
              Votre bénéficiaire recevra: 
              <br> 
              <span class="money__get" id="total"> <?= $finalAmount; ?> </span>
            </h4>
            <!-- <span>(Tout frais inclus)</span> -->
            
            <div class="my-3">
              <button name="send" class="btn w-50 fw-bold">Valider</button>
            </div>
          </div>
        </div>
      </div>
    </form>
    <!-- Cancel -->
    <form method="POST" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]);?>">
      <div class="modal fade" id="staticBackdropCancel"  data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content text-center">
            <div class="mt-4">
              <i class="fa-sharp fa-solid fa-circle-xmark cancel__icon"></i>
            </div>
            <h5 class="fw-bold modal-title my-3">
              Voulez vous vraiment tout annuler ?
            </h5>
            <div class="my-3">
              <button name="cancel" class="btn btn-prev w-50 fw-bold">Annuler</button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</body>
</html>