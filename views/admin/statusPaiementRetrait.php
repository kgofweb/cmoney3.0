<?php 
  require('../../backend/security/security.php');
  require('../../backend/auth/authProfile.php');
  require('../../backend/db/database.php');

  $account_id = $_SESSION['id'];

  if (!isset($_SESSION['account_type'])) {
    header('Location: ./admin');
  }

  if (isset($_GET['id']) AND !empty($_GET['id'])) {
    // Decode URL
    $idOfTansaction = base64_decode($_GET['id']);

    $getAccountType = $db->prepare('SELECT account_type, account_solde, gains FROM `other_profile` WHERE id = ?');
    $getAccountType->execute([$account_id]);

    // Variables
    $fetch_result = $getAccountType->fetch();
    $type_acc = $fetch_result['account_type'];
    $solde = $fetch_result['account_solde'];
    $gains = $fetch_result['gains'];

    // ============= Retrait ================ //
    $getAmountRetrait = $db->prepare('SELECT montant_rouble FROM `retrait` WHERE code = ?');
    $getAmountRetrait->execute([$idOfTansaction]);
    // Fetch Result
    $fetch_result_amount = $getAmountRetrait->fetch(PDO::FETCH_ASSOC);

    $amount_retrait = $fetch_result_amount['montant_rouble'];

    if (isset($_POST['actived'])) {
      if ($type_acc == 'Payeur') {
        // New Solde
        $af_new_account = $solde += $amount_retrait;

        // Gains
        $gains_value = 0.004;
        $get_gains = $gains += ($amount_retrait * $gains_value);

        // Save new solde in db
        $af_new_solde = $db->prepare("UPDATE `other_profile` SET account_solde = ".$af_new_account.", gains = ".$get_gains." WHERE id = ?");
        $af_new_solde->execute([$account_id]);
        
      } else if ($type_acc == 'ChapMoney') {
        // New Solde
        $af_new_account_retrait = $solde -= $amount_retrait;
        // Save new solde in db
        $af_new_solde_retrait = $db->prepare("UPDATE `other_profile` SET account_solde = ".$af_new_account_retrait." WHERE id = ?");
        $af_new_solde_retrait->execute([$account_id]);
      }
      // Change statut
      $update_status_retrait = $db->prepare("UPDATE `retrait` SET statut_paiement = 'enabled' WHERE code = ?");
      $update_status_retrait->execute([$idOfTansaction]);

      // Set new transaction code verification
      $checkIfCodeExist = $db->prepare('SELECT id, verification_code FROM `new_transaction` WHERE verification_code = ?');
      $checkIfCodeExist->execute([$idOfTansaction]);

      if ($checkIfCodeExist->rowCount() > 0) {
        // Récupérer les infos de la transaction
        $transactionInfos = $checkIfCodeExist->fetch();
        // Variables
        $otpCode = $transactionInfos['verification_code'];

        $payement = $db->prepare("UPDATE `new_transaction` SET status_payement = NOW() WHERE verification_code = '" . $otpCode . "' AND verification_code = '" . $otpCode . "'");
        $payement->execute([]);
      }


      $_SESSION['success'] = 'Transaction Activée';
      header('Location: ./dashboard');
    }
  }

  if (isset($_POST['drop_it'])) {
    header('Location: ./dashboard');
  }
?>

<!DOCTYPE html>
<html lang="fr">
<?php 
  include './include/adminHead.php'; 
  include '../../views/assets/css/global.php';
  include '../../views/assets/admin/css/globalAdminCSS.php';
?>
<body>
  <div class="container">
  <div class="card mt-5">
      <div class="card-body">
        <form method="POST">
          <div class="btn-prev message">
            <span>
              Confirmer le paiement N° <b style="font-size: 1.3rem;"> <?= $idOfTansaction; ?> </b> <br>
              Montant: <b style="font-size: 1.3rem;"> <?= $amount_retrait; ?> </b>
            </span>
          </div>

          <div class="float-end mt-4">
            <button name="drop_it" class="fw-bold me-2 btn btn-prev">
              Annuler
            </button>
            <button name="actived" class="fw-bold btn ">
              Payer
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
</html>