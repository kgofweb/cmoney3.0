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

  $getAccountInfos = $db->prepare('SELECT account_name, account_type, account_contry, account_solde, gains FROM `other_profile` WHERE id = ?');
  $getAccountInfos->execute([$account_id]);

  // If we have a result after request
  if ($getAccountInfos->rowCount() > 0) {
    // Get result
    $accountInfosResult = $getAccountInfos->fetch();
    // Get variables
    $acc_name = $accountInfosResult['account_name'];
    $acc_type = $accountInfosResult['account_type'];
    $acc_country = $accountInfosResult['account_contry'];
    $acc_solde = $accountInfosResult['account_solde'];
    $gains = $accountInfosResult['gains'];
  }

  // ============= Get all Agent Name ============= //
  $getAllAgentName = $db->prepare('SELECT account_name, account_type FROM `other_profile`');
  $getAllAgentName->execute([]);

  $getAllAgentCountry = $db->prepare('SELECT account_name, account_type, account_contry FROM `other_profile`');
  $getAllAgentCountry->execute([]);

  // Logic to init a manuel transaction
  if (isset($_POST['init_send'])) {

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
    $benef_number_phone = secure_data_input($_POST['receiver_phone']);

    // Verifie if fields are not empty
    if (!empty($_POST['agent_contry']) && !empty($_POST['agent_name']) && !empty($_POST['amount_received']) && !empty($_POST['network'])) {

      // Get current date
      $current_date = date("d/m/Y");
      // Get current time
      $time_transaction = date("H:i:s");

      if ($init_type_form == 'send') {
        // GAINS
        $gains_value = 0.005;
        $gains_of_transac = ($init_amountReceive * $gains_value);
      }

      // Save in data base
      $insertManuelTransaction = $db->prepare('INSERT INTO `manuel_transaction`(agent_contry, agent_name, amount_received, amount_to_send, network, receiver_name, current_agent_name, type_form, date, receiver_phone, trans_gains, current_hours, type_of_acc) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
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
        $benef_number_phone,
        $gains_of_transac,
        $time_transaction,
        $acc_type
      ]);

      // Solde et gains
      if ($acc_type == 'ChapMoney') {
        if ($init_type_form == "send") {
          // New Solde
          $new_account = $acc_solde += $init_amountReceive;

          // Gains
          $gains_value = 0.005;
          $new_gains = $gains += ($init_amountReceive * $gains_value);

          // Save new solde in db
          $new_solde = $db->prepare("UPDATE `other_profile` SET account_solde = ".$new_account.", gains = ".$new_gains." WHERE id = ?");
          $new_solde->execute([$account_id]);
        }
      } else if ($acc_type == 'Afrique') {
        if ($init_type_form == "send" && ($login_name == $acc_name)) {
          // New Solde
          $new_account = $acc_solde += $init_amountReceive;

          // Gains
          $gains_value = 0.005;
          $new_gains = $gains += ($init_amountReceive * $gains_value);

          // Save new solde in db
          $new_solde = $db->prepare("UPDATE `other_profile` SET account_solde = ".$new_account.", gains = ".$new_gains." WHERE id = ?");
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
      Initier un Envoi
    </h5>

    <div class="card my-5">
      <div class="card-body">
        <form method="POST">
          <!-- Title -->
          <div class="my-3">
            <span class="fw-bold" style="color: var(--primary-color);">Agent Afrique</span>
            <div class="border"></div>
          </div>
          <input type="hidden" name="type_form" value="send" class="form-control form-control-sm" readonly>
          <!-- Select Country -->
          <div class="d-flex align-items-center">
            <div class="w-100 me-2" style="color: #7f8c8d; font-size: .850rem;">
              <label class="fw-bold">Pays *</label>
              <select id="send_agent_country" class="form-select form-select-sm" name="agent_contry">
                <option value=""></option>
                <?php
                  while ($resultCountry = $getAllAgentCountry->fetch()) {
                    $country_result = $resultCountry['account_contry'];
                    $name_result_acc = $resultCountry['account_name'];
                    $type_result_acc = $resultCountry['account_type'];

                    if ($type_result_acc == 'Afrique') {
                      if ($login_name !== $name_result_acc) {
                        ?>
                          <option value="<?= $country_result; ?>">
                            <?= $country_result; ?>
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
                  while ($result = $getAllAgentName->fetch()) {
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
            <span class="fw-bold" style="color: var(--primary-color);">Montant</span>
            <div class="border"></div>
          </div>
          <div class="my-2 d-flex align-items-center">
            <!-- Amount receive -->
            <div class=" w-100 me-2" style="color: #7f8c8d; font-size: .850rem;">
              <label class="fw-bold">Somme reçue *</label>
              <input type="number" id="send_amount" class="form-control form-control-sm" min="1" name="amount_received" placeholder="1000">
            </div>
            <!-- Amount to send -->
            <div class=" w-100" style="color: #7f8c8d; font-size: .850rem;">
              <label class="fw-bold">A transférer</label>
              <input id="send_amount_result" class="form-control form-control-sm" name="amount_to_send" readonly />
            </div>
          </div>
          <!-- Title -->
          <div class="my-3">
            <span class="fw-bold" style="color: var(--primary-color);">Réseaux</span>
            <div class="border"></div>
          </div>
          <!-- Network -->
          <div style="color: #7f8c8d; font-size: .850rem;">
            <label class="fw-bold">Réseaux Mobile *</label>
            <select class="form-select form-select-sm" name="network">
              <option value=""></option>
              <option value="Orange Money">Orange Money</option>
              <option value="Moov Money">Moov Money</option>
              <option value="MTN Money">MTN Money</option>
              <option value="Wave Money">Wave Money</option>
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
          <!-- Nom du bénéficiaire -->
          <div class="d-flex my-2" style="color: #7f8c8d; font-size: .850rem;">
            <div class="w-100 me-2">
              <label class="fw-bold">Nom</label>
              <input type="text" class="form-control form-control-sm" name="receiver_name">
            </div>
            <!-- Number Phone -->
            <div class="w-100">
              <label class="fw-bold">Numéro</label>
              <input type="text" class="form-control form-control-sm" name="receiver_phone" placeholder="+225 00 00 00 00 00">
            </div>
          </div>

          <!-- Action button -->
          <div class="float-end mt-3">
            <button class="btn btn-sm mx-2" name="init_send">
              <i class="fa-solid fa-paper-plane"></i>
              Initier l'envoi
            </button>
            <button name="back" class="btn btn-prev fw-bold btn-sm">Annuler</button>
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
    const sendAmount = document.getElementById('send_amount')
    const sendAmountResult = document.getElementById('send_amount_result')
    const sendAgentCountry = document.getElementById('send_agent_country')

    // EVENT LISTENER SEND
    sendAgentCountry.addEventListener('change', setAmount)
    sendAmount.addEventListener('input', convert)

    // Global Variables
    let selectValue;

    // SEND FUNCTION
    function setAmount() {
      // Get selected value
      selectValue = sendAgentCountry.value;
      convert();
    }

    // Account Type
    const acc_type = <?= json_encode($acc_type); ?>;
    const acc_count = <?= json_encode($acc_country); ?>;

    // SEND Convertor
    function convert() {
      // Get user input value
      const userInputValue = sendAmount.value;

      if (acc_type == 'ChapMoney') {
        if (selectValue == 'CIV' || selectValue == 'Benin' || selectValue == 'Burkina' || selectValue == 'Mali' || selectValue == 'Sénégal' || selectValue == 'Togo' || selectValue == 'Niger') {
          const finalAmount = userInputValue * <?= $rate_RUB_to_XOF_XAF; ?>;
          sendAmountResult.value = finalAmount;
        } 
        else if (selectValue == 'Guinée') {
          const finalAmount = userInputValue * <?= $rate_RUB_to_GUIN; ?>;
          sendAmountResult.value = finalAmount;
        } 
        else if (selectValue == 'Cameroun' || selectValue == 'Congo Brazaville' || selectValue == 'Gabon' || selectValue == 'Tchad') {
          const finalAmount = userInputValue * <?= $rate_RUB_to_XOF_XAF; ?>;
          sendAmountResult.value = finalAmount;
        } 
        else if (selectValue == 'RDC') {
          const finalAmount = userInputValue * <?= $rate_RUB_to_DOL; ?>;
          sendAmountResult.value = finalAmount;
        }
        else {
          sendAmountResult.value = '';
        }
      } 
      else if (acc_type == 'Afrique') {
        if ((acc_count == 'CIV' || acc_count == 'Mali' || acc_count == 'Burkina' || acc_count == 'Benin' || acc_count == 'Sénégal') && (selectValue == 'CIV' || selectValue == 'Mali' || selectValue == 'Burkina' || selectValue == 'Benin' || selectValue == 'Sénégal')) {
          const amountWithFrais = userInputValue * <?= $ouest_to_ouest; ?>;
          const finalAmount = amountWithFrais * <?= $rate; ?>;
          sendAmountResult.value = finalAmount;
        } 
        else if ((acc_count == 'CIV' || acc_count == 'Mali' || acc_count == 'Burkina' || acc_count == 'Benin' || acc_count == 'Sénégal') && (selectValue == 'Cameroun' || selectValue == 'Congo Brazaville' || selectValue == 'Gabon' || selectValue == 'RDC' || selectValue == 'Tchad')) {
          const amountWithFrais = userInputValue * <?= $ouest_to_center; ?>;
          const finalAmount = amountWithFrais * <?= $rate; ?>;
          sendAmountResult.value = finalAmount;
        }
        else if ((acc_count == 'Cameroun' || acc_count == 'Congo Brazaville' || acc_count == 'Gabon' || acc_count == 'RDC' || acc_count == 'Tchad') && (selectValue == 'Cameroun' || selectValue == 'Congo Brazaville' || selectValue == 'Gabon' || selectValue == 'RDC' || selectValue == 'Tchad')) {
          const amountWithFrais = userInputValue * <?= $center_to_center; ?>;
          const finalAmount = amountWithFrais * <?= $rate; ?>;
          sendAmountResult.value = finalAmount;
        }
        else if ((acc_count == 'Cameroun' || acc_count == 'Congo Brazaville' || acc_count == 'Gabon' || acc_count == 'RDC' || acc_count == 'Tchad') && (selectValue == 'CIV' || selectValue == 'Mali' || selectValue == 'Burkina' || selectValue == 'Benin' || selectValue == 'Sénégal')) {
          const amountWithFrais = userInputValue * <?= $center_to_ouest; ?>;
          const finalAmount = amountWithFrais * <?= $rate; ?>;
          sendAmountResult.value = finalAmount;
        }
        // ============= GUINEE ============= //
        else if ((acc_count == 'CIV' || acc_count == 'Mali' || acc_count == 'Burkina' || acc_count == 'Benin' || acc_count == 'Sénégal') && (selectValue == 'Guinée')) {
          const amountWithFrais = userInputValue * <?= $frais_XOF_to_FGN; ?>;
          const finalAmount = amountWithFrais * <?= $rate_XOF_to_FGN; ?>;
          sendAmountResult.value = finalAmount;
        }
        else if ((acc_count == 'Guinée') && (selectValue == 'CIV' || selectValue == 'Mali' || selectValue == 'Burkina' || selectValue == 'Benin' || selectValue == 'Sénégal')) {
          const amountWithFrais = userInputValue * <?= $frais_FGN_to_XOF; ?>;
          const finalAmount = amountWithFrais * <?= $rate_FGN_to_XOF; ?>;
          sendAmountResult.value = finalAmount;
        }
        else if ((acc_count == 'Cameroun' || acc_count == 'Congo Brazaville' || acc_count == 'Gabon' || acc_count == 'RDC' || acc_count == 'Tchad') && (selectValue == 'Guinée')) {
          const amountWithFrais = userInputValue * <?= $frais_XAF_to_FGN; ?>;
          const finalAmount = amountWithFrais * <?= $rate_XAF_to_FGN; ?>;
          sendAmountResult.value = finalAmount;
        }
        else if ((acc_count == 'Guinée') && (selectValue == 'Cameroun' || selectValue == 'Congo Brazaville' || selectValue == 'Gabon' || selectValue == 'RDC' || selectValue == 'Tchad')) {
          const amountWithFrais = userInputValue * <?= $frais_FGN_to_XAF; ?>;
          const finalAmount = amountWithFrais * <?= $rate_FGN_to_XAF; ?>;
          sendAmountResult.value = finalAmount;
        }
        else {
          sendAmountResult.value = '';
        }
      }
    }

    // Call Function
    setAmount()
  </script>
</body>
</html>