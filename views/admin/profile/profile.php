<?php require('../../../backend/controllers/admin/profile/profileAction.php'); ?>

<!DOCTYPE html>
<html lang="fr">
<?php 
  include '../include/profileHead.php';
  include '../../../views/assets/css/global.php';
  include '../../../views/assets/admin/css/globalAdminCSS.php';
?>

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
            Ajouter un membre
          </button>
        </div>
        <div class="table-responsive">
          <table class="table table-hover table-bordered table-striped table-sm">
            <thead class="bg-dark text-white">
              <tr>
                <!-- <th class="bg-primary" scope="col">ID</th> -->
                <th scope="col">Nom</th>
                <th scope="col">Pays</th>
                <!-- <th scope="col">Ville</th> -->
                <th scope="col">Téléphone</th>
                <th scope="col">Date</th>
                <th scope="col">Status</th>
                <!-- <th scope="col">Salaire</th> -->
                <th scope="col">Modifier</th>
                <th class="bg-danger" scope="col">Banir</th>
              </tr>
            </thead>
            <tbody class="text-center">
              <?php
                while ($infos = $getInfos->fetch()) {
                  // Infos
                  $url = $infos['id'];
                  $name = $infos['member_name'];
                  $country = $infos['member_country'];
                  $city = $infos['member_city'];
                  $phone = $infos['member_phone'];
                  $salary = $infos['member_salary'];
                  $date = $infos['date'];
                  $status = $infos['account_status'];

                  $urlEncode = base64_encode($url);
                  ?>
                    <tr>
                      <!-- <th> <?= $url ?></th> -->
                      <th> <?= $name ?></th>
                      <td> <?= $country ?></td>
                      <!-- <td> <?= $city ?></td> -->
                      <td> <?= $phone ?></td>
                      <td> <?= $date ?></td>

                      <!-- Status -->
                      <td>
                        <?php
                          if ($status == NULL) {
                            echo '
                              <a href="./status?id='.$urlEncode.'">
                                <span style="background-color: #27ae60;" class="badge text-white fw-bold">
                                  Activer
                                </span>
                              </a>
                            ';
                          } else {
                            echo '
                              <a href="./status?id='.$urlEncode.'">
                                <span class="badge bg-warning text-dark fw-bold">
                                  Désactiver
                                </span>
                              </a>
                            ';
                          }
                        ?>
                      </td>
                      <!-- Salary -->
                      <!-- <td class="fw-bold"> 
                        <?= number_format($salary, 2, ',', ' '). ' '. '<i class="fa-solid fa-ruble-sign"></i>' ?>
                      </td> -->
                      <!-- Edit -->
                      <td>
                        <a href="./editProfile?id=<?= $urlEncode; ?>">
                          <span class="material-icons" style="color: #d63031; font-size: 1.2rem; cursor: pointer;">
                            <i class="fa-solid fa-file-pen" style="color: #27ae60;"></i>
                          </span>
                        </a>
                      </td>
                      <!-- Delete -->
                      <td>
                        <a href="./deleteProfile?id=<?= $urlEncode; ?>">
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
              <!-- Set error -->
              <?php
                if (isset($errorMsg)) {
                  echo "
                    <div class='alert w-100 mx-auto alert-warning alert-dismissible fade show' role='alert'>
                      <b style='font-size: .800rem;'>$errorMsg</b>
                      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>
                  ";
                }
              ?>
              <div class="mb-3" style="color: #7f8c8d;">
                <label class="fw-bold">
                  <i class="fa-solid fa-user"></i>  
                  Nom et Prénoms
                </label>
                <input type="text" name="member_name" class="form-control">
              </div>
              <div class="mb-3" style="color: #7f8c8d;">
                <label class="fw-bold">
                  <i class="fa-solid fa-earth-americas"></i>
                  Pays
                </label>
                <input type="text" name="member_city" class="form-control">
              </div>
              <div class="mb-3" style="color: #7f8c8d;">
                <label class="fw-bold">
                  <i class="fa-solid fa-earth-americas"></i>
                  Ville
                </label>
                <input type="text" name="member_country" class="form-control">
              </div>
              <div class="mb-3" style="color: #7f8c8d;">
                <label class="fw-bold">
                  <i class="fa-solid fa-phone"></i>
                  Numéro de téléphone
                </label>
                <input data-mask="+7 (999) 999 99-99" id="phone_number" type="text" name="member_phone" class="form-control">
              </div>
              <div class="mb-3" style="color: #7f8c8d;">
                <label class="fw-bold">
                  <i class="fa-solid fa-sack-dollar"></i>
                  Salaire
                </label>
                <input type="number" name="member_salary" class="form-control ">
              </div>
              <div class="mb-3" style="color: #7f8c8d;">
                <label class="fw-bold">
                  <i class="fa-solid fa-lock"></i>
                  Mot de passe
                </label>
                <input type="password" name="member_password" class="form-control">
              </div>
            </div>
            <div class="modal-footer">
              <button name="add_member" class="btn fw-bold btn-sm">Ajouter le membre</button>
              <button class="btn btn-prev fw-bold btn-sm" data-bs-dismiss="modal">Annuler</button>
            </div>
          </div>
        </div>
      </div>
    </form>
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