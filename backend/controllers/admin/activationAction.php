<?php 
require('../../backend/security/security.php');
require('../../backend/auth/authAdmin.php');
require('../../backend/db/database.php');
require('../../backend/env/decrypt.php');

if (isset($_GET['id']) && !empty($_GET['id'])) {
  $idOfTansaction = base64_decode($_GET['id']);

  $account_id = $_SESSION['id'];

  $checkIfCodeExist = $db->prepare('SELECT id, sendMode, amount, amount_rouble, verification_code, amount_wave FROM `new_transaction` WHERE id = ?');
  $checkIfCodeExist->execute([$idOfTansaction]);

  $getAccountInfos = $db->prepare('SELECT account_solde, gains FROM `other_profile` WHERE id = ?');
  $getAccountInfos->execute([$account_id]);

  // Si l'id existe
  if ($checkIfCodeExist->rowCount() > 0) {
    // Récupérer les infos de la transaction
    $transactionInfos = $checkIfCodeExist->fetch();

    $idOfTransaction = $transactionInfos['id'];
    $otpCode = $transactionInfos['verification_code'];
    $amount_to_send = $transactionInfos['amount_rouble'];
    $amount_received = $transactionInfos['amount'];
    $amount_wave = $transactionInfos['amount_wave'];
    $sendModeClient = openssl_decrypt($transactionInfos['sendMode'], $chiper, $key, $options, $iv);

    if (isset($_POST['validate_code'])) {
      // Get infos of transaction
      $checkOtpExist = $db->prepare('SELECT countryOne, number_verified FROM `new_transaction` WHERE verification_code = ?');
      $checkOtpExist->execute(array($otpCode));

      $otpCheckInfo = $checkOtpExist->fetch();
      
      $req_senderCountry = openssl_decrypt($otpCheckInfo['countryOne'], $chiper, $key, $options, $iv);

      if ($checkOtpExist->rowCount() > 0) {
        // Si le code n'a pas encore été activé
        if ($otpCheckInfo['number_verified'] == NULL) {
          // Solde
          if ($req_senderCountry == 'russie') {
            if ($getAccountInfos->rowCount() > 0) {
              // Get result
              $accountInfosResult = $getAccountInfos->fetch();
              // Get variables
              $acc_solde = $accountInfosResult['account_solde'];
              $gains = $accountInfosResult['gains'];

              // New Solde
              $new_account = $acc_solde -= ($amount_to_send * 1.01);

              // Gains
              $gains_value = 0.005;
              $new_gains = $gains += ($amount_to_send * $gains_value);

              // Save new solde in db
              $new_solde = $db->prepare("UPDATE `other_profile` SET account_solde = ".$new_account.", gains = ".$new_gains." WHERE id = ?");
              $new_solde->execute([$account_id]);
            }
          } else {
            if ($getAccountInfos->rowCount() > 0) {
              // Get result
              $accountInfosResult = $getAccountInfos->fetch();
              // Get variables
              $acc_solde = $accountInfosResult['account_solde'];
              $gains = $accountInfosResult['gains'];

              // Set amount wave
              if ($sendModeClient == 'Wave Money') {
                $af_new_account = $acc_solde += $amount_wave;
              } else {
                $af_new_account = $acc_solde += $amount_received;
              }

              // Gains
              $gains_value = 0.005;
              $get_gains = $gains += ($amount_received * $gains_value);

              // Save new solde in db
              $af_new_solde = $db->prepare("UPDATE `other_profile` SET account_solde = ".$af_new_account.", gains = ".$get_gains." WHERE id = ?");
              $af_new_solde->execute([$account_id]);
            }
          }

          // Activer le code
          $checkOtpExist = $db->prepare("UPDATE new_transaction SET number_verified = NOW() WHERE verification_code = '" . $otpCode . "' AND verification_code = '" . $otpCode . "'");
          $checkOtpExist->execute(array());

          $_SESSION['success'] = 'Code activé avec success !';
          header('Location: ../admin/dashboard');
        }
      }
    }
  }
}

if (isset($_POST['drop_it'])) {
  header(htmlspecialchars('Location: ../admin/dashboard'));
}