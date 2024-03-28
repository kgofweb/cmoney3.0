<?php
  require('../../../backend/security/security.php');
  require('../../../backend/auth/authProfile.php');
  require('../../../backend/role/roleUnderAdmin.php');
  require('../../../backend/db/database.php');

  if (isset($_GET['id']) AND !empty($_GET['id'])) {
    $idOfTansaction = base64_decode($_GET['id']);

    $delete = $db->prepare('SELECT id FROM `other_profile` WHERE id = ?');
    $delete->execute(array($idOfTansaction));

    if ($delete->rowCount() > 0) {
      $del = $delete->fetch();

      // Suppression
      if (isset($_POST['delete'])) {
        if ($del['id']) {
          // Supprimer le profile
          $deleteThisTransaction = $db->prepare('DELETE FROM `other_profile` WHERE id = ?');
          $deleteThisTransaction->execute(array($idOfTansaction));

          $_SESSION['success'] = 'Compte supprimé avec succes';
          header(htmlspecialchars('Location: ./otherProfile'));
        }
      }
    }
  }

  if (isset($_POST['drop_it'])) {
    header(htmlspecialchars('Location: ./otherProfile'));
  }

?>

<!DOCTYPE html>
<html lang="fr">
<?php
  include '../include/profileHead.php';
  include '../../../views/assets/css/global.php';
  include '../../../views/assets/admin/css/globalAdminCSS.php';
?>
<body>
  <div class="container">
    <div class="card my-5">
      <div class="card-body">
        <form method="POST" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]);?>">
          <div>
            Confirmez la suppression de ce compte
            <div class="fw-bold">Attention ! toutes les informations seront perdues</div>
          </div>

          <div class="float-end mt-4">
            <button name="delete" class="btn me-2">Supprimer</button>
            <button name="drop_it" class="btn btn-prev">Annuler</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
</html>