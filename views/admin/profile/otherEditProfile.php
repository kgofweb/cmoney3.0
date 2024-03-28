<?php
  require('../../../backend/security/security.php');
  require('../../../backend/auth/authProfile.php');
  require('../../../backend/role/roleUnderAdmin.php');
  require('../../../backend/db/database.php');

  if (isset($_GET['id']) AND !empty($_GET['id'])) {
    // Si l'id esxiste
    $idOfProfile = base64_decode($_GET['id']);

    // Verifie si le sous membre existe dans la base de donée
    $checkIfQuestionExist = $db->prepare('SELECT id, account_name, account_type, account_solde, gains FROM `other_profile` WHERE id = ?');
    $checkIfQuestionExist->execute([$idOfProfile]);

    if ($checkIfQuestionExist->rowCount() > 0) {
      // recupérer les données du profil
      $profileInfos = $checkIfQuestionExist->fetch();

      // Si on a l'ID
      if ($profileInfos['id']) {
        $name = $profileInfos['account_name'];
        $typeAccount = $profileInfos['account_type'];
        $solde = $profileInfos['account_solde'];
        $gains = $profileInfos['gains'];
      }
    }
  }

  // Logic to Edit file
  if (isset($_POST['edit_acc'])) {
    // Verifier si les champs ne sont pas vide
    if (!empty($_POST['account_name']) || !empty($_POST['account_solde'])) {
  
      // Recuperer les nouvelles données
      function secure_data_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }
  
      $new_account_name = secure_data_input($_POST['account_name']);
      $new_account_type = secure_data_input($_POST['account_type']);
      $new_account_solde = secure_data_input($_POST['account_solde']);
      $new_account_gains = secure_data_input($_POST['gains']);
  
      $editUserProfile = $db->prepare('UPDATE `other_profile` SET account_name = ?, account_solde = ?, account_type = ?, gains = ? WHERE id = ?');
      $editUserProfile->execute([
        $new_account_name,
        $new_account_solde,
        $new_account_type,
        $new_account_gains,
        $idOfProfile
      ]);
  
      $_SESSION['success'] = 'Profil modifié avec success';
      header(htmlspecialchars('Location: ./otherProfile'));
      
    } else {
      $_SESSION['emptyFiled'] = 'Veuillez renseigner tous les champs';
    }
  }

  // Cancel
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
    <!-- Error alerts -->
    <?php include '../../../views/includes/alerts/alert_emptyFields.php'; ?>
    <div class="card my-5">
      <div class="card-body">
        <form method="POST" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]);?>">
          <h6 class="mb-3">Modifier certains champs du compte</h6>
          <div class="mb-3" style="color: #7f8c8d;">
            <label class="fw-bold" style="font-size: .850rem;">
              <i class="fa-solid fa-user"></i>  
              Nom et Prénoms
            </label>
            <input type="text" name="account_name" class="form-control" value="<?= $name ?>">
          </div>
          <div class="mb-3" style="color: #7f8c8d;">
            <label class="fw-bold">
              <i class="fa-solid fa-file-invoice"></i>
              Type de compte
            </label>
            <select class="form-select" name="account_type">
              <option><?= $typeAccount ?></option>
              <option value="Afrique">Afrique</option>
              <option value="ChapMoney">ChapMoney</option>
              <option value="Payeur">Payeur</option>
            </select>
          </div>
          <div class="mb-3" style="color: #7f8c8d;">
            <label class="fw-bold" style="font-size: .850rem;">
              <i class="fa-solid fa-user"></i>  
              Solde
            </label>
            <input type="number" name="account_solde" class="form-control" value="<?= $solde ?>">
          </div>
          <div class="mb-3" style="color: #7f8c8d;">
            <label class="fw-bold" style="font-size: .850rem;">
              <i class="fa-solid fa-user"></i>  
              Gains
            </label>
            <input type="number" name="gains" class="form-control" value="<?= $gains ?>">
          </div>

          <div class="float-end mt-4">
            <button name="edit_acc" class="btn fw-bold me-2">Modifier</button>
            <button name="drop_it" class="btn btn-prev fw-bold">Annuler</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    window.onload = (event) => {
      let myToast = document.querySelector('.toast')
      let alertToast = new bootstrap.Toast(myToast)
      alertToast.show()
    }
  </script>
</body>
</html>