<?php
require('../../../backend/security/security.php');
require('../../../backend/auth/authProfile.php');
require('../../../backend/role/roleUnderAdmin.php');
require('../../../backend/db/database.php');

if (isset($_POST['add_account'])) {
  // secrure data function
  function secure_data_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  // Variables
  $acc_name = secure_data_input($_POST['account_name']);
  $acc_country = secure_data_input($_POST['account_contry']);
  $acc_type = secure_data_input($_POST['account_type']);
  $acc_solde = secure_data_input($_POST['account_solde']);
  $acc_password = $_POST['account_password'];

  // Verified inputs
  if (!empty($acc_name) && !empty($acc_country) && !empty($acc_type) && !empty($acc_password) || !empty($acc_solde)) {
    // Crypt Password
    $password_crypt = password_hash($acc_password, PASSWORD_BCRYPT);

    // Check if member name already exist
    $checkIfMemberNameAlreadyExists = $db->prepare('SELECT account_name FROM `other_profile` WHERE account_name = ?');
    $checkIfMemberNameAlreadyExists->execute([$acc_name]);

    if ($checkIfMemberNameAlreadyExists->rowCount() == 0) {
      // Save to data base
      $insertNewAccount = $db->prepare('INSERT INTO `other_profile`(account_name, account_contry, account_type, account_solde, account_password) VALUES (?, ?, ?, ?, ?)');
      $insertNewAccount->execute([
        $acc_name,
        $acc_country,
        $acc_type,
        $acc_solde,
        $password_crypt
      ]);

      // Success message
      $_SESSION['success'] = 'Compte crée avec success.';
    } else {
      $_SESSION['emptyFiled'] = 'Ce nom est déjà utilisé.';
    }
  } else {
    $_SESSION['emptyFiled'] = 'Renseignez tous les champs.';
  }
}

// Sow informations on the table
$getInfos = $db->prepare("SELECT * FROM `other_profile`");
$getInfos->execute();