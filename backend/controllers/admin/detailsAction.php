<?php
require('../../backend/security/security.php');
require('../../backend/auth/authAdmin.php');
require('../../backend/db/database.php');
require('../../backend/env/decrypt.php');

if (isset($_SESSION['user_admin'])) {
  $login_name = $_SESSION['user_admin'];
}

if (isset($_GET['id']) AND !empty($_GET['id'])) {
  $idOfTansaction = base64_decode($_GET['id']);

  // Get infos of transaction
  $getDataDetails = $db->prepare('SELECT * FROM `new_transaction` WHERE id = ?');
  $getDataDetails->execute([$idOfTansaction]);

  $details = $getDataDetails->fetch();

  $idTransaction = $details['id'];
  $senderCountryDec = $details['countryOne'];
  $receiverCountryDec = $details['countryTwo'];
  $code = $details['verification_code'];
  $modeSendDec = $details['sendMode'];
  $senderPhoneDec = $details['numberPhoneOne'];
  $receiverNameDec = $details['receiver_name'];
  $senderModeDec = $details['sendMode'];
  $receiverModeDec = $details['receiveMode'];
  $receiverPhone = $details['numberPhoneTwo'];
  $dateTransaction = $details['date'];
  $timeTransaction = $details['time'];
  $amount_received = $details['amount'];
  // AF Agent
  $af_agent = $details['af_name'];
  $statusOTP = $details['number_verified'];

  $senderCountry = openssl_decrypt($senderCountryDec, $chiper, $key, $options, $iv);
  $receiverCountry = openssl_decrypt($receiverCountryDec, $chiper, $key, $options, $iv);
  $modeSending = openssl_decrypt($modeSendDec, $chiper, $key, $options, $iv);
  $senderPhone = openssl_decrypt($senderPhoneDec, $chiper, $key, $options, $iv);
  $receiverName = openssl_decrypt($receiverNameDec, $chiper, $key, $options, $iv);
  $receiverMode = openssl_decrypt($receiverModeDec, $chiper, $key, $options, $iv);
  $senderMode = openssl_decrypt($senderModeDec, $chiper, $key, $options, $iv);

  $getAllAgentName = $db->prepare('SELECT account_name FROM `other_profile` WHERE account_type = "Afrique"');
  $getAllAgentName->execute([]);

  if (isset($senderCountry)) {
    if ($senderCountry == 'russie') {
      $type_of_transac = 'russian_to_afrique';
    } else {
      $type_of_transac = 'afrique_to_russian';
    }
  }

  if (isset($_POST['set_af'])) {
    // Get agent name
    $af_name = $_POST['af_agent_name'];

    // Set amount wave
    if ($senderMode == 'Wave Money') {
      $wave_amount_res = $amount_received * 0.99;
    }

    if (!empty($af_name)) {
      // Transférer la transaction
      $update_client_transaction = $db->prepare("UPDATE `new_transaction` SET af_name = ?, admin_name = ?, type_transac_site = ?, amount_wave = ? WHERE id = ? ");
      $update_client_transaction->execute([$af_name, $login_name, $type_of_transac, $wave_amount_res, $idOfTansaction]);

      $_SESSION['success'] = 'Transfert effectué';
      header('Location: ./dashboard');

    } else {
      $_SESSION['emptyFiled'] = 'Definir un agent';
    }
  }

  $getAgentName = $db->prepare('SELECT af_name FROM `new_transaction` WHERE id = ?');
  $getAgentName->execute([$idOfTansaction]);

  if ($getAgentName->rowCount() > 0) {
    while ($fetch_res = $getAgentName->fetch(PDO::FETCH_ASSOC)) {
      $name = $fetch_res['af_name'];
    }
  }

  // Money devise
  switch ($senderCountry) {
    case 'civ':
      $changes = 'FCFA';
      break;
    case 'mali':
      $changes = 'FCFA';
      break;
    case 'senegal':
      $changes = 'FCFA';
      break;
    case 'benin':
      $changes = 'FCFA';
      break;
    case 'cameroun':
      $changes = 'FCFA';
      break;
    case 'congo':
      $changes = 'FCFA';
      break;
    case 'gabon':
      $changes = 'FCFA';
      break;
    case 'togo':
      $changes = 'FCFA';
      break;
    case 'guinee':
      $changes = 'GNF';
      break;
    case 'burkina':
      $changes = 'FCFA';
      break;
    case 'niger':
      $changes = 'FCFA';
      break;
    case 'rdc':
      $changes = '<i class="fa-solid fa-dollar-sign"></i>';
      break;
    case 'russie':
      $changes = '<i class="fa-solid fa-ruble-sign"></i>';
      break;
  }

  switch ($receiverCountry) {
    case 'civ':
      $change = 'FCFA';
      break;
    case 'mali':
      $change = 'FCFA';
      break;
    case 'senegal':
      $change = 'FCFA';
      break;
    case 'benin':
      $change = 'FCFA';
      break;
    case 'cameroun':
      $change = 'FCFA';
      break;
    case 'congo':
      $change = 'FCFA';
      break;
    case 'gabon':
      $change = 'FCFA';
      break;
    case 'togo':
      $change = 'FCFA';
      break;
    case 'rdc':
      $change = '<i class="fa-solid fa-dollar-sign"></i>';
      break;
    case 'burkina':
      $change = 'FCFA';
      break;
    case 'tchad':
      $change = 'FCFA';
      break;
    case 'guinee':
      $change = 'GNF';
      break;
    case 'centreAfrique':
      $change = 'FCFA';
      break;
      case 'niger':
      $change = 'FCFA';
      break;
    case 'russie':
      $change = '<i class="fa-solid fa-ruble-sign"></i>';
      break;
  }
}