<?php require ('../backend/controllers/transaction/transfertAction.php'); ?>

<!DOCTYPE html>
<html lang="fr">
<?php include '../views/includes/sendHead.php'; ?>
<?php include '../views/assets/css/global.php'; ?>
<body>
  <div class="container">
    <!-- ======== Back ======== -->
    <div class="mt-4">
      <a href="./send" class="back__btn navbar-brand" style="font-weight: bold;">
        <i class="fa-solid fa-angle-left"></i>
        Retour
      </a>
    </div>
    <!-- ======== Alert Empty Fields ======== -->
    <?php include '../views/includes/alerts/alert_emptyFields.php';?>
    <!-- ======== Form ======== -->
    <?php include '../views/includes/formSend/form.php'; ?>
    <!-- ========== Contact Button ========== -->
    <!-- <?php include '../views/includes/contact/contact.php'; ?> -->
  </div>
</body>
</html>