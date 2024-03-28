<?php
require('../../backend/security/security.php');
require('../../backend/auth/authAdmin.php');
require('../../backend/role/protectDeletePage.php');
require('../../backend/db/database.php');

if (isset($_GET['id']) AND !empty($_GET['id'])) {
  $idOfTansaction = base64_decode($_GET['id']);

  // Verifier si la transaction existe
  $deleteTransaction = $db->prepare('SELECT id FROM new_transaction WHERE id = ?');
  $deleteTransaction->execute(array($idOfTansaction));

  // Récupérér les données
  $transacttion = $deleteTransaction->fetch();
  // Get id
  $idNewTransaction = $transacttion['id'];

  // Effectuer une requete vers retrait
  $delete = $db->prepare('SELECT id_transaction FROM retrait WHERE id_transaction = ?');
  $delete->execute(array($idOfTansaction));

  if ($deleteTransaction->rowCount() > 0) {
    $del = $delete->fetch();

    // Suppression
    if (isset($_POST['delete'])) {
      if ($idNewTransaction || $del['id_transaction']) {

        // Supprimer la transaction 
        $deleteThisTransaction = $db->prepare('DELETE FROM new_transaction WHERE id = ?');
        $deleteThisTransaction->execute(array($idOfTansaction));

        // Supprimer la demande de retrait
        $supprimerLaDemande = $db->prepare('DELETE FROM retrait WHERE id_transaction = ?');
        $supprimerLaDemande->execute(array($idOfTansaction));

        $_SESSION['success'] = 'Transaction supprimée avec succes';
        header(htmlspecialchars('Location: ../admin/dashboard'));
      }
    }
  }
}

if (isset($_POST['drop_it'])) {
  header(htmlspecialchars('Location: ../admin/dashboard'));
}