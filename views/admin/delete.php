<?php require('../../backend/controllers/admin/deleteAction.php'); ?>

<!DOCTYPE html>
<html lang="fr">
<?php 
  include './include/adminHead.php'; 
  include '../../views/assets/css/global.php';
  include '../../views/assets/admin/css/globalAdminCSS.php';
  include '../../views/assets/admin/css/detailsCSS.php';
?>
<body>
  <div class="container">
    <div class="card my-5">
      <div class="card-body">
        <form method="POST" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]);?>">
          <div>
            Supprimer la transaction: <b><?= $idNewTransaction; ?></b>
            <div class=" fw-bold">Attention ! toutes les informations seront perdues</div>
          </div>
          <div class="float-end mt-5">
            <button name="drop_it" class="btn btn-prev me-2">
              Annuler
            </button>
            <button id="sub" class="btn" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
              Supprimer
            </button>
          </div>
        </form>
      </div>
    </div>

    <form method="POST" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]);?>">
      <div class="modal fade" id="staticBackdrop"  data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content text-center">
            <div class="mt-4">
              <i class="fa-solid fa-circle-check validate__icon"></i>
            </div>
            <h4 class="fw-bold modal-title my-3">
              Confirmer la suppression
            </h4>
            <div class="my-3">
              <button name="delete" class="btn w-50 fw-bold">Confirmer</button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>

  <script>
    document.getElementById('sub').addEventListener('click', (event) => {
      event.preventDefault();
    })
  </script>
</body>
</html>