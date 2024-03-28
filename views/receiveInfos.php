<?php
  require('../backend/controllers/transaction/receiveAction.php');
  require('../backend/controllers/transaction/receiveInfosAction.php');
?>
<!DOCTYPE html>
<html lang="fr">
<?php 
  include '../views/includes/globalHead.php';
  include '../views/assets/css/global.php';
  include '../views/assets/css/receiveInfos.php'; 
?>
<body>
  <div class="container">
    <?php include '../views/includes/alerts/alerts_receive.php';?>
    <?php include '../views/includes/alerts/alert_success.php';?>
    
    <div class="card my-5">
      <div class="card-body">
        <?php include '../views/includes/formReceive/receiveInfosForm.php';?>
      </div>
    </div>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.7/jquery.inputmask.min.js"></script>

  <?php include '../views/assets/js/receiveInfosJS.php'; ?>
</body>
</html>