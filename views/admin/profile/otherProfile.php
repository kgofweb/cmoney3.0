<?php require('../../../backend/controllers/admin/profile/otherProfileAction.php'); ?>

<!DOCTYPE html>
<html lang="fr">
<?php 
  include '../include/profileHead.php';
  include '../../../views/assets/css/global.php';
  include '../../../views/assets/admin/css/globalAdminCSS.php';
?>

<style>
  .card__profile {
    width: 100% !important;
    height: 73vh;
    overflow-y: scroll;
  }
  @media screen and (max-width: 800px) {
    #no-more-tables tbody,
    #no-more-tables tr,
    #no-more-tables td {
      display: block;
    }
    #no-more-tables thead tr {
      position: absolute;
      top: -9999px;
      left: -9999px;
    }
    #no-more-tables td {
      position: relative;
      padding-left: 50%;
      border: none;
    }
    #no-more-tables td:before {
      content: attr(data-title);
      position: absolute;
      left: 6px;
      font-weight: bold;
    }
    #no-more-tables tr {
      border-bottom: 1px solid #7f8c8d;
    }
  }
</style>

<body>
  <div class="container">
    <div class="mt-4">
      <a href="../dashboard" class="navbar-brand fw-bold">
        <i class="fa-solid fa-angle-left"></i>
        Retour
      </a>
    </div>
    <!-- Success alerts -->
    <?php include '../../../views/includes/alerts/alert_success.php'; ?>
    <!-- Error alerts -->
    <?php include '../../../views/includes/alerts/alert_emptyFields.php'; ?>

    <div class="card card__profile my-4">
      <div class="card-body">
        <div class="mb-3">
          <button class="btn btn-sm fw-bold" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            <i class="fa-solid fa-plus"></i>
            Nouvel Agent
          </button>
        </div>
        <div class="table-responsive" id="no-more-tables">
          <table class="table table-hover table-bordered table-striped table-sm">
            <thead class="bg-dark text-white text-center">
              <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Pays</th>
                <th>Compte</th>
                <th>Solde</th>
                <th>Gains</th>
                <th>Modifier</th>
                <th class="bg-danger">Supprimer</th>
              </tr>
            </thead>
            <tbody class="text-center">
              <?php
                while ($infos = $getInfos->fetch()) {
                  // Infos
                  $url = $infos['id'];
                  $name = $infos['account_name'];
                  $country = $infos['account_contry'];
                  $accountType = $infos['account_type'];
                  $accountSolde = $infos['account_solde'];
                  $gains = $infos['gains'];
                  $password = $infos['account_password'];

                  // URL Encoded
                  $urlEncode = base64_encode($url);

                  // Devices Money
                  switch ($country) {
                    case 'Russie':
                      $change = '<i class="fa-solid fa-ruble-sign"></i>';
                      break;
                    case 'RDC':
                      $change = '<i class="fa-solid fa-dollar-sign"></i>';
                      break;
                    default:
                      $change = '<span class="fw-bold">FCFA</span>';
                      break;
                  }
                  ?>
                    <tr>
                      <td data-title='ID'><?= $url ?></td>
                      <td data-title='Nom'><?= $name ?></td>
                      <td data-title='Pays'><?= $country ?></td>
                      <td data-title='Compte'> 
                        <?php 
                          if ($accountType == 'Afrique') { 
                            echo '<span class="badge rounded-pill text-decoration-none fw-bold" style="background-color: #ffaf40; color: #3d3d3d;">
                              Compte Afrique
                            </span>';
                          } else if ($accountType === 'ChapMoney') {
                            echo '<span class="badge rounded-pill text-decoration-none fw-bold" style="background-color: #dae8f3; color: #0984e3;">
                            Compte ChapMoney
                          </span>';
                          }
                          else {
                            echo '<span class="badge rounded-pill text-decoration-none fw-bold" style="background-color: #d2eddf; color: #20bf6b;">
                            Compte Payeur
                          </span>';
                          }
                        ?>
                      </td>
                      <!-- Wallet -->
                      <td data-title='Solde'> <?= number_format($accountSolde, 0, ',', ' '). ' '. $change; ?> </td>
                      <!-- Gains -->
                      <td data-title='Gains'> <?= number_format($gains, 0, ',', ' '); ?> </td>
                      <!-- Edit -->
                      <td data-title='Modifier'>
                        <a href="./otherEditProfile?id=<?= $urlEncode; ?>">
                          <span class="material-icons" style="color: #20bf6b; font-size: 1.2rem; cursor: pointer;">
                            <i class="fa-solid fa-file-pen"></i>
                          </span>
                        </a>
                      </td>
                      <!-- Delete -->
                      <td data-title='Banir'>
                        <a href="./deleteOtherProfile?id=<?= $urlEncode; ?>">
                          <i class="fa-solid fa-trash" style="color: #ff7979; font-size: 1rem; cursor: pointer;"></i>
                        </a>
                      </td>
                    </tr>
                  <?php
                }
              ?>
            </tbody>
          </table>
          <div class="text-center fw-bold" style="font-size: .8rem;">ChapMoney 2023 &copy; Web App</div>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <form method="POST">
      <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-body">
              <div class="mb-3" style="color: #7f8c8d; font-size: .850rem;">
                <label class="fw-bold">
                  <i class="fa-solid fa-user"></i>  
                  Nom Prénoms
                </label>
                <input type="text" name="account_name" class="form-control">
              </div>
              <div class="mb-3" style="color: #7f8c8d; font-size: .850rem;">
                <label class="fw-bold">
                  <i class="fa-solid fa-earth-americas"></i>
                  Pays
                </label>
                <select class="form-select" name="account_contry">
                  <option selected value=""></option>
                  <option value="Russie">Russie</option>
                  <option value="Benin">Bénin</option>
                  <option value="Burkina">Burkina</option>
                  <option value="Cameroun">Cameroun</option>
                  <option value="CIV">Côte d'Ivoire</option>
                  <option value="Congo Brazaville">Congo Brazaville</option>
                  <option value="Gabon">Gabon</option>
                  <option value="Guinée">Guinée</option>
                  <option value="RDC">RD Congo</option> 
                  <option value="Mali">Mali</option>
                  <option value="Niger">Niger</option>
                  <option value="Sénégal">Sénégal</option>
                  <option value="Tchad">Tchad</option>
                  <option value="Togo">Togo</option>
                </select>
              </div>
              <div class="mb-3" style="color: #7f8c8d; font-size: .850rem;">
                <label class="fw-bold">
                  <i class="fa-solid fa-file-invoice"></i>
                  Type de compte
                </label>
                <select class="form-select" name="account_type">
                  <option selected></option>
                  <option value="ChapMoney">ChapMoney</option>
                  <option value="Afrique">Afrique</option>
                  <option value="Payeur">Payeur</option>
                </select>
              </div>
              <div class="mb-3" style="color: #7f8c8d; font-size: .850rem;">
                <label class="fw-bold">
                  <i class="fa-solid fa-wallet"></i>
                  Solde de départ
                </label>
                <input type="number" name="account_solde" class="form-control">
              </div>
              <div class="mb-3" style="color: #7f8c8d; font-size: .850rem;">
                <label class="fw-bold">
                  <i class="fa-solid fa-lock"></i>
                  Mot de passe
                </label>
                <input type="password" name="account_password" class="form-control">
              </div>
            </div>
            <div class="modal-footer">
              <button name="add_account" class="btn fw-bold btn-sm">Creer le compte</button>
              <button class="btn btn-prev fw-bold btn-sm" data-bs-dismiss="modal">Annuler</button>
            </div>
          </div>
        </div>
      </div>
    </form>
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