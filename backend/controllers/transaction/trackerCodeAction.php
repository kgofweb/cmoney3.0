<?php
require('../backend/security/security.php');
require('../backend/db/database.php');

if (isset($_POST['code_status'])) {
  if (!empty($_POST['code'])) {
    // Get code value typed by user
    $codeTypedByUser = htmlspecialchars(trim(stripslashes($_POST['code'])));

    $checkIfCodeExist = $db->prepare('SELECT verification_code, number_verified FROM new_transaction WHERE verification_code = ?');
    $checkIfCodeExist->execute([$codeTypedByUser]);
    $statusResult = $checkIfCodeExist->fetch();

    // Si le code a été trouvé 
    if ($checkIfCodeExist->rowCount() > 0) {
      $codeInDB = $statusResult['verification_code'];

      // Si le code correspond à celui dans la base de donée
      if ($codeTypedByUser == $codeInDB) {
        if ($statusResult['number_verified'] !== NULL) {
          // Le code a été activé
          $codeVerified = $statusResult['number_verified'];
          $codeVerifiedAtHeight = $statusResult['verification_code'];
        } else {
          $codeNotVerified = $codeInDB;
        }
      } else {
        $errorMessage = "Code invalide !";
      }
    } else {
      $errorMessage = "Code invalide !";
    }
  } else {
    $errorMessage = "Votre code s'il vous plait !";
  }
}