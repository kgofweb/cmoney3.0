<?php
// If we are not different variables
if (!isset($_SESSION['countryOne']) || !isset($_SESSION['numberPhoneOne'])) {
  header(htmlspecialchars('Location: ./home'));
}

if (isset($_SESSION['countryOne'])) {
  if ((time() - $_SESSION['last_time']) > 750) {
    $_SESSION['error'] = 'Votre session a été annulée. Veuillez reprendre la procédure.';
    header(htmlspecialchars('Location: ./home'));
  } else {
    // Get value of input
    $senderCountry = $_SESSION['countryOne'];
    $senderMode = $_SESSION['sendMode'];
    $senderPhone = $_SESSION['numberPhoneOne'];
    $receiverCountry = $_SESSION['countryTwo'];
    $receiverMode = $_SESSION['receiveMode'];
    $receiverName = $_SESSION['receiver_name'];
    $receiverPhone = $_SESSION['numberPhoneTwo'];
    $amount = $_SESSION['amount'];

    // Generate random code
    if ($receiverCountry == 'russie') {
      $verification_code = substr(number_format(time() * rand(), 1, '', ''), 1, 5);
    } else {
      $verification_code = substr(number_format(time() * rand(), 1, '', ''), 1, 8);
    }

    if (isset($_POST['send'])) {
      // Save code in session
      $_SESSION['verify_code'] = $verification_code;
      $_SESSION['last_time'] = time();

      header(htmlspecialchars('Location: ./finish'));
    }
  }
}

if (isset($_POST['cancel'])) {
  $_SESSION['error'] = 'La transaction a bien été annulée.';
  header(htmlspecialchars('Location: ./home'));
}