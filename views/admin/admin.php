<?php require('../../backend/controllers/admin/loginAction.php');?>

<!DOCTYPE html>
<html lang="fr">
<?php 
  include './include/adminHead.php'; 
  include '../../views/assets/css/global.php';
  include '../../views/assets/admin/css/adminCSS.php';
?>
<body>
  <div class="container">
    <div class="card my-5">
      <div class="card-body"> 
        <div class="mb-4">
          <h5 class="fw-bold">Connexion</h5>
        </div>
        <?php
          if (isset($errorMsg)) {
            echo "
              <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <b style='font-size: .800rem;'>$errorMsg</b>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
              </div>
            ";
          }
        ?>
        <form method="POST" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]);?>">
          <div class="mb-4">
            <input type="text" name="user_admin" class="form-control" placeholder="Identifiant">
          </div>
          <div class="mb-3">
            <input type="password" name="password_admin" class="form-control" placeholder="Mot de passe">
          </div>
          <div class="text-center">
            <button name="login" class="btn mt-3 fw-bold  w-100">S'identifier</button> 
          </div>
          
          <div class="text-center mt-3" style="font-size: .700rem;">
            All right reserved &copy; 2024
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
</html>