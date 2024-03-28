<?php
  require('../../backend/security/security.php');
  require('../../backend/auth/authProfile.php');
  require('../../backend/db/database.php');

  $account_id = $_SESSION['id'];

  if (!isset($_SESSION['account_type'])) {
    header('Location: ./admin');
  }

  if (isset($_SESSION['user_admin'])) {
    $login_name = $_SESSION['user_admin'];
  }

  $getAccountInfos = $db->prepare('SELECT account_type, gains FROM `other_profile` WHERE id = ?');
  $getAccountInfos->execute([$account_id]);

  // If we have a result after request
  if ($getAccountInfos->rowCount() > 0) {
    // Get result
    $accountInfosResult = $getAccountInfos->fetch();
    // Get variables
    $acc_type = $accountInfosResult['account_type'];
    $gains = $accountInfosResult['gains'];
  }

  // ============= Paiement Logic ============= //
  $getAllAgentCountryP = $db->prepare('SELECT account_name, account_type, account_contry FROM `other_profile`');
  $getAllAgentCountryP->execute([]);

  $getAllAgentNameP = $db->prepare('SELECT account_name, account_type FROM `other_profile`');
  $getAllAgentNameP->execute([]);

  // Logic to init a manuel transaction
  if (isset($_POST['init_paiement'])) {
    // secrure data function
    function secure_data_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }
    // Get variables
    $init_agentCountry = secure_data_input($_POST['agent_contry']);
    $init_agentName = secure_data_input($_POST['agent_name']);
    $init_amountReceive = secure_data_input($_POST['amount_received']);
    $init_network = secure_data_input($_POST['network']);
    $init_receiverName = secure_data_input($_POST['receiver_name']);
    $init_amountToSend = $_POST['amount_to_send'];
    $init_type_form = $_POST['type_form'];
    $banque_russe = isset($_POST['network_russie']) ? secure_data_input($_POST['network_russie']) : '';
    $other_banque_russe = isset($_POST['other_bank_r']) ? secure_data_input($_POST['other_bank_r']) : '';
    $benef_number_phone = secure_data_input($_POST['receiver_phone']);

    // Verifie if fields are not empty
    if (!empty($_POST['agent_contry']) && !empty($_POST['agent_name']) && !empty($_POST['amount_received']) && !empty($_POST['network'])) {

      // Get current date
      $current_date = date("d/m/Y");
      // Get current time
      $time_transaction = date("H:i:s");

      // Set wave amount
      if ($init_network == 'Wave Money') {
        $wave_amount_res = $init_amountReceive * 0.99;
      } else {
        $wave_amount_res = 0;
      }

      // Set gains
      if ($init_type_form == 'paiement') {
        $gains_value = 0.005;
        $gains_of_transac = ($init_amountToSend * $gains_value);
      }

      // Save in data base
      $insertManuelTransaction = $db->prepare('INSERT INTO `manuel_transaction`(agent_contry, agent_name, amount_received, amount_to_send, network, receiver_name, current_agent_name, type_form, date, network_russie, other_bank_r, receiver_phone, trans_gains, wave_amount, current_hours, type_of_acc) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
      $insertManuelTransaction->execute([
        $init_agentCountry,
        $init_agentName,
        $init_amountReceive,
        $init_amountToSend,
        $init_network,
        $init_receiverName,
        $login_name,
        $init_type_form,
        $current_date,
        $banque_russe,
        $other_banque_russe,
        $benef_number_phone,
        $gains_of_transac,
        $wave_amount_res,
        $time_transaction,
        $acc_type
      ]);

      // Set Solde and gains
      if ($acc_type == 'ChapMoney') {
        if ($init_type_form == "paiement") {
          // Gains
          $gains_value = 0.005;
          $new_gains = $gains += ($init_amountToSend * $gains_value);

          // Save new solde in db
          $new_solde = $db->prepare("UPDATE `other_profile` SET gains = ".$new_gains." WHERE id = ?");
          $new_solde->execute([$account_id]);
        }
      }

      // Success message
      $_SESSION['success'] = 'Transcation effectuée.';
      header('Location: ./dashboard');
    } else {
      $_SESSION['emptyFiled'] = 'Renseignez les champs obligatoires.';
    }
  }

  // Cancel
  if (isset($_POST['back'])) {
    header('Location: ./dashboard');
  }
?>


<!DOCTYPE html>
<html lang="fr">
<?php 
  include './include/adminHead.php'; 
  include '../../views/assets/css/global.php';
  include '../../views/assets/admin/css/globalAdminCSS.php';
?>
<style>
  body {
    background-color: #003580;
  }
</style>
<body>
  <div class="container">
    <!-- Error messages -->
    <?php include '../../views/includes/alerts/alert_emptyFields.php'; ?>

    <h5 class="my-4 text-white">
      <i class="fa-solid fa-paper-plane"></i>
      Initier un Paiement
    </h5>

    <div class="card my-5">
      <div class="card-body">
        <form method="POST">
          <input type="hidden" name="type_form" value="paiement" class="form-control form-control-sm" readonly>
          <!-- Title -->
          <div class="my-3">
            <span class="fw-bold" style="color: var(--primary-color);">Agent</span>
            <div class="border"></div>
          </div>
          <div class="d-flex align-items-center">
            <!-- Select Country -->
            <div class="me-2 w-100" style="color: #7f8c8d; font-size: .850rem;">
              <label class="fw-bold">Pays *</label>
              <select id="paiement_agent_country" class="form-select form-select-sm" name="agent_contry">
                <option value=""></option>
                <?php
                  while ($resultCountry_paiement = $getAllAgentCountryP->fetch()) {
                    $country_result_p = $resultCountry_paiement['account_contry'];
                    $name_result_acc_p = $resultCountry_paiement['account_name'];
                    $type_result_acc_p = $resultCountry_paiement['account_type'];

                    if ($type_result_acc_p == 'Afrique') {
                      if ($login_name !== $name_result_acc_p) {
                        ?>
                          <option value="<?= $country_result_p; ?>">
                            <?= $country_result_p; ?>
                          </option>
                        <?php
                      }
                    }
                  }
                ?>
              </select>
            </div>
            <!-- Select Agent Name -->
            <div class="w-100" style="color: #7f8c8d; font-size: .850rem;">
              <label class="fw-bold">Nom *</label>
              <select class="form-select form-select-sm" name="agent_name">
                <option value=""></option>
                <?php
                  while ($result = $getAllAgentNameP->fetch()) {
                    $name_result = $result['account_name'];
                    $acc_type_result = $result['account_type'];

                    if ($acc_type_result == 'Afrique') {
                      if ($login_name !== $name_result) {
                        ?>
                          <option value="<?= $name_result; ?>"><?= $name_result; ?></option>
                        <?php
                      }
                    }
                  }
                ?>
              </select>
            </div>
          </div>
          <!-- Title -->
          <div class="my-3">
            <span class="fw-bold" style="color: var(--primary-color);">Montant + Réseaux</span>
            <div class="border"></div>
          </div>
          <div class="my-2 d-flex align-items-center">
            <!-- Amount receive -->
            <div class=" w-100 me-2" style="color: #7f8c8d; font-size: .850rem;">
              <label class="fw-bold">Somme reçue *</label>
              <input id="paiement_amount" type="number" class="form-control form-control-sm" min="1" name="amount_received" placeholder="1000">
            </div>
            <!-- Amount to send -->
            <div class=" w-100" style="color: #7f8c8d; font-size: .850rem;">
              <label class="fw-bold">A transférer</label>
              <input id="paiement_amount_result" class="form-control form-control-sm" name="amount_to_send" readonly />
            </div>
          </div>
          <div class="" style="color: #7f8c8d; font-size: .850rem;">
            <label class="fw-bold">R. Mobile *</label>
            <select class="form-select form-select-sm" name="network">
              <option value=""></option>
              <option value="Orange Money">Orange Money</option>
              <option value="Moov Money">Moov Money</option>
              <option value="MTN Money">MTN Money</option>
              <option value="Wave Money">Wave Money</option>
              <option value="MTN Areeba">MTN Areeba</option>
              <option value="AIRTEL Mobile Money">AIRTEL Mobile Money</option>
              <option value="Flooz">Flooz</option>
              <option value="TMONEY">TMONEY</option>
              <option value="Mpesa">Mpesa</option>
            </select>
          </div>
          <!-- Title -->
          <div class="my-3">
            <span class="fw-bold" style="color: var(--primary-color);">Bénéficiaire</span>
            <div class="border"></div>
          </div>
          <!-- Network -->
          <?php
            if ($acc_type == 'ChapMoney') {
              ?>
                <div class="d-flex align-items-center my-2">
                  <div class="w-100 me-2" style="color: #7f8c8d; font-size: .850rem;">
                    <label class="fw-bold">Banque russe *</label>
                    <select class="form-select form-select-sm" name="network_russie">
                      <option value=""></option>
                      <option value="CBerBank">SBerBank</option>
                      <option value="Tinkoff">Tinkoff</option>
                      <option value="VTB">VTB</option>
                      <option value="PotchtaBank">PotchtaBank</option>
                    </select>
                  </div>
                  <div class="w-100" style="color: #7f8c8d; font-size: .850rem;">
                    <label class="fw-bold">Autre banque russe</label>
                    <input type="text" class="form-control form-control-sm" name="other_bank_r">
                  </div>
                </div>
              <?php
            }
          ?>
          <!-- Nom du bénéficiaire -->
          <div class="d-flex align-items-center">
            <div class="w-100 me-2" style="color: #7f8c8d; font-size: .850rem;">
              <label class="fw-bold">Nom *</label>
              <input type="text" class="form-control form-control-sm" name="receiver_name">
            </div>
            <!-- Number Phone -->
            <div class="w-100" style="color: #7f8c8d; font-size: .850rem;">
              <label class="fw-bold">Numéro *</label>
              <input type="text" class="form-control form-control-sm" name="receiver_phone" placeholder="+7 000 00 00 00 00">
            </div>
          </div>

          <!-- Action button -->
          <div class="float-end mt-4">
            <button class="btn btn-sm mx-2" name="init_paiement">
              <i class="fa-solid fa-paper-plane"></i>
              Initier le paiement
            </button>
            <button name="back" class="btn btn-prev fw-bold btn-sm" data-bs-dismiss="modal">Annuler</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <?php include '../../backend/src/rateTansactionMan.php'; ?>

  <script>
    window.onload = (event) => {
      let myToast = document.querySelector('.toast')
      let alertToast = new bootstrap.Toast(myToast)
      alertToast.show()
    }

    // DOM Elements
    const paiementAmout = document.getElementById('paiement_amount')
    const paiementAmoutResult = document.getElementById('paiement_amount_result')
    const paiementAgentCountry = document.getElementById('paiement_agent_country')

    // EVENT LISTENER SEND
    paiementAgentCountry.addEventListener('change', setAmountPaiement)
    paiementAmout.addEventListener('input', convertPaiement)

    // Global Variables
    let selectPaiementValue;

    // PAIEMENT FUNCTION
    function setAmountPaiement() {
      // Get paiement selected value
      selectPaiementValue = paiementAgentCountry.value

      convertPaiement()
    }

    // PAIEMENT Convertor
    function convertPaiement() {
      // Get user input value
      let userInputValue = paiementAmout.value;

      if (selectPaiementValue == 'CIV' || selectPaiementValue == 'Mali' || selectPaiementValue == 'Burkina' || selectPaiementValue == 'Benin' || selectPaiementValue == 'Sénégal') {
        const amountWithFrais = userInputValue * <?= $frais_civ_ml_bf_sen_ben; ?>;
        const finalAmountP = amountWithFrais * <?= $rate_XOF_to_RUB; ?>;
        paiementAmoutResult.value = finalAmountP;
      }
      else if (selectPaiementValue == 'Togo' || selectPaiementValue == 'Niger') {
        const amountWithFrais = userInputValue * <?= $frais_tog_nig; ?>;
        const finalAmount = amountWithFrais * <?= $rate_XOF_to_RUB; ?>;
        paiementAmoutResult.value = finalAmount;
      }
      else if (selectPaiementValue == 'Guinée') {
        const finalAmount = userInputValue * <?= $guinee_vers_rus; ?>;
        paiementAmoutResult.value = finalAmount;
      }
      else if (selectPaiementValue == 'Congo Brazaville') {
        const amountWithFrais = userInputValue * <?= $frais_congo; ?>;
        const finalAmount = amountWithFrais * <?= $rate_XAF_to_RUB; ?>;
        paiementAmoutResult.value = finalAmount;
      } 
      else if (selectPaiementValue == 'Gabon') {
        const amountWithFrais = userInputValue * <?= $frais_gabon; ?>;
        const finalAmount = amountWithFrais * <?= $rate_XAF_to_RUB; ?>;
        paiementAmoutResult.value = finalAmount;
      }
      else if (selectPaiementValue == 'Cameroun'  || selectPaiementValue == 'Tchad') {
        const amountWithFrais = userInputValue * <?= $frais_camer; ?>;
        const finalAmount = amountWithFrais * <?= $rate_XAF_to_RUB; ?>;
        paiementAmoutResult.value = finalAmount;
      } 
      else if (selectPaiementValue == 'RDC') {
        const amountWithFrais = userInputValue * <?= $frais_rdc; ?>;
        const finalAmount = amountWithFrais * <?= $rate_DOL_to_RUB; ?>;
        paiementAmoutResult.value = finalAmount;
      } 
      else {
        paiementAmoutResult.value = '';
      }
    }

    // Call Function
    setAmountPaiement()
  </script>
</body>
</html>