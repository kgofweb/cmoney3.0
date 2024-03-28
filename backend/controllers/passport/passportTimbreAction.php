<?php
require('../backend/db/database.php');

if (isset($_POST) && !empty($_POST)) {
  // Token validation
  if (isset($_POST['token'])) {
    if ($_POST['token'] == $_SESSION['token']) {
      // Token time validation
      $max_time = 500;

      if (isset($_SESSION['token_time'])) {
        $token_time = $_SESSION['token_time'];

        if (($token_time + $max_time) >= time()) {

          // Start Logic to add new passport ask
          if (isset($_POST['send'])) {
            // Fields are not empty
            if (!empty($_POST['names']) && !empty($_POST['dateBorn']) && !empty($_POST['cityBorn']) && !empty($_POST['city']) && !empty($_POST['phone']) && !empty($_POST['fother__name']) && !empty($_POST['mother__name'])) {
              // secrure data function
              function secure_data_input($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
              }
          
              // Get input value
              $nameUser = secure_data_input($_POST['names']);
              $dateBorn = secure_data_input($_POST['dateBorn']);
              $cityBorn = secure_data_input($_POST['cityBorn']);
              $city = secure_data_input($_POST['city']);
              $phone = secure_data_input($_POST['phone']);
              $fotherName = secure_data_input($_POST['fother__name']);
              $motherName = secure_data_input($_POST['mother__name']);
          
              // Regex
              $regex = "/^[a-zA-Z\s\é]+$/";
          
              if (preg_match($regex, $nameUser)) {
                if (preg_match($regex, $cityBorn)) {
                  if (preg_match($regex, $city)) {
                    if (preg_match($regex, $fotherName)) {
                      if (preg_match($regex, $motherName)) {
          
                        // Insert all data in data base
                        $insertData = $db->prepare('INSERT INTO timbrepassport(names, dateBorn, cityBorn, city, phone, fother__name, mother__name, status) VALUES(?, ?, ?, ?, ?, ?, ?, ?)');
                        $insertData->execute([
                          $nameUser,
                          $dateBorn,
                          $cityBorn,
                          $city,
                          $phone,
                          $fotherName,
                          $motherName,
                          NULL
                        ]);
          
                        // Redirection Success
                        $_SESSION['validate'] = 'Votre demande a bien été prise en compte. Vous serez bientôt contacté par le service client.';
                        header(htmlspecialchars('Location: ./home'));
          
                      } else {
                        $_SESSION['emptyFiled'] = 'Le format du nom de la mère est invalide !';
                      }
                    } else {
                      $_SESSION['emptyFiled'] = 'Le format du nom du père est invalide !';
                    }
                  } else {
                    $_SESSION['emptyFiled'] = 'Le format de la ville est invalide !';
                  }
                } else {
                  $_SESSION['emptyFiled'] = 'Le format de la ville de naissance est invalide !';
                }
              } else {
                $_SESSION['emptyFiled'] = 'Le format du nom est invalide !';
              }      
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