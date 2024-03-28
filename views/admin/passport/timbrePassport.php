<?php require('../../../backend/controllers/admin/passport/passportAction.php'); ?>

<!DOCTYPE html>
<html lang="en">
<?php 
  include '../include/passportHead.php';
  include '../../../views/assets/css/global.php';
?>
<style>
  .card {
    border: none;
  }
</style>
<body>
  <div class="container">
    <!-- Back Button -->
    <div class="mt-4">
      <a href="../dashboard" class="navbar-brand fw-bold">
        <i class="fa-solid fa-angle-left"></i>
        Retour
      </a>
    </div>

    <!-- Show All ask -->
    <div class="card my-4">
      <div class="card-body">
        <div class="table-responsive">
          <table id="example" class="table table-hover table-bordered table-striped table-sm">
            <div>
              <thead class="bg-dark text-white">
                <tr>
                  <th class="bg-primary">ID</th>
                  <th class="bg-dark">Username</th>
                  <th class="bg-dark">DateNaissance</th>
                  <th class="bg-dark">LieuNaissance</th>
                  <th class="bg-dark">VilleEnRussie</th>
                  <th class="bg-dark">NuméroTéléphone</th>
                  <th class="bg-dark">NomDuPère</th>
                  <th class="bg-dark">NomDeLaMère</th>
                  <!-- <th class="bg-dark">Statut</th> -->
                </tr>
              </thead>
              <tbody>
                <!--  -->
                <?php
                  while ($infos = $getInfos->fetch()) {
                    // URL
                    $url = $infos['id'];
                    ?>
                      <tr class="text-center">
                        <th>
                          <?= $infos['id']; ?>
                        </th>
                        <td>
                          <?= $infos['names']; ?>
                        </td>
                        <td>
                          <?= $infos['dateBorn']; ?>
                        </td>
                        <td>
                          <?= $infos['cityBorn']; ?>
                        </td>
                        <td>
                          <?= $infos['city']; ?>
                        </td>
                        <td>
                          <?= $infos['phone']; ?>
                        </td>
                        <td>
                          <?= $infos['fother__name']; ?>
                        </td>
                        <td>
                          <?= $infos['mother__name']; ?>
                        </td>
                        <!-- <td>
                          <?php
                            if ($infos['status'] == NULL) {
                              ?>
                                <a class="badge rounded-pill text-dark text-decoration-none fw-bold bg-warning" href="./activation">
                                  En cours
                                  <i class="fa-solid fa-circle-minus"></i>
                                </a>
                              <?php
                            } else {
                              ?>
                                <span class="badge rounded-pill fw-bold" style="background-color: #bae4ce; color: #05c46b;">
                                  Résolu
                                  <i class="fa-solid fa-circle-check"></i>
                                </span>
                              <?php
                            }
                          ?>
                        </td> -->
                        <!-- <td></td> -->
                      </tr>
                    <?php
                  }
                ?>
              </tbody>
            </div>
          </table>
        </div>
      </div>
    </div>
  </div>

  <?php include '../../../views/assets/admin/js/dashboard.php'; ?>
</body>
</html>