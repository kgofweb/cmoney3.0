<?php
require('../../backend/security/security.php');
require('../../backend/db/database.php');

// Logic
if (isset($_POST['login'])) {
  // Verify if inputs are not empty
  if(!empty($_POST['user_admin']) && !empty($_POST['password_admin'])) {
    // secrure data function
    function secure_data_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }

    $username_value = secure_data_input($_POST['user_admin']);
    $userPassword_value = secure_data_input($_POST['password_admin']);

    $checkAdmin = $db->prepare('SELECT role, password_admin FROM admin WHERE user_admin = ?');
    $checkAdmin->execute([$username_value]);

    // Get data
    $adminResult = $checkAdmin->fetch();

    // ======== Connexion system ======== //
    if ($checkAdmin->rowCount() > 0) {
      if (password_verify($userPassword_value, $adminResult['password_admin'])) {
        // Init sessions
        $_SESSION['auth'] = true;
        $_SESSION['user_admin'] = $username_value;
        $_SESSION['password_admin'] = $userPassword_value;
        $_SESSION['role'] = $adminResult['role'];

        // Redirect user
        $_SESSION['success'] = 'Bienvenue';
        header(htmlspecialchars('Location: ./dashboard'));
      } else {
        $errorMsg = "L'identifiant ou le mot de passe est incorrect !";
      }
    } else {
      // Check if member exist
      $checkMember = $db->prepare('SELECT account_status, member_password, role_admin FROM `profile` WHERE member_name = ?');
      $checkMember->execute([$username_value]);
      
      // Si le user exist
      if ($checkMember->rowCount() > 0) {
        // Get data
        $userInfos = $checkMember->fetch();

        // Si le mot de passe correspond
        if (password_verify($userPassword_value, $userInfos['member_password'])) {
          // Si le compte est activé ou non
          if ($userInfos['account_status'] != NULL) {
            // identification des variables
            $role_admin = $userInfos['role_admin'];

            // Mise en sessions
            // $_SESSION['auth'] = true;
            $_SESSION['user_admin'] = $username_value;
            $_SESSION['password_admin'] = $userPassword_value;
            $_SESSION['role_admin'] = $role_admin;

            // Redirect user
            $_SESSION['success'] = 'Bienvenue';
            header(htmlspecialchars('Location: ./dashboard'));

          } else {
            $errorMsg = "Votre compte n'est pas activé";
          }
        } else {
          $errorMsg = "Le mot de passe ne correspond pas.";
        }
      } else {
        $errorMsg = "Vous n'êtes pas membre.";
      }


      // Check if Account exist
      $checkAccountAgent = $db->prepare('SELECT id, account_name, account_type, account_contry, account_password FROM `other_profile` WHERE account_name = ?');
      $checkAccountAgent->execute([$username_value]);

      // Si le compte existe
      if ($checkAccountAgent->rowCount() > 0) {
        // Get data
        $accountInfos = $checkAccountAgent->fetch();

        // Check if password match
        if (password_verify($userPassword_value, $accountInfos['account_password'])) {
          // Mise en Sessions
          $_SESSION['id'] = $accountInfos['id'];
          $_SESSION['user_admin'] = $username_value;
          $_SESSION['password_admin'] = $userPassword_value;
          $_SESSION['account_type'] = $accountInfos['account_type'];
          $_SESSION['account_contry'] = $accountInfos['account_contry'];

          // Redirect user
          $_SESSION['success'] = 'Bienvenue';
          header(htmlspecialchars('Location: ./dashboard'));
        }

      } else {
        $errorMsg = "Vous n'êtes pas membre.";
      }
    }
  } else {
    $errorMsg = 'Veuillez vous identifier !';
  }
}