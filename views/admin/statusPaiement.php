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

    $getTypeTransaction = $db->prepare('SELECT amount_to_send FROM `manuel_transaction` WHERE id = ?');
    $getTypeTransaction->execute([$idOfTansaction]);
    // Fetch Result
    $fetch_result_transaction = $getTypeTransaction->fetch();
    // Get Amount
    $amount_to_send = $fetch_result_transaction['amount_to_send'];

    if (isset($_POST['actived'])) {
      $update_status = $db->prepare("UPDATE `manuel_transaction` SET paiement_statut = 'enabled' WHERE id = ?");
      $update_status->execute([$idOfTansaction]);

      if ($type_acc == 'Payeur') {
        // New Solde
        $af_new_account = $solde += $amount_to_send;

        // Gains
        $gains_value = 0.004;
        $get_gains = $gains += ($amount_to_send * $gains_value);

        // Save new solde in db
        $af_new_solde = $db->prepare("UPDATE `other_profile` SET account_solde = ".$af_new_account.", gains = ".$get_gains." WHERE id = ?");
        $af_new_solde->execute([$account_id]);
        
      } else if ($type_acc == 'ChapMoney') {
        // New Solde
        $af_new_account = $solde -= $amount_to_send;

        // Save new solde in db
        $af_new_solde = $db->prepare("UPDATE `other_profile` SET account_solde = ".$af_new_account." WHERE id = ?");
        $af_new_solde->execute([$account_id]);
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
              Confirmer le paiement: <b style="font-size: 1.3rem;"> <?= $idOfTansaction; ?> </b>
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