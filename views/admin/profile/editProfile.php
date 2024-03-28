<?php 
  require('../../../backend/controllers/admin/profile/getInfosProfileAction.php');
  require('../../../backend/controllers/admin/profile/editProfileAction.php');
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
    <!-- Error alerts -->
    <?php include '../../../views/includes/alerts/alert_emptyFields.php'; ?>
    <div class="card my-5">
      <div class="card-body">
        <form method="POST" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]);?>">
          <h5 class="mb-3">Modifier le profil</h5>
          <div class="mb-3" style="color: #7f8c8d;">
            <label class="fw-bold" style="font-size: .850rem;">
              <i class="fa-solid fa-user"></i>  
              Nom et Prénoms
            </label>
            <input type="text" name="member_name" class="form-control" value="<?= $name ?>">
          </div>
          <div class="mb-3" style="color: #7f8c8d;">
            <label class="fw-bold" style="font-size: .850rem;">
              <i class="fa-solid fa-earth-americas"></i>
              Pays
            </label>
            <input type="text" name="member_country" class="form-control" value="<?= $country ?>">
          </div>
          <div class="mb-3" style="color: #7f8c8d;">
            <label class="fw-bold" style="font-size: .850rem;">
              <i class="fa-solid fa-earth-americas"></i>
              Ville
            </label>
            <input type="text" name="member_city" class="form-control" value="<?= $city ?>">
          </div>
          <div class="mb-3" style="color: #7f8c8d;">
            <label class="fw-bold" style="font-size: .850rem;">
              <i class="fa-solid fa-phone"></i>
              Numéro de téléphone
            </label>
            <input data-mask="+7 (999) 999 99-99" id="phone_number" type="text" name="member_phone" class="form-control" value="<?= $phone ?>">
          </div>
          <div class="mb-3" style="color: #7f8c8d;">
            <label class="fw-bold" style="font-size: .850rem;">
              <i class="fa-solid fa-sack-dollar"></i>
              Salaire
            </label>
            <input type="number" name="member_salary" class="form-control" value="<?= $salary ?>">
          </div>
          <div class="float-end mt-4">
            <button name="edit" class="btn fw-bold me-2">Modifier</button>
            <button name="drop_it" class="btn btn-prev fw-bold">Annuler</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <?php include '../../../views/assets/js/phoneFormat.php'; ?>

  <script>
    window.onload = (event) => {
      let myToast = document.querySelector('.toast')
      let alertToast = new bootstrap.Toast(myToast)
      alertToast.show()
    }

    function format() {
      $("#phone_number").inputmask($('#phone_number').data('mask'));
    }
    format();
  </script>
</body>
</html>