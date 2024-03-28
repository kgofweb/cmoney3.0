<?php
require('../../backend/security/security.php');
require('../../backend/auth/authAdmin.php');
require('../../backend/db/database.php');
require('../../backend/env/decrypt.php');

if (isset($_GET['id']) AND !empty($_GET['id'])) {
  $idOfTansaction = base64_decode($_GET['id']);

  $checkIfCodeExist = $db->prepare('SELECT id, receiver_name, numberPhoneTwo, ask_withdrawal, status_payement, verification_code, payer FROM `new_transaction` WHERE id = ?');
  $checkIfCodeExist->execute(array($idOfTansaction));


  // Set payer statment
  $cm_account = 'ChapMoney';
  $p_account = 'Payeur';

  $getAllAgentName = $db->prepare("SELECT account_name FROM `other_profile` WHERE account_type = ?");
  $getAllAgentName->execute([$cm_account]);

  $getAllAgentNamePayeur = $db->prepare("SELECT account_name FROM `other_profile` WHERE account_type = ?");
  $getAllAgentNamePayeur->execute([$p_account]);

  if ($checkIfCodeExist->rowCount() > 0) {
    // Récupérer les infos de la transaction
    $transactionInfos = $checkIfCodeExist->fetch();

    $receiverName = $transactionInfos['receiver_name'];
    $receiverPhone = $transactionInfos['numberPhoneTwo'];
    $date = $transactionInfos['ask_withdrawal'];
    $status = $transactionInfos['status_payement'];
    $otpCode = $transactionInfos['verification_code'];
    $payer_agent = $transactionInfos['payer'];

    // Decrypt
    $receiverNameDec = openssl_decrypt($receiverName, $chiper, $key, $options, $iv);

    // Get Infos from retrait table
    $checkOtpExist = $db->prepare('SELECT * FROM `retrait` WHERE id_transaction = ?');
    $checkOtpExist->execute(array($idOfTansaction));

    $otpCheckInfo = $checkOtpExist->fetch();

    $code = $otpCheckInfo['code'];
    $nameUser = $otpCheckInfo['name_withdrawal'];
    $bankChooseByUser = $otpCheckInfo['bank_withdrawal'];
    $numberPhone = $otpCheckInfo['number_phone_withdrawal'];
    $amountRouble = $otpCheckInfo['montant_rouble'];
    $banqueNameTypedByUser = $otpCheckInfo['bankUser_withdrawal'];
    $transactionID = $otpCheckInfo['id_transaction'];

    if (isset($_POST['validate_payement'])) {
      if ($status == NULL) {

        $agent_payer_name = $_POST['payer_agent_name'];

        if (!empty($agent_payer_name)) {
          // Insert payer agent choosed in db
          $insert_payer = $db->prepare('UPDATE `retrait` SET payer = ? WHERE id_transaction = ?');
          $insert_payer->execute([$agent_payer_name, $transactionID]);

          $insert_payerTransac = $db->prepare('UPDATE `new_transaction` SET payer = ? WHERE id = ?');
          $insert_payerTransac->execute([$agent_payer_name, $idOfTansaction]);

          $_SESSION['success'] = 'Transféré avec success';
          header('Location: ../admin/dashboard');

        } else {
          $_SESSION['emptyFiled'] = 'Choisissez un agent';
        }
      }
    }
  }
}

// Come back
if (isset($_POST['back'])) {
  header('Location: ../admin/dashboard');
}