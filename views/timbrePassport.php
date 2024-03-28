<?php require('../backend/security/security.php'); ?>
<?php require('../backend/controllers/passport/passportTimbreAction.php'); ?>

<!DOCTYPE html>
<html lang="fr">
<?php 
  include '../views/includes/homeHead.php';
  include '../views/assets/css/global.php';
  include '../views/assets/css/timbrePassport.php'; 
?>
<body>
  <div class="container">
    <!-- ======== Back ======== -->
    <?php include '../views/includes/back/backUp.php';?>
    <!-- ======== Alert Empty Fields ======== -->
    <?php include '../views/includes/alerts/alert_emptyFields.php';?>

    <div class="card my-4">
      <div class="card-body">
        <div class="">
          Vueillez renseignez les champs suivants

          <form method="POST" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="hidden" class="d-none" name="token" value="<?php echo $token; ?>">
            <div class="accordion accordion-flush mt-4" id="accordionFlushExample">
              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                  <i class="fa-solid fa-user me-2"></i>
                    Vos informations
                  </button>
                </h2>
                <div id="flush-collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionFlushExample">
                  <div class="accordion-body">
                    <div class="infos">
                      <span>Nom Prénoms</span>
                      <input type="text" name="names" class="form-control" placeholder="Caroline Musk">
                    </div>
                    <div class="infos date__born mt-2">
                      <span>Date de naissance</span>
                      <input type="date" name="dateBorn" class="form-control">
                    </div>
                    <div class="infos mt-2">
                      <span>Lieu de naissance</span>
                      <input type="text" name="cityBorn" class="form-control" placeholder="Shanghai">
                    </div>
                  </div>
                </div>
              </div>
              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                    <i class="fa-solid fa-user-plus me-2"></i>
                    Infos Supplémentaires
                  </button>
                </h2>
                <div id="flush-collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                  <div class="accordion-body">
                    <div class="infos">
                      <span>Ville en Russie</span>
                      <input type="text" name="city" class="form-control" placeholder="Moscou">
                    </div>
                    <div class="infos mt-2">
                      <span>N° téléphone</span>
                      <input data-mask="+7 (999) 999 99-99" id="phone_number" type="text" name="phone" class="form-control">
                    </div>
                  </div>
                </div>
              </div>
              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                    <i class="fa-solid fa-users me-2"></i>
                    Parents
                  </button>
                </h2>
                <div id="flush-collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                  <div class="accordion-body">
                    <div class="infos">
                      <span>Nom Prénom Père</span>
                      <input type="text" name="fother__name" class="form-control" placeholder="Petter Musk">
                    </div>
                    <div class="infos mt-2 mb-3">
                      <span>Nom Prénom Mère</span>
                      <input type="text" name="mother__name" class="form-control" placeholder="Ellie Cyane">
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Send Button -->
            <button name="send" class="btn mt-4 w-100">
              Envoyer
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.7/jquery.inputmask.min.js"></script>
  <?php include '../views/assets/js/home.php'; ?>

  <script>
    function format() {
      $("#phone_number").inputmask($('#phone_number').data('mask'));
    }
    format();
  </script>
</body>
</html>