<?php require('../backend/controllers/transaction/receiveAction.php');?>
<!DOCTYPE html>
<html lang="fr">
<?php 
  include '../views/includes/globalHead.php';
  include '../views/assets/css/global.php';
  include '../views/assets/css/receive.php';
?>
<body>
  <div class="container">
    <!-- ======== Back ======== -->
    <div class="mt-4">
      <a href="./send" class="back__btn navbar-brand" style="font-weight: bold;">
        <i class="fa-solid fa-angle-left"></i>
        Retour
      </a>
    </div>
    <?php include '../views/includes/alerts/alerts_receive.php';?>

    <div id="code_and_phone" class="card my-4">
      <div class="card-body">
        <?php include '../views/includes/formReceive/receiveForm.php';?>
      </div>
    </div>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.7/jquery.inputmask.min.js"></script>

  <?php include '../views/assets/js/receiveJS.php'; ?>
</body>
</html>