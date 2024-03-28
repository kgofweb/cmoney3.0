<?php 
  require('../../backend/security/security.php');
  require('../../backend/controllers/admin/dashboardAction.php');
  require('../../backend/controllers/admin/logoutAction.php');
?>

<!DOCTYPE html>
<html lang="fr">
<?php 
  include './include/dashboardHead.php'; 
  include '../../views/assets/css/global.php';
?>
<style>
  body {
    background-color: #003580;
  }
  .back {
    color: #fff;
    text-decoration: none;
  }
  .card {
  	border: none;
  }
  @media screen and (max-width: 768px) {
    .counting {
      flex-direction: column;
    }
    .counting .card {
      width: 100% !important;
      margin-bottom: .5rem;
    }
  }
  @media screen and (max-width: 992px) {
    .header_content {
      flex-direction: column;
    }
    #no-more-tables tbody,
    #no-more-tables tr,
    #no-more-tables td {
      display: block;
    }
    #no-more-tables thead tr {
      position: absolute;
      top: -9999px;
      left: -9999px;
    }
    #no-more-tables td {
      position: relative;
      padding-left: 50%;
      border: none;
      border-bottom: .5px solid #ccc;
    }
    #no-more-tables td:before {
      content: attr(data-title);
      position: absolute;
      left: 6px;
      font-weight: bold;
    }
    #no-more-tables tr {
      border-bottom: 1px solid #7f8c8d;
    }
  }
</style>
<body>
  <!-- NavBar -->
  <?php include '../../views/admin/include/nav/nav.php'; ?>

  <div class="container">
    <!-- Success connexion message -->
    <?php include '../../views/includes/alerts/alert_success.php'; ?>

    <a class="back" href="../admin/dashboard">
      <i class="fa-solid fa-chevron-left"></i>
      Retour
    </a>

    <?php
      // Super Admin
      if (isset($_SESSION['role'])) {
        if ($_SESSION['role'] == 'admin') {
          ?>
            <div class="row my-3">
              <div class="col-sm-12">
                <div class="card mb-4">
                  <div class="card-body">
                    <!-- Show all transactions -->
                    <div class="table-responsive" id="no-more-tables">
                      <!-- Table -->
                      <table id="example" class="table table-hover table-bordered table-striped table-sm">
                        <div>
                          <thead class="bg-dark text-white">
                            <tr>
                              <th class="bg-primary">ID</th>
                              <th class="bg-dark">Expéditeur</th>
                              <th class="bg-dark">Bénéfiçiare</th>
                              <th class="bg-dark">Code</th>
                              <th class="bg-dark">Date</th>
                              <th class="bg-dark">Heure</th>
                              <th class="bg-dark">Statut</th>
                              <th class="bg-dark">Détails</th>
                              <th class="bg-dark">Paiement</th>
                              <?php
                                if (isset($_SESSION['role_admin'])) {} else {
                                  ?>
                                    <th class="bg-danger">Danger</th>
                                  <?php
                                }
                              ?>
                            </tr>
                          </thead>
                          <tbody>
                            <!--  -->
                            <?php
                              while ($infos = $getPlusInfos->fetch()) {
                                // URL
                                $url = $infos['id'];
                                $urlEncode = base64_encode($url);

                                // decrypt
                                $senderCountry = $infos['countryOne'];
                                $receiverCountry = $infos['countryTwo'];
                                $verificationCode = $infos['verification_code'];
                                $dateTransaction = $infos['date'];
                                $hoursTransaction = $infos['time'];

                                $resultSenderCountry = openssl_decrypt($senderCountry, $chiper, $key, $options, $iv);
                                $resultReceiverCountry = openssl_decrypt($receiverCountry, $chiper, $key, $options, $iv);
                                $resultCode = openssl_decrypt($verificationCode, $chiper, $key, $options, $iv);

                                ?>
                                  <tr class="text-center">
                                    <td data-title='ID'>
                                      <?= $infos['id']; ?>
                                    </td>
                                    <td data-title='Expéditeur'>
                                      <!-- Country Sender -->
                                      <?php
                                        if (isset($senderCountry)) {
                                          if ($resultSenderCountry == 'russie') {
                                            echo "Russie";
                                          } else if ($resultSenderCountry == 'civ') {
                                            echo "Cote d'Ivoire";
                                          } else if ($resultSenderCountry == 'mali') {
                                            echo "Mali";
                                          } else if ($resultSenderCountry == 'cameroun') {
                                            echo "Cameroun";
                                          } else if ($resultSenderCountry == 'gabon') {
                                            echo "Gabon";
                                          } else if ($resultSenderCountry == 'congo') {
                                            echo "Congo Braz";
                                          } else if ($resultSenderCountry == 'senegal') {
                                            echo "Sénégal";
                                          } else if ($resultSenderCountry == 'benin') {
                                            echo "Bénin";
                                          } else if ($resultSenderCountry == 'togo') {
                                            echo "Togo";
                                          } else if ($resultSenderCountry == 'rdc') {
                                            echo "RD Congo";
                                          } else if ($resultSenderCountry == 'guinee') {
                                            echo "Guinee";
                                          } else if ($resultSenderCountry == 'burkina') {
                                            echo "Burkina";
                                          }  else if ($resultSenderCountry == 'niger') {
                                            echo "Niger";
                                          }
                                        }
                                      ?>
                                    </td>
                                    <!-- Country Receiver -->
                                    <td data-title='Bénéficiaire'>
                                      <?php
                                        if (isset($receiverCountry)) {
                                          if ($resultReceiverCountry == 'russie') {
                                            echo "Russie";
                                          } else if ($resultReceiverCountry == 'civ') {
                                            echo "Cote d'Ivoire";
                                          } else if ($resultReceiverCountry == 'mali') {
                                            echo "Mali";
                                          } else if ($resultReceiverCountry == 'cameroun') {
                                            echo "Cameroun";
                                          } else if ($resultReceiverCountry == 'gabon') {
                                            echo "Gabon";
                                          } else if ($resultReceiverCountry == 'congo') {
                                            echo "Congo Braza";
                                          } else if ($resultReceiverCountry == 'senegal') {
                                            echo "Sénégal";
                                          } else if ($resultReceiverCountry == 'benin') {
                                            echo "Bénin";
                                          } else if ($resultReceiverCountry == 'togo') {
                                            echo "Togo";
                                          } else if ($resultReceiverCountry == 'burkina') {
                                            echo "Burkina";
                                          } else if ($resultReceiverCountry == 'guinee') {
                                            echo "Guinee";
                                          } else if ($resultReceiverCountry == 'tchad') {
                                            echo "Tchad";
                                          } else if ($resultReceiverCountry == 'centreAfrique') {
                                            echo "CentreAfrique";
                                          } else if ($resultReceiverCountry == 'rdc') {
                                            echo "RD Congo";
                                          }  else if ($resultReceiverCountry == 'niger') {
                                            echo "Niger";
                                          }
                                        }
                                      ?>
                                    </td>
                                    <!-- Code verification -->
                                    <td data-title='Code' class="fw-bold">
                                      <?= $verificationCode; ?>
                                    </td>
                                    <!-- Date de transaction -->
                                    <td data-title='Date'>
                                      <?= $dateTransaction; ?>
                                    </td>
                                    <!-- Heure de transaction -->
                                    <td data-title='Heure'>
                                      <?= $hoursTransaction; ?>
                                    </td>
                                    <!-- Activation code -->
                                    <td data-title='Statut' class="text-center">
                                      <?php
                                        if ($infos['number_verified'] == NULL) {
                                          ?>
                                            <span class="badge rounded-pill text-decoration-none fw-bold" style="background-color: #fff8db; color: #ffa801;">
                                              En attente
                                              <i class="fa-solid fa-circle-minus"></i>
                                            </span>
                                          <?php
                                        } else {
                                          ?>
                                            <span class="badge rounded-pill fw-bold" style="background-color: #d2eddf; color: #05c46b;">
                                              Activé
                                              <i class="fa-solid fa-circle-check"></i>
                                            </span>
                                          <?php
                                        }
                                      ?>
                                    </td>
                                    <!-- Details -->
                                    <td data-title='Détails'>
                                      <a href="./details?id=<?= $urlEncode; ?>">
                                        <i class="fa-solid fa-magnifying-glass-plus" style="font-size: 1rem; cursor: pointer;"></i>
                                      </a>
                                    </td>
                                    <!-- Retrait -->
                                    <td data-title='Paiement'>
                                      <?php
                                        // Si le user n'a pas lancé de demande de retrait
                                        if ($infos['ask_withdrawal'] == NULL) {
                                          if (strlen($verificationCode) == 8) {
                                            ?>
                                              <span class="badge rounded-pill fw-bold" style="background-color: #dae8f3; color:#0984e3;">
                                                Immédiat
                                                <i class="fa-solid fa-circle-plus"></i>
                                              </span>
                                            <?php
                                          } else {
                                            ?>
                                              <span class="badge rounded-pill" style="background-color: #e3e5e5; color:#636e72;">
                                                Aucune demande
                                                <i class="fa-solid fa-circle-exclamation"></i>
                                              </span>
                                            <?php
                                          }
                                        }
                                        // Si le user lance une demande de retarit
                                        else if ($infos['ask_withdrawal'] !== NULL && $infos['status_payement'] == NULL) {
                                          ?>
                                            <a href="./payement?id=<?= $urlEncode; ?>" class="badge rounded-pill text-dark text-decoration-none" style="background-color: #fff8db; color: #ffa801;">
                                              Demande de retrait
                                              <i class="fa-solid fa-circle-plus"></i>
                                            </a>
                                          <?php
                                        }
                                        else {
                                          ?>
                                            <a href="./payement?id=<?= $urlEncode; ?>" class="badge rounded-pill text-decoration-none" style="background-color: #d2eddf; color: #05c46b;">
                                              Payé
                                              <i class="fa-solid fa-circle-check"></i>
                                            </a>
                                          <?php
                                        }
                                      ?>
                                    </td>
                                    <!-- Delete -->
                                    <?php
                                      if (isset($_SESSION['role_admin'])) {} else {
                                        ?>
                                          <td data-title='Zone rouge'>
                                            <span name='delete'>
                                              <a href="./delete?id=<?= $urlEncode; ?>" class="text-decoration-none">
                                                <i class="fa-solid fa-trash" style="color: #ff7979; font-size: 1rem; cursor: pointer;"></i>
                                            </a>
                                            </span>
                                          </td>
                                        <?php
                                      }
                                    ?>
                                  </tr>
                                <?php
                              }
                            ?>
                          </tbody>
                        </div>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php
        }
      }

      // Compte Agent Cmoney Restreint
      if (isset($_SESSION['role_admin'])) {
        if ($_SESSION['role_admin'] == 0) {
          ?>
            <div class="row my-3">
              <div class="col-sm-12">
                <div class="card mb-4">
                  <div class="card-body">
                    <!-- Show all transactions -->
                    <div class="table-responsive" id="no-more-tables">
                      <!-- Table -->
                      <table id="example" class="table table-hover table-bordered table-striped table-sm">
                        <div>
                          <thead class="bg-dark text-white">
                            <tr>
                              <th class="bg-primary">ID</th>
                              <th class="bg-dark">Expéditeur</th>
                              <th class="bg-dark">Bénéfiçiare</th>
                              <th class="bg-dark">Code</th>
                              <th class="bg-dark">Date</th>
                              <th class="bg-dark">Heure</th>
                              <th class="bg-dark">Statut</th>
                              <th class="bg-dark">Détails</th>
                              <th class="bg-dark">Paiement</th>
                              <?php
                                if (isset($_SESSION['role_admin'])) {} else {
                                  ?>
                                    <th class="bg-danger">Danger</th>
                                  <?php
                                }
                              ?>
                            </tr>
                          </thead>
                          <tbody>
                            <!--  -->
                            <?php
                              while ($infos = $getPlusInfos->fetch()) {
                                // URL
                                $url = $infos['id'];
                                $urlEncode = base64_encode($url);

                                // decrypt
                                $senderCountry = $infos['countryOne'];
                                $receiverCountry = $infos['countryTwo'];
                                $verificationCode = $infos['verification_code'];
                                $dateTransaction = $infos['date'];
                                $hoursTransaction = $infos['time'];

                                $resultSenderCountry = openssl_decrypt($senderCountry, $chiper, $key, $options, $iv);
                                $resultReceiverCountry = openssl_decrypt($receiverCountry, $chiper, $key, $options, $iv);
                                $resultCode = openssl_decrypt($verificationCode, $chiper, $key, $options, $iv);

                                ?>
                                  <tr class="text-center">
                                    <td data-title='ID'>
                                      <?= $infos['id']; ?>
                                    </td>
                                    <td data-title='Expéditeur'>
                                      <!-- Country Sender -->
                                      <?php
                                        if (isset($senderCountry)) {
                                          if ($resultSenderCountry == 'russie') {
                                            echo "Russie";
                                          } else if ($resultSenderCountry == 'civ') {
                                            echo "Cote d'Ivoire";
                                          } else if ($resultSenderCountry == 'mali') {
                                            echo "Mali";
                                          } else if ($resultSenderCountry == 'cameroun') {
                                            echo "Cameroun";
                                          } else if ($resultSenderCountry == 'gabon') {
                                            echo "Gabon";
                                          } else if ($resultSenderCountry == 'congo') {
                                            echo "Congo Braz";
                                          } else if ($resultSenderCountry == 'senegal') {
                                            echo "Sénégal";
                                          } else if ($resultSenderCountry == 'benin') {
                                            echo "Bénin";
                                          } else if ($resultSenderCountry == 'togo') {
                                            echo "Togo";
                                          } else if ($resultSenderCountry == 'rdc') {
                                            echo "RD Congo";
                                          } else if ($resultSenderCountry == 'guinee') {
                                            echo "Guinee";
                                          } else if ($resultSenderCountry == 'burkina') {
                                            echo "Burkina";
                                          }  else if ($resultSenderCountry == 'niger') {
                                            echo "Niger";
                                          }
                                        }
                                      ?>
                                    </td>
                                    <!-- Country Receiver -->
                                    <td data-title='Bénéficiaire'>
                                      <?php
                                        if (isset($receiverCountry)) {
                                          if ($resultReceiverCountry == 'russie') {
                                            echo "Russie";
                                          } else if ($resultReceiverCountry == 'civ') {
                                            echo "Cote d'Ivoire";
                                          } else if ($resultReceiverCountry == 'mali') {
                                            echo "Mali";
                                          } else if ($resultReceiverCountry == 'cameroun') {
                                            echo "Cameroun";
                                          } else if ($resultReceiverCountry == 'gabon') {
                                            echo "Gabon";
                                          } else if ($resultReceiverCountry == 'congo') {
                                            echo "Congo Braza";
                                          } else if ($resultReceiverCountry == 'senegal') {
                                            echo "Sénégal";
                                          } else if ($resultReceiverCountry == 'benin') {
                                            echo "Bénin";
                                          } else if ($resultReceiverCountry == 'togo') {
                                            echo "Togo";
                                          } else if ($resultReceiverCountry == 'burkina') {
                                            echo "Burkina";
                                          } else if ($resultReceiverCountry == 'guinee') {
                                            echo "Guinee";
                                          } else if ($resultReceiverCountry == 'tchad') {
                                            echo "Tchad";
                                          } else if ($resultReceiverCountry == 'centreAfrique') {
                                            echo "CentreAfrique";
                                          } else if ($resultReceiverCountry == 'rdc') {
                                            echo "RD Congo";
                                          }  else if ($resultReceiverCountry == 'niger') {
                                            echo "Niger";
                                          }
                                        }
                                      ?>
                                    </td>
                                    <!-- Code verification -->
                                    <td data-title='Code' class="fw-bold">
                                      <?= $verificationCode; ?>
                                    </td>
                                    <!-- Date de transaction -->
                                    <td data-title='Date'>
                                      <?= $dateTransaction; ?>
                                    </td>
                                    <!-- Heure de transaction -->
                                    <td data-title='Heure'>
                                      <?= $hoursTransaction; ?>
                                    </td>
                                    <!-- Activation code -->
                                    <td data-title='Statut' class="text-center">
                                      <?php
                                        if ($infos['number_verified'] == NULL) {
                                          ?>
                                            <span class="badge rounded-pill text-decoration-none fw-bold" style="background-color: #fff8db; color: #ffa801;">
                                              En attente
                                              <i class="fa-solid fa-circle-minus"></i>
                                            </span>
                                          <?php
                                        } else {
                                          ?>
                                            <span class="badge rounded-pill fw-bold" style="background-color: #d2eddf; color: #05c46b;">
                                              Activé
                                              <i class="fa-solid fa-circle-check"></i>
                                            </span>
                                          <?php
                                        }
                                      ?>
                                    </td>
                                    <!-- Details -->
                                    <td data-title='Détails'>
                                      <a href="./details?id=<?= $urlEncode; ?>">
                                        <i class="fa-solid fa-magnifying-glass-plus" style="font-size: 1rem; cursor: pointer;"></i>
                                      </a>
                                    </td>
                                    <!-- Retrait -->
                                    <td data-title='Paiement'>
                                      <?php
                                        // Si le user n'a pas lancé de demande de retrait
                                        if ($infos['ask_withdrawal'] == NULL) {
                                          if (strlen($verificationCode) == 8) {
                                            ?>
                                              <span class="badge rounded-pill fw-bold" style="background-color: #dae8f3; color:#0984e3;">
                                                Immédiat
                                                <i class="fa-solid fa-circle-plus"></i>
                                              </span>
                                            <?php
                                          } else {
                                            ?>
                                              <span class="badge rounded-pill" style="background-color: #e3e5e5; color:#636e72;">
                                                Aucune demande
                                                <i class="fa-solid fa-circle-exclamation"></i>
                                              </span>
                                            <?php
                                          }
                                        }
                                        // Si le user lance une demande de retarit
                                        else if ($infos['ask_withdrawal'] !== NULL && $infos['status_payement'] == NULL) {
                                          ?>
                                            <a href="./payement?id=<?= $urlEncode; ?>" class="badge rounded-pill text-dark text-decoration-none" style="background-color: #fff8db; color: #ffa801;">
                                              Demande de retrait
                                              <i class="fa-solid fa-circle-plus"></i>
                                            </a>
                                          <?php
                                        }
                                        else {
                                          ?>
                                            <a href="./payement?id=<?= $urlEncode; ?>" class="badge rounded-pill text-decoration-none" style="background-color: #d2eddf; color: #05c46b;">
                                              Payé
                                              <i class="fa-solid fa-circle-check"></i>
                                            </a>
                                          <?php
                                        }
                                      ?>
                                    </td>
                                    <!-- Delete -->
                                    <?php
                                      if (isset($_SESSION['role_admin'])) {} else {
                                        ?>
                                          <td data-title='Zone rouge'>
                                            <span name='delete'>
                                              <a href="./delete?id=<?= $urlEncode; ?>" class="text-decoration-none">
                                                <i class="fa-solid fa-trash" style="color: #ff7979; font-size: 1rem; cursor: pointer;"></i>
                                            </a>
                                            </span>
                                          </td>
                                        <?php
                                      }
                                    ?>
                                  </tr>
                                <?php
                              }
                            ?>
                          </tbody>
                        </div>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php
        }
      }

      // Compte Agent
      if (isset($_SESSION['account_type'])) {
        ?>
          <!-- Dashboard Pour les compte Afriques et les compte Payeurs -->
          <?php include '../../views/admin/dashbAccount.php'; ?>
        <?php
      }
    ?>
  </div>

  <?php include '../../views/assets/admin/js/dashboard.php'; ?>
</body>
</html>