<?php
  require('../../../backend/security/security.php');
  require('../../../backend/auth/authProfile.php');
  require('../../../backend/role/roleUnderAdmin.php');
  require('../../../backend/db/database.php');

  if (isset($_GET['id']) AND !empty($_GET['id'])) {
    $idOfTansaction = base64_decode($_GET['id']);

    $delete = $db->prepare('SELECT id, type_form, statut, current_agent_name, agent_name, amount_received, amount_to_send, payeur, paiement_statut, trans_gains FROM `manuel_transaction` WHERE id = ?');
    $delete->execute([$idOfTansaction]);

    if ($delete->rowCount() > 0) {
      $del = $delete->fetch(PDO::FETCH_ASSOC);

      // Variables
      $id = $del['id'];
      $agent_name_chapmoney = $del['current_agent_name'];
      $agent_afrique_name = $del['agent_name'];
      $payeur_agent = $del['payeur'];
      $gains_on_transaction = $del['trans_gains'];
      $amount_rec = $del['amount_received'];
      $amount_send = $del['amount_to_send'];
      $type_transaction = $del['type_form'];
      $statut_transaction = $del['statut'];
      $statut_paiement = $del['paiement_statut'];

      // Suppression
      if (isset($_POST['delete'])) {
        if ($id) {
          // ================== Reduire les gains et solde Agent ChapMoney ================== //
          $getGainsFromProfile = $db->prepare("SELECT account_solde, account_type, gains FROM `other_profile` WHERE account_name = ?");
          $getGainsFromProfile->execute([$agent_name_chapmoney]);

          if ($getGainsFromProfile->rowCount() > 0) {
            // Fetch result
            $fetch_name_agent = $getGainsFromProfile->fetch(PDO::FETCH_ASSOC);
            // Variables
            $current_gains = $fetch_name_agent['gains'];
            $current_solde = $fetch_name_agent['account_solde'];
            $acc_type = $fetch_name_agent['account_type'];

            // New gains
            $new_gains_acc = $current_gains - $gains_on_transaction;

            // New solde
            if ($type_transaction == 'send') {
              $new_solde = $current_solde - $amount_rec;
            } else {
              $new_solde = $current_solde;
            }

            $updateGains = $db->prepare("UPDATE `other_profile` SET gains = ".$new_gains_acc.", account_solde = ".$new_solde." WHERE account_name = ?");
            $updateGains->execute([$agent_name_chapmoney]);
          }

          // ================== Reduire le solde et gains Agent Afrique ================== //
          $getGainsFromAgentAfrique = $db->prepare("SELECT account_solde, gains FROM `other_profile` WHERE account_name = ?");
          $getGainsFromAgentAfrique->execute([$agent_afrique_name]);

          if ($getGainsFromAgentAfrique->rowCount() > 0) {
            // Fetch result
            $fetch_name_agent_afrique = $getGainsFromAgentAfrique->fetch(PDO::FETCH_ASSOC);
            // Variables
            $current_solde_af = $fetch_name_agent_afrique['account_solde'];
            $current_gains_af = $fetch_name_agent_afrique['gains'];

            // New solde Agent Afrique
            if ($type_transaction == 'send') {
              if ($statut_transaction == 'enabled' && $current_solde_af < 0) {
                $new_solde_af = $current_solde_af + ($amount_send * 1.01);
                // New gains
                $new_gains_af = $current_gains_af - ($amount_send * 0.005);
              } else if ($statut_transaction == 'disabled' && $current_solde_af == 0) {
                $new_solde_af = $current_solde_af;
                // New gains
                $new_gains_af = $current_gains_af;
              } else if ($statut_transaction == 'enabled' && $current_solde_af > 0) {
                $new_solde_af = $current_solde_af;
                // New gains
                $new_gains_af = $current_gains_af - ($amount_send * 0.005);
              }
            } else {
              if ($statut_transaction == 'disabled' && $current_solde_af > 0) {
                // Solde
                $new_solde_af = $current_solde_af;
                // Gains
                $new_gains_af = $current_gains_af;
              } else if ($statut_transaction == 'enabled' && $current_solde_af > 0) {
                $new_solde_af = $current_solde_af - $amount_rec;
                // Gains
                $new_gains_af = $current_gains_af - ($amount_rec * 0.005);
              } else if ($statut_transaction == 'disabled' && $current_solde_af == 0) {
                $new_solde_af = $current_solde_af;
                // New gains
                $new_gains_af = $current_gains_af;
              }
            }
            
            $updateSoldeAF = $db->prepare("UPDATE `other_profile` SET account_solde = ".$new_solde_af.", gains = ".$new_gains_af." WHERE account_name = ?");
            $updateSoldeAF->execute([$agent_afrique_name]);
          }

          // ================== Reduire le solde et gains Agent Payeur ================== //
          $getGainsFromAgentPayeur = $db->prepare("SELECT account_type, account_solde, gains FROM `other_profile` WHERE account_name = ?");
          $getGainsFromAgentPayeur->execute([$payeur_agent]);

          if ($getGainsFromAgentPayeur->rowCount() > 0) {
            // Fetch result
            $fetch_name_agent_payeur = $getGainsFromAgentPayeur->fetch(PDO::FETCH_ASSOC);
            // Variables
            $current_solde_payeur = $fetch_name_agent_payeur['account_solde'];
            $current_gains_payeur = $fetch_name_agent_payeur['gains'];

            if ($type_transaction == 'paiement') {
              if ($statut_paiement == 'disabled' && $current_solde_payeur == 0) {
                // Solde
                $new_solde_payeur = $current_solde_payeur;
                // Gains
                $new_gains_payeur = $current_gains_payeur;
              } else if ($statut_paiement == 'enabled' && $current_solde_payeur > 0) {
                // Solde
                $new_solde_payeur = $current_solde_payeur - $amount_send;
                // Gains
                $new_gains_payeur = $current_gains_payeur - ($amount_send * 0.004);
              }
            }

            $updateSoldePayeur = $db->prepare("UPDATE `other_profile` SET account_solde = ".$new_solde_payeur.", gains = ".$new_gains_payeur." WHERE account_name = ?");
            $updateSoldePayeur->execute([$payeur_agent]);
          }

          // Supprimer la transaction
          $deleteThisTransaction = $db->prepare('DELETE FROM `manuel_transaction` WHERE id = ?');
          $deleteThisTransaction->execute(array($idOfTansaction));

          $_SESSION['success'] = 'Transaction supprimée avec succes';
          header(htmlspecialchars('Location: ./manuelTransaction'));
        }
      }
    }
  }

  if (isset($_POST['drop_it'])) {
    header(htmlspecialchars('Location: ./manuelTransaction'));
  }
?>

<!DOCTYPE html>
<html lang="fr">
<?php
  include '../include/profileHead.php';
  include '../../../views/assets/css/global.php';
  include '../../../views/assets/admin/css/globalAdminCSS.php';
?>
<body>
  <div class="container">
    <div class="card my-5">
      <div class="card-body">
        <form method="POST" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]);?>">
          <div>
            Confirmez la suppression de cette transaction
            <div class="fw-bold">Attention ! toutes les informations seront perdues</div>
          </div>

          <div class="float-end mt-4">
            <button name="delete" class="btn me-2">Supprimer</button>
            <button name="drop_it" class="btn btn-prev">Annuler</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
</html>