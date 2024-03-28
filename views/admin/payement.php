<?php require('../../backend/controllers/admin/payementAction.php'); ?>

<!DOCTYPE html>
<html lang="fr">
<?php 
  include './include/adminHead.php'; 
  include '../../views/assets/css/global.php';
  include '../../views/assets/admin/css/globalAdminCSS.php';
  include '../../views/assets/admin/css/detailsCSS.php';
?>
<body>
  <div class="container">
    <!-- ================= Error MESSAGE =================  -->
    <?php include '../../views/includes/alerts/alert_emptyFields.php'; ?>

    <div class="card my-4">
      <div class="card-body">
        <form method="POST">
          <div>
            <div>
              <h6 class="title">
                <i class="fa-solid fa-circle-exclamation"></i>
                Infos Expéditeur
              </h6>
              <div class="message__infos">
                <!-- Mode envoi -->
                <div class="mb-1">
                  Nom bénéficiaire: <span class="fw-bold"><?= $receiverNameDec ?></span>
                </div>
                <div>
                  Téléphone: <span class="fw-bold "><?= $receiverPhone; ?></span>
                </div>
              </div>
            </div>
            <div class="space"></div>
            <div>
              <div class="message__infos">
                <!-- Date de demande -->
                <div class="mb-1">
                  Date demande: <span class="fw-bold"><?= $date; ?></span>
                </div>
                <div>
                  Code: <span class="fw-bold "><?= $code; ?></span>
                </div>
              </div>
            </div>
            <div class="space"></div>
            <div>
              <h6 class="title">
                <i class="fa-solid fa-circle-exclamation"></i>
                Demande de retrait
              </h6>
              <div class="message__infos">
                <!-- Mode envoi -->
                <div class="mb-1">
                  Banque: <span class="fw-bold"><?= $bankChooseByUser ?></span>
                </div>
                <!-- Banque de retrait AUTRE -->
                <?php
                  if (isset($bankChooseByUser)) {
                    if ($bankChooseByUser == 'Autre') {
                      ?>
                        <span class="d-flex align-items-center mb-2">
                            Nom: <span class="fw-bold mx-2">
                              <?= $banqueNameTypedByUser; ?>
                            </span>
                        </span>
                      <?php
                    }
                  }
                ?>
                <!-- Name -->
                <div class="mb-1">
                  Nom: <span class="fw-bold "><?= $nameUser ?></span>
                </div>
                <!-- Tel -->
                <div class="mb-1">
                  Téléphone: <span class="fw-bold "><?= $numberPhone ?></span>
                </div>
              </div>
            </div>

            <!-- Montant -->
            <div class="mb-1 text-center mt-3">
              <i class="fa-solid fa-sack-dollar" style="font-size: 1.4rem; color: #27ae60;"></i>
              <div>Montant à transférer:</div>
              <div class="fw-bold" style="font-size: 1.3rem; color: #27ae60;">
                <?= number_format($amountRouble, 2, ',', ' '). ' <i class="fa-solid fa-ruble-sign"></i>' ?>
              </div>
            </div>

            <!-- ============== Choix du Payeur ============== -->
            <div class="space"></div>
            <div class="payer">
              <h6 class="title">
                <i class="fa-solid fa-circle-exclamation"></i>
                Choix Agent Payeur
              </h6>

              <form method="POST">
                <?php
                  if (!$payer_agent) {
                    ?>
                      <select name="payer_agent_name" class="form-select form-select-sm">
                        <option value=""></option>
                        <?php
                          if ($getAllAgentName->rowCount() > 0) {
                            while ($fetch_res = $getAllAgentName->fetch(PDO::FETCH_ASSOC)) {
                              $payer_name = $fetch_res['account_name'];
                              ?>
                                <option value="<?= $payer_name; ?>"><?= $payer_name; ?></option>
                              <?php
                            }
                          } 
                          // Set chapmoney accoount to payer
                          if ($getAllAgentNamePayeur->rowCount() > 0) {
                            while ($fetch_resP = $getAllAgentNamePayeur->fetch(PDO::FETCH_ASSOC)) {
                              $payer_nameP = $fetch_resP['account_name'];
                              ?>
                                <option value="<?= $payer_nameP; ?>"><?= $payer_nameP; ?></option>
                              <?php
                            }
                          }
                        ?>
                      </select>
                    <?php
                  }
                ?>
                <div class="float-end mt-4">
                  <?php
                    if (!$payer_agent) {
                      ?>
                        <button name="back" class="btn btn-prev fw-bold me-2">Annuler</button>
                        <button name="validate_payement" class="btn fw-bold">
                          Effectuer
                        </button>
                      <?php
                    } else {
                      ?>
                        <button name="back" class="btn btn-prev fw-bold me-2">Retour</button>
                        <button class="btn fw-bold disabled">Transféré</button>
                      <?php
                    }
                  ?>
                </div>
              </form>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>

<script>
  window.onload = (event) => {
    let myToast = document.querySelector('.toast');
    let alertToast = new bootstrap.Toast(myToast);
    alertToast.show();
  }
</script>
</html>