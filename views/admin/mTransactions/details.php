<?php
  require('../../../backend/security/security.php');
  require('../../../backend/auth/authProfile.php');
  require('../../../backend/role/roleUnderAdmin.php');
  require('../../../backend/db/database.php');

  if (isset($_GET['id']) AND !empty($_GET['id'])) {
    $idOfTansaction = base64_decode($_GET['id']);

    $getDetails = $db->prepare('SELECT * FROM `manuel_transaction` WHERE id = ?');
    $getDetails->execute([$idOfTansaction]);

    // Fetch results
    $fetch_result =  $getDetails->fetch(PDO::FETCH_ASSOC);

    // Get variables
    $id = $fetch_result['id'];
    $current_hours = $fetch_result['current_hours'];
    $init_agent = $fetch_result['current_agent_name'];
    $agent_af = $fetch_result['agent_name'];
    $agent_cont = $fetch_result['agent_contry'];
    $amount_receive = $fetch_result['amount_received'];
    $amount_send = $fetch_result['amount_to_send'];
    $network = $fetch_result['network'];
    $transfert_type = $fetch_result['type_form'];
    $reception_statut = $fetch_result['statut'];
    $agent_payeur = $fetch_result['payeur'];
    $stat_paiement = $fetch_result['paiement_statut'];
    $date = $fetch_result['date'];
    // Benef
    $name_benef = $fetch_result['receiver_name'];
    $phone_benef = $fetch_result['receiver_phone'];
    $network_benef = $fetch_result['network_russie'];
    $network_benef_other = $fetch_result['other_bank_r'];
  }

  // Show and choose Payer Name
  $cm_account = 'ChapMoney';
  $p_account = 'Payeur';

  $getAllAgentName = $db->prepare("SELECT account_name FROM `other_profile` WHERE account_type = ?");
  $getAllAgentName->execute([$cm_account]);

  $getAllAgentNamePayeur = $db->prepare("SELECT account_name FROM `other_profile` WHERE account_type = ?");
  $getAllAgentNamePayeur->execute([$p_account]);

  // Set payer transaction of type send
  if (isset($_POST['set_payer'])) {
    // Get selecvt value
    $idOfTansaction = base64_decode($_GET['id']);
    $agent_payer_name = $_POST['payer_agent_name'];

    // Verifie if fileds are not empty
    if (!empty($agent_payer_name)) {
      // Insert payer agent choosed in db
      $insert_payer = $db->prepare('UPDATE `manuel_transaction` SET payeur = ? WHERE id = ?');
      $insert_payer->execute([$agent_payer_name, $idOfTansaction]);

      $_SESSION['success'] = 'Transféré avec success';
      header('location: ./manuelTransaction');
    } else {
      $_SESSION['emptyFiled'] = 'Definir un nom';
    }
  }
?>

<!DOCTYPE html>
<html lang="fr">
<!-- Head -->
<?php 
  include '../include/profileHead.php';
  include '../../../views/assets/css/global.php';
  include '../../../views/assets/admin/css/globalAdminCSS.php';
?>
<style>
  .content {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
</style>
<body>
  <div class="container">
    <!-- Back Button -->
    <div class="mt-4">
      <a href="./manuelTransaction" class="navbar-brand fw-bold">
        <i class="fa-solid fa-angle-left"></i>
        Retour
      </a>
    </div>

    <!-- Error messages -->
    <?php include '../../../views/includes/alerts/alert_emptyFields.php'; ?>


    <!-- Details -->
    <div class="card my-4">
      <div class="card-body">
        <!-- ID -->
        <div class="d-flex align-items-center justify-content-between mb-3">
          <div class="d-flex flex-column text-center">
            <span>ID</span>
            <span style="background-color: #fc5c65;" class="badge text-white fw-bold">
              <?= $id; ?>
            </span>
          </div>
          <div class="d-flex flex-column text-center">
            <span>Type</span>
            <?php
              if ($transfert_type == 'send') {
                echo '<span style="background-color: var(--primary-color);" class="badge text-white fw-bold">
                  <i class="fa-solid fa-paper-plane"></i>
                  Envoi
                </span>';
              } else {
                echo '<span style="background-color: #20bf6b;" class="badge text-white fw-bold">
                  <i class="fa-solid fa-wallet"></i>
                  Paiement
                </span>';
              }
            ?>
          </div>
          <div class="d-flex flex-column text-center">
            <span>Date</span>
            <span style="background-color: #f7b731;" class="badge text-white fw-bold">
            <?= $date; ?>
            </span>
          </div>
        </div>
        <div class="border my-3"></div>
        <!-- Hours -->
        <div class="my-3">
          <div class="content">
            <div>
              <i class="fa-solid fa-clock"></i>
              Heure de transaction : 
            </div>
            <span class="fw-bold"><?= $current_hours; ?></span>
          </div>
        </div>
        <!-- Initiateur -->
        <div class="mb-2">
          <div class="content">
            <div>
              <i class="fa-solid fa-user"></i>
              Initiateur : 
            </div>
            <span class="fw-bold"><?= $init_agent; ?></span>
          </div>
        </div>
        <!-- Agent Afrique -->
        <div class="mb-2">
          <div class="content">
            <div>
              <i class="fa-solid fa-user"></i>
              Agent Afrique :
            </div>
            <span class="fw-bold"><?= $agent_af; ?></span>
          </div>
        </div>
        <!-- Agent Afrique Country -->
        <div class="mb-2">
          <div class="content">
            <div>
              <i class="fa-solid fa-earth-americas"></i>
              Pays A. Afrique :
            </div>
            <span class="fw-bold"><?= $agent_cont; ?></span>
          </div>
        </div>
        <!-- Amiount received -->
        <div class="mb-2">
          <div class="content">
            <div>
              <i class="fa-solid fa-wallet"></i>
              Somme Reçue :
            </div>
            <span class="fw-bold"><?= number_format($amount_receive, 0, ', ', ' '); ?></span>
          </div>
        </div>
        <!-- Amount to send -->
        <div class="mb-2">
          <div class="content">
            <div>
              <i class="fa-solid fa-wallet"></i>
              Montant à verser :
            </div>
            <span class="fw-bold"><?= number_format($amount_send, 0, ', ', ' '); ?></span>
          </div>
        </div>
        <!-- Network -->
        <div class="mb-2">
          <div class="content">
            <div>
              <i class="fa-solid fa-wifi"></i>
              Reseaux :
            </div>
            <span class="fw-bold"><?= $network; ?></span>
          </div>
        </div>
        <!-- Beneficiaire -->
        <?php
          if ($transfert_type == 'paiement') {
            ?>
              <div class="mt-4">
                <div class="content">
                  Nom Bénéficiaire : 
                  <span class="fw-bold"> <?= $name_benef; ?> </span>
                </div>
              </div>
              <div>
                <div class="content">
                  Téléphone : 
                  <span class="fw-bold"> <?= $phone_benef; ?> </span>
                </div>
              </div>
              <div>
                <div class="content">
                  Banque : 
                  <?php
                    if ($network_benef) {
                      ?> <span class="fw-bold"><?= $network_benef; ?></span> <?php
                    } else {
                      ?> <span class="fw-bold"><?= $network_benef_other; ?></span> <?php
                    }
                  ?>
                </div>
              </div>
            <?php
          } else {
            ?>
              <div class="mt-4">
                <div class="content">
                  Nom Bénéficiaire : 
                  <span class="fw-bold"> <?= $name_benef; ?> </span>
                </div>
              </div>
              <div>
                <div class="content">
                  Téléphone : 
                  <span class="fw-bold"> <?= $phone_benef; ?> </span>
                </div>
              </div>
              <div>
                <div class="content">
                  Reseaux : 
                  <span class="fw-bold"> <?= $network; ?> </span>
                </div>
              </div>
            <?php
          }
        ?>
        <!-- Statut -->
        <div class="mt-3 mb-2">
          <div class="content">
            Reception :
            <?php
              if ($transfert_type == 'send') {
                echo '<span style="background-color: #27ae60;" class="badge text-white fw-bold">
                  <i class="fa-solid fa-toggle-on"></i>
                  Confirmé
                </span>';
              } else if ($transfert_type == 'paiement' && $reception_statut == 'enabled') {
                echo '<span style="background-color: #27ae60;" class="badge text-white fw-bold">
                  <i class="fa-solid fa-toggle-on"></i>
                  Validé
                </span>';
              } else {
                echo '<span style="background-color: #fed330;" class="badge text-dark fw-bold">
                  <i class="fa-solid fa-toggle-off"></i>
                  En attente
                </span>';
              }
            ?>
          </div>
        </div>
        <!-- Name Payeur -->
        <div class="mb-2">
          <div class="content">
            Payeur :
            <?php
              if ($transfert_type == 'send') {
                if ($reception_statut == 'enabled') {
                  ?>
                    <span style="background-color: #27ae60;" class="badge text-white fw-bold">
                      <i class="fa-solid fa-check-circle"></i>
                      <?= $agent_af; ?>
                    </span>
                  <?php
                } else {
                  echo '<span style="background-color: #fc5c65;" class="badge text-white fw-bold">
                    <i class="fa-solid fa-toggle-off"></i>
                    En attente
                  </span>';
                }
              } else if ($transfert_type == 'paiement') {
                if (!$agent_payeur) {
                  if ($stat_paiement == 'disabled') {
                    echo '<span style="background-color: #fed330;" class="badge text-dark fw-bold">
                      <i class="fa-solid fa-toggle-off"></i>
                      En attente
                    </span>';
                  }
                } else {
                  ?>
                    <span style="background-color: #27ae60;" class="badge text-white fw-bold">
                      <i class="fa-solid fa-check-circle"></i>
                      <?= $agent_payeur; ?>
                    </span>
                  <?php
                }
              } 
            ?>
          </div>
        </div>
        
        <!-- Payeur -->
        <?php
          if ($transfert_type == 'paiement') {
            if ($reception_statut == 'enabled') {
              if (!$agent_payeur) {
                if ($stat_paiement == 'disabled') {
                  ?>
                    <div class="border my-3"></div>
                    <div>
                      <i class="fa-solid fa-user-circle"></i>
                      Choix Payeur
                      <form method="POST">
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

                        <div class="float-end mt-3">
                          <button name="set_payer" class="btn btn-sm">Envoyer</button>
                        </div>
                      </form>
                    </div>
                  <?php
                }
              }
            }
          }
        ?>
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