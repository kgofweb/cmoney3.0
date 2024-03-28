<!DOCTYPE html>
<html lang="fr">
<?php include './views/includes/indexHead.php'; ?>
<?php include './views/assets/css/global.php'; ?>
<?php include './views/assets/css/index.php'; ?>

<body>
  <!-- =========== Loader =========== -->
  <?php include './views/loader.php'; ?>

  <!-- =========== Main =========== -->
  <div class="container">
    <div class="title">
      <div>
        <img class="index__img" src="./views/assets/img/index.png" alt="ChapMoney Online">
        <h5 class="text-center mb-3 principal-color">ChapMoney - Transfert</h5>
        <div class="footer text-center" style="color: #7f8c8d;">
          Rapprochez vous de l'essentiel avec ChapMoney
          <P>2024 &copy</P>
        </div>
        <?php include './views/welcome.php'; ?>
      </div>
    </div>
  </div>

  <!-- =========== JS =========== -->
  <?php include './views/assets/js/loader.php'; ?>
</body>
</html>