<?php
  require('../../../backend/security/security.php');
  require('../../../backend/auth/authProfile.php');
  require('../../../backend/role/roleUnderAdmin.php');
  require('../../../backend/db/database.php');

  // Get All Manuels transactions
  $getMenuelTransaction = $db->prepare('SELECT * FROM `manuel_transaction` ORDER BY id DESC');
  $getMenuelTransaction->execute();
?>


<!DOCTYPE html>
<html lang="en">
  <!-- Included -->
<?php 
  include '../include/profileHead.php';
  include '../../../views/assets/css/global.php';
  include '../../../views/assets/admin/css/globalAdminCSS.php';
?>
<!-- Style -->
<style>
  .manuel_transaction {
    width: 100% !important;
    height: 76vh;
    overflow-y: scroll;
  }
  @media screen and (max-width: 992px) {
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
  <div class="container">
    <!-- Back Button -->
    <div class="mt-4">
      <a href="../dashboard" class="navbar-brand fw-bold">
        <i class="fa-solid fa-angle-left"></i>
        Retour
      </a>
    </div>

    <!-- Success connexion message -->
    <?php include '../../../views/includes/alerts/alert_success.php'; ?>

    <!-- ========= Historique ========= -->
    <div class="card my-3 manuel_transaction">
      <div class="card-body">
        <div class="table-responsive" id="no-more-tables">
          <table class="table table-hover table-bordered table-striped table-sm">
            <thead class="bg-dark text-white text-center">
              <tr>
                <th>ID</th>
                <th>Type</th>
                <th>Initiateur</th>
                <th>Details</th>
                <th>Reception</th>
                <th>Payeur</th>
                <th>Paiement</th>
                <th>Date</th>
                <th>Heure</th>
                <th class="bg-danger">Delete</th>
              </tr>
            </thead>
            <tbody class="text-center">
              <?php
                if ($getMenuelTransaction->rowCount() > 0) {
                  while ($fetch_menuel_transc = $getMenuelTransaction->fetch(PDO::FETCH_ASSOC)) {
                    // Get variables
                    $id_transc = $fetch_menuel_transc['id'];
                    $agent_name = $fetch_menuel_transc['agent_name'];
                    $type_transc = $fetch_menuel_transc['type_form'];
                    $reception_af = $fetch_menuel_transc['statut'];
                    $agent_payeur = $fetch_menuel_transc['payeur'];
                    $date = $fetch_menuel_transc['date'];
                    $stat_paiement = $fetch_menuel_transc['paiement_statut'];
                    $init_transaction = $fetch_menuel_transc['current_agent_name'];
                    $current_hours = $fetch_menuel_transc['current_hours'];

                    // URL Encoded
                    $urlEncode = base64_encode($id_transc);

                    ?>
                      <tr>
                        <td data-title='Identifiant'><?= $id_transc; ?></td>
                        <td data-title='Type de T.'> 
                          <?php
                            if ($type_transc == 'send') {
                              echo '<span style="background-color: var(--primary-color);" class="badge text-white fw-bold">
                                <i class="fa-solid fa-paper-plane"></i>
                                Envoi
                              </span>';
                            } else {
                              echo '<span style="background-color: #27ae60;" class="badge text-white fw-bold">
                                <i class="fa-solid fa-circle-arrow-left"></i>
                                Paiement
                              </span>
                              ';
                            }
                          ?>
                        </td>
                        <td data-title='Agent Recepteur'><?= $init_transaction; ?></td>
                        <td data-title='Détails'>
                          <a href="./details?id=<?= $urlEncode; ?>">
                            <i class="fa-solid fa-magnifying-glass-plus" style="font-size: 1rem; cursor: pointer;"></i>
                          </a>
                        </td>
                        <td data-title="Reception">
                          <?php
                            if ($type_transc == 'send') {
                              echo '<span style="background-color: var(--primary-color);" class="badge text-white fw-bold">
                                <i class="fa-solid fa-toggle-on"></i>
                                Confirmé
                              </span>';
                            } else if ($type_transc == 'paiement' && $reception_af == 'disabled') {
                              echo '<span style="background-color: #fed330;" class="badge text-dark fw-bold">
                                <i class="fa-solid fa-toggle-off"></i>
                                En attente
                              </span>';
                            } else {
                              echo '<span style="background-color: #27ae60;" class="badge text-white fw-bold">
                                <i class="fa-solid fa-toggle-on"></i>
                                Validé
                              </span>';
                            }
                          ?>
                        </td>
                        <td data-title="A. payeur">
                          <?php
                            if ($type_transc == 'send') {
                              if ($reception_af == 'disabled') {
                                echo '<span style="background-color: #fc5c65;" class="badge text-white fw-bold">
                                  <i class="fa-solid fa-toggle-off"></i>
                                En attente
                                </span>';
                              } else {
                                echo $agent_name;
                              }
                            } else if ($type_transc == 'paiement') {
                              if ($agent_payeur) {
                                echo $agent_payeur;
                              } else {
                                echo '<span style="background-color: #fc5c65;" class="badge text-white fw-bold">
                                  <i class="fa-solid fa-toggle-off"></i>
                                  En attente
                                </span>';
                              }
                            }
                          ?>
                        </td>
                        <td data-title="Paiement">
                          <?php
                            if ($type_transc == 'send') {
                              if ($reception_af == 'enabled') {
                                echo '<span style="background-color: #27ae60;" class="badge text-white fw-bold">
                                  <i class="fa-solid fa-toggle-on"></i>
                                  Payé
                                </span>';
                              } else {
                                echo '<span style="background-color: #fc5c65;" class="badge text-white fw-bold">
                                  <i class="fa-solid fa-toggle-off"></i>
                                  En attente
                                </span>';
                              }
                            } else if ($type_transc == 'paiement') {
                              if ($stat_paiement == 'disabled') {
                                echo '<span style="background-color: #fed330;" class="badge text-dark fw-bold">
                                  <i class="fa-solid fa-toggle-off"></i>
                                  En cours
                                </span>';
                              } else {
                                echo '<span style="background-color: #27ae60;" class="badge text-white fw-bold">
                                  <i class="fa-solid fa-check-circle"></i>
                                  Effectué
                                </span>';
                              }
                            }
                          ?>
                        </td>
                        <td data-title="Date"><?= $date; ?></td>
                        <td data-title="Date"><?= $current_hours; ?></td>
                        <!-- Delete -->
                        <td data-title='Banir'>
                          <a href="./deleteManTransaction?id=<?= $urlEncode; ?>">
                            <i class="fa-solid fa-trash" style="color: #ff7979; font-size: 1rem; cursor: pointer;"></i>
                          </a>
                        </td>
                      </tr>
                    <?php
                  }
                }
              ?>
            </tbody>
          </table>
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