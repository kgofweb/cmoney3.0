<?php
require('../../../backend/security/security.php');
require('../../../backend/auth/authProfile.php');
require('../../../backend/role/roleUnderAdmin.php');
require('../../../backend/db/database.php');

if (isset($_GET['id']) AND !empty($_GET['id'])) {
  // Si l'id esxiste
  $idOfProfile = base64_decode($_GET['id']);

  // Verifie si le sous membre existe dans la base de donée
  $checkIfQuestionExist = $db->prepare('SELECT id, member_name, member_country, member_city, member_phone, member_salary FROM profile WHERE id = ?');
  $checkIfQuestionExist->execute([$idOfProfile]);

  if ($checkIfQuestionExist->rowCount() > 0) {
    // recupérer les données du profil
    $profileInfos = $checkIfQuestionExist->fetch();

    // Si on a l'ID
    if ($profileInfos['id']) {
      $name = $profileInfos['member_name'];
      $country = $profileInfos['member_country'];
      $city = $profileInfos['member_city'];
      $phone = $profileInfos['member_phone'];
      $salary = $profileInfos['member_salary'];
    }
  }
}

// Cancel
if (isset($_POST['drop_it'])) {
  header(htmlspecialchars('Location: ./profile'));
}