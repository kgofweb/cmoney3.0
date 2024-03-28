<?php
require('../backend/security/security.php');

if (isset($_POST) && !empty($_POST)) {
  // Token validation
  if (isset($_POST['token'])) {
    if ($_POST['token'] == $_SESSION['token']) {
      // Token time validation
      $max_time = 650;

      if (isset($_SESSION['token_time'])) {
        
        $token_time = $_SESSION['token_time'];
    
        if (($token_time + $max_time) >= time()) {

          if (isset($_POST['transfert'])) {

            if(!empty($_POST['countryOne']) && !empty($_POST['sendMode']) && !empty($_POST['numberPhoneOne']) && !empty($_POST['receiver_name']) && !empty($_POST['countryTwo']) && !empty($_POST['receiveMode']) && !empty($_POST['numberPhoneTwo']) && !empty($_POST['amount'])) {

              // secrure data function
              function secure_data_input($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
              }

              // Get input value
              $countryOne = secure_data_input($_POST['countryOne']);
              $sendMode = secure_data_input($_POST['sendMode']);
              $phoneSender = secure_data_input($_POST['numberPhoneOne']);
              $countryTwo = secure_data_input($_POST['countryTwo']);
              $receiveMode = secure_data_input($_POST['receiveMode']);
              $receiverName = secure_data_input($_POST['receiver_name']);
              $phoneReceiver = secure_data_input($_POST['numberPhoneTwo']);
              $amount = secure_data_input($_POST['amount']);
              
              // Regex
            //   $regex = "/^[a-zA-Z\s\éè]+$/";
              
              // Validate name
            //   if (preg_match($regex, $receiverName)) {
            //   } else {
            //     $_SESSION['emptyFiled'] = 'Le nom doit seulement contenir des lettres Majiscules ou Miniscules ou avec des accent';
            //   }
            
                // Save in session
                $_SESSION['auth'] = true;
                $_SESSION['countryOne'] = $countryOne;
                $_SESSION['sendMode'] = $sendMode;
                $_SESSION['numberPhoneOne'] = $phoneSender;
                $_SESSION['countryTwo'] = $countryTwo;
                $_SESSION['receiveMode'] = $receiveMode;
                $_SESSION['receiver_name'] = $receiverName;
                $_SESSION['numberPhoneTwo'] = $phoneReceiver;
                $_SESSION['amount'] = $amount;
                $_SESSION['last_time'] = time();
          
                // Redirect to check page
                header(htmlspecialchars('Location: ./check'));
            } else {
              $_SESSION['emptyFiled'] = 'Veuillez renseigner tous les champs.';
            }
          }
    
        } else {
          unset($_SESSION['token']);
          unset($_SESSION['token_time']);
    
          $_SESSION['error'] = 'Votre session a été annulée. Vueillez reprendre la procéedure.';
          header(htmlspecialchars('Location: ./home'));
        }
      }
    }
  }
}

$token = md5(uniqid(rand(), true));
$_SESSION['token'] = $token;
$_SESSION['token_time'] = time();