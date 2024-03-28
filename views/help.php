<?php require('../backend/controllers/transaction/assistanceAction.php'); ?>

<!DOCTYPE html>
<html lang="fr">
<?php
  include '../views/includes/globalHead.php';
  include '../views/assets/css/global.php';
  include '../views/assets/css/help.php';
?>

<body>
  <div class="container">
    <!-- ======== Back ======== -->
    <?php include '../views/includes/back/backUp.php';?>

    <div class="d-flex align-items-start mt-3">
      <div class="icon">
        <i class="fa-solid fa-headphones-simple me-2"></i>
      </div>
      <div class="title">
        <h6>
          Bonjour,<br>
          <b>Veuillez choisir un agent disponible pour <br> une transaction rapide ou une préoccupation</b>
          <div></div>
        </h6>
      </div>
    </div>

    <!-- Assistant Disponible -->
    <?php
      while ($assis_user = $getInfosProfile->fetch()) {
        $user = $assis_user['member_name'];
        $status = $assis_user['account_status'];
        $link = $assis_user['what_link'];
        ?>

          <div class="card assistance">
            <div class="card-body">
              <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                  <div class="img__box">
                    <img src="../views/assets/img/assiss.webp" alt="ChapMoney Online">
                    <?php
                      if ($status == NULL) {
                        echo '<div class="status_user" style="background-color: #7f8c8d;"></div>';
                      } else {
                        echo '<div class="status_user" style="background-color: #2ed573;"></div>';
                      }
                    ?>
                  </div>
                  <div class="assis__content mx-2">
                    <div class="assis">
                      <h6>
                        <div class="name fw-bold"><?= $user; ?></div>
                        <div class="status">
                          <?php
                            if ($status == NULL) {
                              echo '<div style="color: #7f8c8d;">Indisponible</div>';
                            } else {
                              echo '<div style="color: #2ecc71;">En ligne</div>';
                            }
                          ?>
                        </div>
                        <div class="assis__rate">
                          <i class="fa-solid fa-star"></i>
                          <span>5.0</span>
                        </div>
                      </h6>
                    </div>
                  </div>
                </div>
                <!-- Button Action -->
                <div class="button">
                  <?php
                    if ($status == NULL) {
                      echo '<button class="btn btn-sm btn_offline d-flex align-items-center disabled"">
                        <span class="me-2">Joindre</span>
                        <i class="fa-solid fa-paper-plane"></i>
                      </button>';
                    } else {
                      ?>
                        <a href="<?= $link; ?>" target="_blank" class="btn btn-sm d-flex align-items-center">
                          <span class="me-2">Joindre</span>
                          <i class="fa-solid fa-paper-plane"></i>
                        </a>
                      <?php
                    }
                  ?>
                </div>
              </div>
            </div>
          </div>
        <?php
      }
    ?>

  </div>

  <script src="../views/assets/js/scrollreveal.min.js"></script>

  <script>
    const sr = ScrollReveal({
      distance: '60px',
      duration: 1300
    });
    sr.reveal(`.icon`, { origin: 'top', delay: 300 })
    sr.reveal(`.title`, { origin: 'top', delay: 400 })
    sr.reveal(`.assistance`, { origin: 'top', delay: 500 })
  </script>

</body>
</html>