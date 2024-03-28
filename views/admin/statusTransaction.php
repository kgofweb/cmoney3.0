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

    $getAccountType = $db->prepare('SELECT account_name, account_type, account_solde, gains FROM `other_profile` WHERE id = ?');
    $getAccountType->execute([$account_id]);

    // Variables
    $fetch_result = $getAccountType->fetch();
    $name_user = $fetch_result['account_name'];
    $type_acc = $fetch_result['account_type'];
    $solde = $fetch_result['account_solde'];
    $user_gains = $fetch_result['gains'];

    $getTypeTransaction = $db->prepare('SELECT current_agent_name, type_form, amount_received, amount_to_send FROM `manuel_transaction` WHERE id = ?');
    $getTypeTransaction->execute([$idOfTansaction]);

    // Variables
    $fetch_result_transaction = $getTypeTransaction->fetch();
    $sender_name = $fetch_result_transaction['current_agent_name'];
    $type_trans = $fetch_result_transaction['type_form'];
    $amount_to_send = $fetch_result_transaction['amount_to_send'];
    $amount_received = $fetch_result_transaction['amount_received'];

    if (isset($_POST['actived'])) {
      $update_status = $db->prepare("UPDATE `manuel_transaction` SET statut = 'enabled' WHERE id = ?");
      $update_status->execute([$idOfTansaction]);

      if ($type_trans == "send") {
        // New Solde
        $af_new_account = $solde -= ($amount_to_send * 1.01);

        // Gains
        $gains_value = 0.005;
        $get_gains = $user_gains += ($amount_to_send * $gains_value);

        // Save new solde in db
        $af_new_solde = $db->prepare("UPDATE `other_profile` SET account_solde = ".$af_new_account.", gains = ".$get_gains." WHERE id = ?");
        $af_new_solde->execute([$account_id]);

      } else {
        // New Solde
        $af_new_account = $solde += $amount_received;

        // Gains
        $gains_value = 0.005;
        $get_gains = $user_gains += ($amount_received * $gains_value);

        // Save new solde in db
        $af_new_solde = $db->prepare("UPDATE `other_profile` SET account_solde = ".$af_new_account.", gains = ".$get_gains." WHERE id = ?");
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
              Confirmer l'activation de la transaction: <b style="font-size: 1.3rem;"> <?= $idOfTansaction; ?> </b>
            </span>
          </div>

          <div class="float-end mt-4">
            <button name="drop_it" class="fw-bold me-2 btn btn-prev">
              Annuler
            </button>
            <button name="actived" class="fw-bold btn ">
              Activer
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
</html>