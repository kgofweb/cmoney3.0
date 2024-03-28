<?php
require('../../../backend/security/security.php');
require('../../../backend/auth/authProfile.php');
require('../../../backend/role/roleUnderAdmin.php');
require('../../../backend/db/database.php');

if (isset($_GET['id']) AND !empty($_GET['id'])) {
  $idOfTansaction = base64_decode($_GET['id']);

  $checkIfUserExist = $db->prepare('SELECT account_status FROM profile WHERE id = ?');
  $checkIfUserExist->execute(array($idOfTansaction));
  $statusData = $checkIfUserExist->fetch();

  $status = $statusData['account_status'];

  if (isset($_POST['active'])) {
    // Activer le compte
    if ($status == NULL) {
      $activeUnderAccount = $db->prepare("UPDATE profile SET account_status = NOW() WHERE id = '" . $idOfTansaction . "' AND id = '" . $idOfTansaction . "'");
      $activeUnderAccount->execute([]);

      $_SESSION['success'] = 'Compte activé avec success';
      header(htmlspecialchars('Location: ./profile'));
    } else {
      // Désactiver le compte
      $activeUnderAccount = $db->prepare("UPDATE profile SET account_status = NULL WHERE id = '" . $idOfTansaction . "' AND id = '" . $idOfTansaction . "'");
      $activeUnderAccount->execute([]);

      $_SESSION['success'] = 'Compte désactivé avec success';
      header(htmlspecialchars('Location: ./profile'));
    }
  }
}

// Cancel
if (isset($_POST['drop_it'])) {
  header(htmlspecialchars('Location: ./profile'));
}