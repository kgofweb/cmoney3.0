<?php
require('../../../backend/security/security.php');
require('../../../backend/auth/authProfile.php');
require('../../../backend/role/roleUnderAdmin.php');
require('../../../backend/db/database.php');

if (isset($_POST['add_member'])) {
  if (!empty($_POST['member_name']) && !empty($_POST['member_country']) && !empty($_POST['member_city']) && !empty($_POST['member_phone']) && !empty($_POST['member_salary']) && !empty($_POST['member_password'])) {
    // Regex
    $regex = "/^[a-zA-Z\s]+$/";
    $regexSalary = "/^[0-9]+$/";
    $regexPassword = "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/";

    // secrure data function
    function secure_data_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }

    // Get variables
    $member_name = secure_data_input($_POST['member_name']);
    $member_country = secure_data_input($_POST['member_country']);
    $member_city = secure_data_input($_POST['member_city']);
    $member_phone = secure_data_input($_POST['member_phone']);
    $member_salary = secure_data_input($_POST['member_salary']);
    $member_password = password_hash($_POST['member_password'], PASSWORD_BCRYPT);

    $date = date("d/m/Y");

    if (preg_match($regex, $member_name)) {
      if (preg_match($regex, $member_country)) {
        if (preg_match($regex, $member_city)) {
          if (preg_match($regexSalary, $member_salary)) {
            if (preg_match($regexPassword, $member_password)) {
              // Check if member name already exist
              $checkIfMemberNameAlreadyExists = $db->prepare('SELECT member_name FROM profile WHERE member_name = ?');
              $checkIfMemberNameAlreadyExists->execute([$member_name]);

              // Check if member phone already exist
              $checkIfMemberPhoneAlreadyExists = $db->prepare('SELECT member_phone FROM profile WHERE member_phone = ?');
              $checkIfMemberPhoneAlreadyExists->execute([$member_phone]);

              if ($checkIfMemberNameAlreadyExists->rowCount() == 0) {
                if ($checkIfMemberPhoneAlreadyExists->rowCount() == 0) {
                  // Save to data base
                  $insertNewMember = $db->prepare('INSERT INTO profile(member_name, member_country, member_city, member_phone, member_salary, member_password, role_admin, date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
                  $insertNewMember->execute([
                    $member_name,
                    $member_country,
                    $member_city,
                    $member_phone,
                    $member_salary,
                    $member_password,
                    0,
                    $date
                  ]);

                  // Success message
                  $_SESSION['success'] = 'Membre ajouté avec success.';
                } else {
                  $_SESSION['emptyFiled'] = 'Ce numéro est déjà utilisé.';
                }
              } else {
                $_SESSION['emptyFiled'] = 'Ce nom est déjà utilisé.';
              }
            } else {
              $_SESSION['emptyFiled'] = 'Le mot doit contenir au moins des lettres majiscules, miniscules, symboles, chiffres..';
            }
          } else {
            $_SESSION['emptyFiled'] = 'Le salaire doit seulement contenir des chiffres.';
          }
        } else {
          $_SESSION['emptyFiled'] = 'La ville doit contenir seulement des lettres Majiscules ou Miniscules.';
        }
      } else {
        $_SESSION['emptyFiled'] = 'Le pays doit contenir seulement des lettres Majiscules ou Miniscules.';
      }
    } else {
      $_SESSION['emptyFiled'] = 'Le nom doit contenir seulement des lettres Majiscules ou Miniscules.';
    }
  } else {
    $_SESSION['emptyFiled'] = 'Vueillez renseigner tous les champs.';
  }
}


// Sow informations on the table
$getInfos = $db->prepare("SELECT id, member_name, member_city, member_country, member_phone, member_salary, date, account_status FROM profile ORDER BY id DESC");
$getInfos->execute();