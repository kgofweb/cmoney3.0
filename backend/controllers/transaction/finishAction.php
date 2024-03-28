<?php
require('../backend/security/security.php');
require('../backend/env/decrypt.php');
require('../backend/db/database.php');

// PHP Mailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
// Import PHPMailer components
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if (!isset($_SESSION['verify_code'])) {
  header(htmlspecialchars('Location: ./home'));
} else if ((time() - $_SESSION['last_time']) > 700) {
  $_SESSION['error'] = 'Session a été annulée. Veuillez reprendre la procédure afin d\'obtenir un nouveau code.';
  header(htmlspecialchars('Location: ./home'));
} else {
  // Sender Country
  $senderCountry = $_SESSION['countryOne'];
  // Receiver Country
  $receiverCountry = $_SESSION['countryTwo'];
  // Receiver Name
  $receiverName = $_SESSION['receiver_name'];
  // Sender Mode
  $senderMode = $_SESSION['sendMode'];
  // Receiver Mode
  $receiverMode = $_SESSION['receiveMode'];
  // Sender Phone
  $senderPhone = $_SESSION['numberPhoneOne'];
  // Receiver Phone
  $receiverPhone = $_SESSION['numberPhoneTwo'];
  // Montant en rouble
  $amountRetrait = $_SESSION['amount_retrait'];
  // Code de verification
  $verification_code = $_SESSION['verify_code'];
  // Amount to send
  $amount = $_SESSION['amount'];
  // Pourcentage
  $percentage = $_SESSION['percentage'];
  // Amount + Frais
  $amount_plus_frais = ($percentage + $amount);

  // Encrypt data
  $senderCountry_encrypt = openssl_encrypt($senderCountry, $chiper, $key, $options, $iv);
  $senderMode_encrypt = openssl_encrypt($senderMode, $chiper, $key, $options, $iv);
  $receiverMode_encrypt = openssl_encrypt($receiverMode, $chiper, $key, $options, $iv);
  $senderPhone_encrypt = openssl_encrypt($senderPhone, $chiper, $key, $options, $iv);
  $receiverCountry_encrypt = openssl_encrypt($receiverCountry, $chiper, $key, $options, $iv);
  $receiverName_encrypt = openssl_encrypt($receiverName, $chiper, $key, $options, $iv);

  // Get date and Time
  $date_transaction = date("d/m/Y");
  $time_transaction = date("H:i:s");

  // Save date and time in a session
  $_SESSION['date'] = $date_transaction;
  $_SESSION['time'] = $time_transaction;

  // Money device
  require('../backend/devise/moneyDevise.php');

  if (isset($_POST['send'])) {
    
    // Send to email
    $mail = new PHPMailer(true);
    
    // Insert all data in data base
    $insertNewUser = $db->prepare('INSERT INTO new_transaction(countryOne, sendMode, receiveMode, numberPhoneOne, countryTwo, receiver_name, numberPhoneTwo, amount, amount_rouble, date, time, verification_code, number_verified, ask_withdrawal) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $insertNewUser->execute([
      $senderCountry_encrypt,
      $senderMode_encrypt,
      $receiverMode_encrypt,
      $senderPhone_encrypt, 
      $receiverCountry_encrypt,
      $receiverName_encrypt,
      $receiverPhone,
      $amount_plus_frais,
      $amountRetrait,
      $date_transaction,
      $time_transaction,
      $verification_code,
      NULL,
      NULL
    ]);
    
    // Send email Notifications
    try {
      //Send using SMTP
      $mail->isSMTP();
      //Set the SMTP server to send through
      $mail->Host = 'smtp.gmail.com';
      //Enable SMTP authentication
      $mail->SMTPAuth = true;
      //SMTP username
      $mail->Username = 'chapmoneyapp@gmail.com';
      //SMTP password
      $mail->Password = 'muhutxwdqbxumuko';
      // Enable TLS encryption;
      // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
      $mail->SMTPSecure = 'ssl';
      $mail->Port = 465;
      //Recipients
      $mail->setFrom('chapmoneyapp@gmail.com', 'ChapMoney Transfert');
      //Add a recipient
      $mail->addAddress('chapmoneyonline@gmail.com');
      //Set email format to HTML
      $mail->isHTML(true);

      $mail->Subject = 'New Transaction';
      $mail->Body = "
        <p style='font-size: 1.1rem; text-align: center;'>
          Nouvelle transaction sur ChapMoney Online. Veuillez la vérifier en <a href='https://chapmoney.org/views/admin/admin'>cliquant ici</a>.
        </p>
        <p style='text-align: center;'>2023 - &copy; - Tout droit réservé</p>
      ";
      // Send email
      $mail->send();

    } catch (Exception $e) {
      echo "Une erreur est survenue; Veuillez réessayer.";
    }

    // Show success message
    $_SESSION['success'] = 'Votre transaction a été reçue et est en cours de vérifiaction.';
    header(htmlspecialchars('Location: ./verify'));
  }
}

// Back and remove all
if (isset($_POST['back'])) {
  $_SESSION['error'] = 'La transaction a bien été annulée.';
  header(htmlspecialchars('Location: ./home'));
}