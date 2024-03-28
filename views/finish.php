<?php 
  require('../backend/controllers/transaction/finishAction.php');
  require('../backend/data/data.php');
?>
<!DOCTYPE html>
<html lang="fr">
<?php
  include '../views/includes/globalHead.php';
  include '../views/assets/css/global.php';
  include '../views/assets/css/finish.php'; 
?>
<body>
  <div class="container">
  	<!-- Loader -->
    <div class="load" id="load">
      <img src="../views/assets/img/loader/loaderChapMoney.gif" class="load__gif" alt="ChapMoney Online">
    </div>
    
    <h4 class="mt-4 text-center">Finalisation</h4>
    <!-- Copie Number -->
    <div class="d-flex justify-content-end mt-3">
      <div class="toast border-0" role="alert" aria-live="assertive" aria-atomic="true" style="z-index: 1000;">
        <div class="d-flex">
          <div class="toast-body d-flex align-items-center text-dark fw-bold">
            <i class="fa-solid fa-circle-check check__copy success__color"></i>
            Numéro copié !
          </div>
          <button type="button" class="btn-close btn-close-dark me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
      </div>
    </div>

    <div class="card my-3">
      <div class="card-body">
        <!-- Icons -->
        <div class="icon">
          <i class="fa-solid fa-lock validate__icon"></i>
        </div>
        <!-- ======= -->
        <div class="content">
          <?php
            if (isset($receiverCountry)) {
              if ($receiverCountry == 'russie' || $receiverCountry == 'civ' || $receiverCountry == 'mali' || $receiverCountry == 'benin' || $receiverCountry == 'burkina' || $receiverCountry == 'senegal' || $receiverCountry == 'togo' || $receiverCountry == 'cameroun' || $receiverCountry == 'gabon' || $receiverCountry == 'congo' || $receiverCountry == 'tchad' || $receiverCountry == 'centreAfrique' || $receiverCountry == 'guinee' || $receiverCountry == 'rdc' || $receiverCountry == 'niger') 
              {
                ?>
                  <span class="text">Veuillez transférer les fonds de votre compte personnel vers notre compte mentionné ci-dessous:</span>
                  <div class="message">
                    <!-- Mobile -->
                    <div>
                      <span>Mobile M.</span>
                      <span class="principal-color">
                        <?php if (isset($senderMode)) {
                          echo $senderMode;
                          }
                        ?>
                      </span>
                    </div>
                    <!-- Number Phone -->
                    <div>
                      <span>N° Tél</span>
                      <?php include '../views/includes/finish/mobileAgent.php';?>
                    </div>
                    <!-- Name Agent -->
                    <div>
                      <span>Compte</span>
                      <?php include '../views/includes/finish/numberAgent.php';?>
                    </div>
                    <!-- Montant -->
                    <div>
                      <span>Montant</span>
                      <span class="montant">
                        <?php 
                          if (isset($percentage) && isset($amount)) {
                            echo number_format($percentage + $amount, 2, ',', ' '). ' '. $change;
                          }
                        ?>
                      </span>
                    </div>
                    <div class="space"></div>
                    <div>
                      <span>Votre code</span>
                      <span class="text-primary code"><?= $verification_code; ?></span>
                    </div>
                  </div>
                  <span class="text">
                    Ensuite cliquez sur <b>dépôt effectué</b>.<br>
                    Vous bénéficiez de <b>15 minutes</b> pour l'effectuer.<br><br>
                    Passé ce délais, <b>la transaction sera automatiquement annulée !
                  </span>
                  <div class="float-end mt-4">
                    <div class="d-flex">
                      <button name="backToForm" class="btn btn-prev fw-bold" style="margin-right: .8rem;" data-bs-toggle="modal" data-bs-target="#staticBackdropCancel">
                        Annuler
                      </button>
                      <button class="btn btn-next fw-bold" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                        Depôt effectué
                      </button>
                    </div>
                  </div>
                <?php
              }
            }
          ?>
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
            <span class="mt-3">Je confirme avoir effectué un dépôt de</span>
            <span class="montant__total">
              <?php 
                if (isset($percentage) && isset($amount)) {
                  echo number_format($percentage + $amount, 2, ',', ' '). ' '. $change;
                }
              ?>
            </span>
            <span>sur le compte mentionné</span>
            <div class="my-3">
              <button name="send" class="btn btn-next w-50 fw-bold">Valider</button>
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
              <button name="back" class="btn btn-prev w-50 fw-bold">Annuler</button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
  <!-- Loader -->
  <?php include '../views/assets/js/loader.php'; ?>

  <script>
    const copyBtn = document.getElementById('copy');

    copyBtn.addEventListener('click', () => {
      const contentToCopy = document.getElementById('numberOne');
      const numberCpied = navigator.clipboard;
      numberCpied.writeText(contentToCopy.textContent)
      .then(() => {
        let myToast = document.querySelector('.toast')
        let alertToast = new bootstrap.Toast(myToast)
        alertToast.show()
      })
    });
  </script>
</body>
</html>