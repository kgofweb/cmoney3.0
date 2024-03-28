<?php
require('../../../backend/security/security.php');
require('../../../backend/auth/authProfile.php');
require('../../../backend/role/roleUnderAdmin.php');
require('../../../backend/db/database.php');

if (isset($_GET['id']) AND !empty($_GET['id'])) {
  $idOfTansaction = base64_decode($_GET['id']);

  $delete = $db->prepare('SELECT id FROM profile WHERE id = ?');
  $delete->execute(array($idOfTansaction));

  if ($delete->rowCount() > 0) {
    $del = $delete->fetch();

    // Suppression
    if (isset($_POST['delete'])) {
      if ($del['id']) {
        // Supprimer le profile
        $deleteThisTransaction = $db->prepare('DELETE FROM profile WHERE id = ?');
        $deleteThisTransaction->execute(array($idOfTansaction));

        $_SESSION['success'] = 'Membre supprimé avec succes';
        header(htmlspecialchars('Location: ./profile'));
      }
    }
  }
}

if (isset($_POST['drop_it'])) {
  header(htmlspecialchars('Location: ./profile'));
}