<?php require('../../../backend/controllers/admin/profile/deleteProfileAction.php'); ?>

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