<?php require('../../backend/controllers/admin/detailsAction.php'); ?>

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
    <!-- Back btn -->
    <div class="mt-2">
      <a href="./dashboard" class="navbar-brand fw-bold">
        <i class="fa-solid fa-angle-left"></i>
        Retour
      </a>
    </div>

    <!-- Error messages -->
    <?php include '../../views/includes/alerts/alert_emptyFields.php'; ?>

    <!-- Infos Div -->
    <div class="card my-3">
      <div class="card-body">
        <div class="d-flex justify-content-between mb-2">
          <div>
            Date: 
            <span class="fw-bold">
              <?= $dateTransaction; ?>
            </span>
          </div>
          <div>
            Heure: 
            <span class="fw-bold">
              <?= $timeTransaction; ?>
            </span>
          </div>
        </div>
        <div class="message">
          <div>
            <!-- id -->
            <div>Transaction: <span class="fw-bold"><?= $idTransaction; ?></span></div>
            <!-- Status paiement -->
            <div>
              Paiement: <span class="fw-bold fs-6" style="color: #05c46b;">
                <?php 
                  if (isset($details['status_payement'])) {
                    echo '<i class="fa-solid fa-circle-check" style="font-size: 1.1rem;"></i>';
                  } else if (isset($code)) {
                    if (strlen($code) == 8) {
                      echo '<i class="fa-solid fa-circle-check" style="font-size: 1.1rem;"></i>';
                    } else {
                      echo '<i class="fa-solid fa-circle-minus" style="font-size: 1.1rem; color: #e66767;"></i>';
                    }
                  }
                ?>
              </span>
            </div>
          </div>
          <div>
            <!-- Code -->
            <div>
              <div>
                Code: <span class="text-primary fw-bold "><?= $code ?></span>
              </div>
            </div>
            <!-- Status activation code -->
            <div>
              Activation: <span class="fw-bold fs-6">
              <?php if (isset($details['number_verified'])) {
                echo '<i class="fa-solid fa-circle-check" style="font-size: 1.1rem; color: #05c46b;"></i>';
              } else {
                echo '<i class="fa-solid fa-circle-minus" style="font-size: 1.1rem; color: #e66767;""></i>';
              } ?>
              </span>
            </div>
          </div>
        </div>
        <div class="space"></div>
        <!-- Sender Infos -->
        <div>
          <h6 class="title">
            <i class="fa-solid fa-circle-exclamation"></i>
            Infos Expéditeur
          </h6>
          <div class="message__infos">
            <div class="d-flex align-items-center mb-1">
              Pays: <span class="fw-bold mx-2">
                <?php
                  if (isset($senderCountryDec)) {
                    if ($senderCountry == 'russie') {
                      echo "Russie";
                    } else if ($senderCountry == 'civ') {
                      echo "Cote d'Ivoire";
                    } else if ($senderCountry == 'mali') {
                      echo "Mali";
                    } else if ($senderCountry == 'cameroun') {
                      echo "Cameroun";
                    } else if ($senderCountry == 'gabon') {
                      echo "Gabon";
                    } else if ($senderCountry == 'congo') {
                      echo "Congo Brazaville";
                    } else if ($senderCountry == 'senegal') {
                      echo "Sénégal";
                    } else if ($senderCountry == 'benin') {
                      echo "Bénin";
                    } else if ($senderCountry == 'togo') {
                      echo "Togo";
                    } else if ($senderCountry == 'burkina') {
                      echo "Burkina";
                    } else if ($senderCountry == 'guinee') {
                      echo "Guinée";
                    } else if ($senderCountry == 'rdc') {
                      echo "RD Congo";
                    } else if ($senderCountry == 'niger') {
                      echo "Niger";
                    }
                  }
                ?>
              </span>
            </div>
            <!-- Mode envoi -->
            <div class="mb-1">
              Mode: <span class="fw-bold"><?= $modeSending; ?></span>
            </div>
            <div>
              Tél: <span class="fw-bold "><?= $senderPhone; ?></span>
            </div>
          </div>
        </div>
        <div class="space"></div>
        <!-- Receiver Infos -->
        <div>
          <h6 class="title">
            <i class="fa-solid fa-circle-exclamation"></i>
            Infos Bénéficiaire
          </h6>
          <div class="message__infos">
            <div class=" mb-1">
              Nom: <span class="fw-bold "><?= $receiverName; ?></span>
            </div>
            <div class="d-flex align-items-center mb-1">
              Pays: <div class="fw-bold mx-2">
                <?php
                  if (isset($receiverCountryDec)) {
                    if ($receiverCountry == 'russie') {
                      echo "Russie";
                    } else if ($receiverCountry == 'civ') {
                      echo "Cote d'Ivoire";
                    } else if ($receiverCountry == 'mali') {
                      echo "Mali";
                    } else if ($receiverCountry == 'cameroun') {
                      echo "Cameroun";
                    } else if ($receiverCountry == 'gabon') {
                      echo "Gabon";
                    } else if ($receiverCountry == 'congo') {
                      echo "Congo Brazaville";
                    } else if ($receiverCountry == 'senegal') {
                      echo "Sénégal";
                    } else if ($receiverCountry == 'benin') {
                      echo "Bénin";
                    } else if ($receiverCountry == 'togo') {
                      echo "Togo";
                    } else if ($receiverCountry == 'tchad') {
                      echo "Tchad";
                    } else if ($receiverCountry == 'rdc') {
                      echo "RD Congo";
                    } else if ($receiverCountry == 'burkina') {
                      echo "burkina";
                    } else if ($receiverCountry == 'centreAfrique') {
                      echo "CentreAfrique";
                    } else if ($receiverCountry == 'guinee') {
                      echo "Guinée";
                    } else if ($receiverCountry == 'niger') {
                      echo "Niger";
                    }
                  }
                ?>
              </div>
            </div>
            <!-- Mode envoi -->
            <div class="mb-1">
              <?php
                if (isset($receiverCountryDec)) {
                  if ($receiverCountry == 'russie') {
                    // Nothing
                  } else {
                    ?>
                      <div class="mb-1">
                        Mode: <span class="fw-bold">
                        <?= $receiverMode; ?>
                        </span>
                      </div>
                    <?php
                  }
                }
              ?>
            </div>
            <div class="">
              Tél: <span class="fw-bold "><?= $receiverPhone; ?></span>
            </div>
          </div>
        </div>
        <div class="space"></div>
        <!-- Amount -->
        <div>
          <h6 class="title">
            <i class="fa-solid fa-circle-exclamation"></i>
            A propos du montant
          </h6>
          <div class="message__infos">
            <div class="d-flex align-items-center mb-1">
              Montant recut: 
              <span class="fw-bold mx-2 amount">
                <?= number_format($details['amount'],  2, ',', ' '). ' '. $changes; ?>
              </span>
            </div>
            <div class="d-flex align-items-center">
              Montant à transférer: <span class="amount fw-bold mx-2">
              <?= number_format($details['amount_rouble'],  2, ',', ' '). ' '. $change; ?>
              </span>
            </div>
          </div>
        </div> 
        <div class="space"></div>
        <!-- Agent AF -->
        <div class="choose_account_af">
          <h6 class="title">
            <i class="fa-solid fa-user-circle"></i>
            Choix Agent Afrique
          </h6>
          <?php
            if (!$af_agent) {
              if ($statusOTP == NULL) {
                ?>
                  <form method="POST">
                    <select name="af_agent_name" class="form-select form-select-sm">
                      <option value=""></option>
                      <?php
                        if ($senderCountry == 'russie') {
                          if ($getAllAgentName->rowCount() > 0) {
                            while ($fetch_res = $getAllAgentName->fetch(PDO::FETCH_ASSOC)) {
                              $af_name = $fetch_res['account_name'];
                              ?>
                                <option value="<?= $af_name; ?>"><?= $af_name; ?></option>
                              <?php
                            }
                          }
                        } else {
                          if ($getAllAgentName->rowCount() > 0) {
                            while ($fetch_res = $getAllAgentName->fetch(PDO::FETCH_ASSOC)) {
                              $af_name = $fetch_res['account_name'];
                              ?>
                                <option value="<?= $af_name; ?>"><?= $af_name; ?></option>
                              <?php
                            }
                          }
                        }
                      ?>
                    </select>

                    <div class="float-end mt-3">
                      <button name="set_af" class="btn btn-sm">Envoyer</button>
                    </div>
                  </form>
                <?php
              }
            } else {
              ?>
                <div class="mx-4">
                  Agent: <span class="fw-bold" style="color: #05c46b"><?= $name; ?> <br></span>
                  Statut: <span class="fw-bold" style="color: #05c46b">Effectué</span>
                </div>
              <?php
            }
          ?>
        </div>      
      </div>
    </div>
  </div>

  <script>
    window.onload = (event) => {
      let myToast = document.querySelector('.toast')
      let alertToast = new bootstrap.Toast(myToast)
      alertToast.show()
    }
  </script>
</body>
</html>