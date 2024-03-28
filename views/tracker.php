<!DOCTYPE html>
<html lang="fr">
<?php
  include '../views/includes/globalHead.php';
  include '../views/assets/css/global.php';
  include '../views/assets/css/tracker.php';
?>
<body>
  <div class="container">
    <?php include '../views/includes/back/backUp.php';?>

    <div class="cards mt-3">
      <div class="row row-cols-2 justify-content-center">
        <div class="col">
          <div class="card mb-3">
            <div class="card-body">
              <h5>Code</h5>
              <a href="./trackerCode" class="btn float-end">
                <i class="fa-solid fa-angle-right p-1"></i>
              </a>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card mb-3">
            <div class="card-body">
              <h5>Paiement</h5>
              <a href="./trackerPaiement" class="btn float-end">
                <i class="fa-solid fa-angle-right p-1"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>