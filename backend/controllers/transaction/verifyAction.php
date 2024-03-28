<?php
require('../backend/security/security.php');

if (!isset($_SESSION['verify_code'])) {
  header(htmlspecialchars('Location: ./home'));
}

// Sender Country
$senderCountry = $_SESSION['countryOne'];
// Receiver Country
$receiverCountry = $_SESSION['countryTwo'];
// Receiver Country
$receiverName = $_SESSION['receiver_name'];
// Sender mode
$senderMode = $_SESSION['sendMode'];
// Receiver mode
$receiverMode = $_SESSION['receiveMode'];
// Phone sender
$senderPhone = $_SESSION['numberPhoneOne'];
// Receiver Phone
$receiverPhone = $_SESSION['numberPhoneTwo'];
// Amount to transfer
$amount = $_SESSION['amount'];
// Code verification
$verify_code = $_SESSION['verify_code'];

// Set date and Time
$date = $_SESSION['date'];
$time = $_SESSION['time'];

// Money device
require('../backend/devise/moneyDevise.php');

if (isset($_POST['backToHome'])) {
  $_SESSION['validate'] = 'Terminé avec succes !';
  header('Location: ./home');
}