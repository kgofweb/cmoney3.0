<?php require('../backend/controllers/transaction/verifyAction.php');?>

<html lang="fr">
<?php
  include '../views/includes/globalHead.php';
  include '../views/assets/css/global.php';
  include '../views/assets/css/verify.php'; 
?>
<body>
  <div class="container">
    <?php include '../views/includes/alerts/alert_success.php'; ?>
    <div class="card my-5">
      <div class="card-body text-center">
        <form method="POST" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]);?>">
          <div class="card-title">
            <i class="fa-solid fa-clock icon"></i>
            <h5 class="fw-bold my-3">En cours de vérification</h5>
          </div>
          <div class="message">
            <?php
              if (isset($receiverCountry)) {
                if ($receiverCountry == 'russie') {
                  ?>
                    <div class="text">
                      <div>
                        Le système vérifiera la réception des fonds automatiquement et rendra <b>valide</b> le code de retrait au bout de <b>5 minutes.</b>
                      </div>
                      <div class="mb-2 fw-bold" style="font-size: 1.2rem;">
                        <?php
                          if (isset($verify_code)) {
                            echo $verify_code;
                          }
                        ?>
                      </div>
                      <div>
                        Remettez le code au bénéficiaire pour qu'il puisse effectuer son retrait via Chapmoney Online.
                      </div>
                    </div>
                  <?php
                } else {
                  ?>
                    <div class="text">
                      Le système vérifiera automatiquement <b>la réception des fonds</b> et votre bénéficiaire les recevra au bout de <b>5 minutes</b>.
                      
                      <div class="mb-2 fw-bold" style="font-size: 1.2rem;">
                        <?php
                          if (isset($verify_code)) {
                            echo $verify_code;
                          }
                        ?>
                      </div>
                    </div>
                  <?php
                }
              }
            ?>
          </div>
          <div>
            <!-- Back home -->
            <button name="backToHome" class="btn fw-bold">Terminer</button>
            <!--<button id="pdf" class="btn fw-bold" data-bs-toggle="modal" data-bs-target="#staticBackdrop">-->
            <!--  Reçu-->
            <!--</button>-->
          </div>
        </form>
      </div>
    </div>

    <!-- Recu -->
    <?php include '../views/includes/checkNotion/recu.php'; ?>
  </div>
  
  <script src="../views/includes/checkNotion/html2pdf.bundle.min.js"></script>

  <?php require '../views/includes/checkNotion/recuJS.php'; ?>
</body>
</html>