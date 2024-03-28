<?php
require('../backend/security/security.php');
require('../backend/db/database.php');

if (isset($_POST['code_status'])) {
  if (!empty($_POST['code'])) {
    // Get value typed by user
    $code = htmlspecialchars(trim(stripslashes($_POST['code'])));

    $checkIfCodeExist = $db->prepare('SELECT status_payement, verification_code, number_verified FROM new_transaction WHERE verification_code = ?');
    $checkIfCodeExist->execute([$code]);
    $statusResult = $checkIfCodeExist->fetch(); 

    // Si le code a été trouvé 
    if ($checkIfCodeExist->rowCount() > 0) {

      $statusPayement = $statusResult['status_payement'];
      $statusCode = $statusResult['verification_code'];
      
      // Si le code correspond à celui dans la base de donée
      if ($code == $statusCode) {
        // Le payement a été effectué
        if ($statusPayement !== NULL) {
          $payementVerified = $statusPayement;

          $getInfosWithdrawal = $db->prepare('SELECT name_withdrawal, number_phone_withdrawal FROM retrait WHERE code = ?');
          $getInfosWithdrawal->execute([$code]);
          $result = $getInfosWithdrawal->fetch();

          if ($getInfosWithdrawal->rowCount() > 0) {
            // Get infos data from db
            $userName = $result['name_withdrawal'];
            $usernamePhone = $result['number_phone_withdrawal'];
          }
        } else {
          $payementNotVerified = $statusCode;
        }
      } else {
        $errorMessage = 'Code invalide !';
      }

    } else {
      $errorMessage= 'Code invalide !';
    }
  } else {
    $errorMessage = "Votre code s'il vous plait !";
  }
}