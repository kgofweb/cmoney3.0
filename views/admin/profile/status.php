<?php require('../../../backend/controllers/admin/profile/statusProfileAction.php'); ?>

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
      <div class="card-body text-center">
        <form method="POST" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]);?>">
          <div>
            <?php
              if ($status == NULL) {
                ?>
                  <span class="fw-bold">
                    Confirmer l'activation de ce compte
                  </span>
                <?php
              } else {
                ?>
                  <span class="fw-bold">
                    Confirmer la désactivation de ce compte
                  </span>
                <?php
              }
            ?>
          </div>

          <div class="text-center mt-4">
            <?php
              if ($status == NULL) {
                ?>
                  <button name="active" class="btn fw-bold">Activer</button>
                <?php
              } else {
                ?>
                  <button name="active" class="btn btn-prev fw-bold">Désactiver</button>
                <?php
              }
            ?>
            <button name="drop_it" class="btn btn-prev fw-bold mx-2">Annuler</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
</html>