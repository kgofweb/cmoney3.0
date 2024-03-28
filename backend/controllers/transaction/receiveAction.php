<?php
require('../backend/security/security.php');
require('../backend/db/database.php');

if (isset($_POST) & !empty($_POST)) {
  if (isset($_POST['csrf_token'])) {
    if ($_POST['csrf_token'] == $_SESSION['csrf_token']) {
      $max_time = 300;

      if (isset($_SESSION['token_time'])) {
        $token_time = $_SESSION['token_time'];

        if (($token_time + $max_time) >= time()) {
          // Logic
          if (isset($_POST['verify_otp'])) {
            // Get value of inputs
            $otp1 = $_POST['otp1'];
            $otp2 = $_POST['otp2'];
            $otp3 = $_POST['otp3'];
            $otp4 = $_POST['otp4'];
            $otp5 = $_POST['otp5'];

            // Concat
            $otpTypeByUser = $otp1.$otp2.$otp3.$otp4.$otp5;

            // Verify if inputs are not empty
            if (!empty($otpTypeByUser) && !empty($_POST['phoneNumber'])) {
              // secrure data function
              function secure_data_input($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
              }

              // Get phone number entered by user
              $numberTypedByUser = secure_data_input($_POST['phoneNumber']);

              // Check if otp exist
              $checkOtpExist = $db->prepare('SELECT verification_code, number_verified, numberPhoneTwo, amount_rouble FROM new_transaction WHERE verification_code = ?');
              $checkOtpExist->execute(array($otpTypeByUser));
              $otpCheckInfo = $checkOtpExist->fetch();

              // Si le code a été trouvé
              if ($checkOtpExist->rowCount() > 0) {
                // Check otp code and phone number matchs
                if ($otpTypeByUser == $otpCheckInfo['verification_code'] && $otpCheckInfo['number_verified'] !== NULL) {

                  if ($numberTypedByUser == $otpCheckInfo['numberPhoneTwo']) {
                    // Recupérer des variables
                    $montant_a_transferer = $otpCheckInfo['amount_rouble'];
                    $otpCode = $otpCheckInfo['verification_code'];

                    $_SESSION['montant_a_transferer'] = $montant_a_transferer;
                    $_SESSION['phoneNumber'] = $numberTypedByUser;
                    $_SESSION['otpCode'] = $otpCode;
                    $_SESSION['last_time'] = time();

                    $_SESSION['success'] = 'Continuer la procédure.';
                    header(htmlspecialchars('Location: ./receiveInfos'));

                  } else {
                    $_SESSION['error'] = 'Le code de vérification et le numéro de téléphone ne correspondent pas.';
                  }

                } else {
                  $_SESSION['error'] = 'Code pas encore activé. Vous pouvez le vérifier dans le menu SUIVI.';
                }
              } else {
                $_SESSION['error'] = 'Le code de vérification ne correspond à aucune transaction';
              }

            } else {
              $_SESSION['error'] = 'Veuillez entrer le code de vérification ou le numéro de téléphone.';
            } 
          }
          
        } else {
          unset($_SESSION['csrf_token']);
          unset($_SESSION['token_time']);

          $_SESSION['cancel'] = 'Session interompue. Vueillez reprendre.';
          header(htmlspecialchars('Location: ./home'));
        }
      }
    }
  }
}

$token = md5(uniqid(rand(), true));
$_SESSION['csrf_token'] = $token;
$_SESSION['token_time'] = time();