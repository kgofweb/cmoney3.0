<ul class="nav nav-pills fw-bold mb-3" id="pills-tab" role="tablist">
  <li class="nav-item" role="presentation">
    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">T. Manuelles</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">P. Site</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">P. Manuelles</button>
  </li>
</ul>
<div class="tab-content" id="pills-tabContent">
  <!-- Transactions effectuées par le compte -->
  <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
    <div class="table-responsive" id="no-more-tables">
      <table class="table table-hover table-bordered table-striped table-sm">
        <thead class="bg-dark text-white text-center fw-bold">
          <tr>
            <td>ID</td>
            <td>Type</td>
            <td>Pays Agent</td>
            <td>Nom Agent</td>
            <td>Somme Reçue</td>
            <td>Somme à T</td>
            <td>Réseaux</td>
            <td>Bénéficiaire</td>
            <td>Reception</td>
            <td>Paiement</td>
          </tr>
        </thead>
        <tbody class="text-center">
          <?php
            if ($getTransctionsByAccountCM->rowCount() > 0) {
              while ($fetchInfo = $getTransctionsByAccountCM->fetch()) {
                $transaction_id = $fetchInfo['id'];
                $transaction_agant_name = $fetchInfo['agent_name'];
                $transaction_agant_country = $fetchInfo['agent_contry'];
                $transaction_amount_received = $fetchInfo['amount_received'];
                $transaction_amount_to_send = $fetchInfo['amount_to_send'];
                $transaction_network = $fetchInfo['network'];
                $transaction_receiver_name = $fetchInfo['receiver_name'];
                $current_init_agent = $fetchInfo['current_agent_name'];
                $receiver_phone = $fetchInfo['receiver_phone'];
                $network_russie = $fetchInfo['network_russie'];
                $type = $fetchInfo['type_form'];
                $statut = $fetchInfo['statut'];
                $wave_amount_val = $fetchInfo['wave_amount'];

                // Payeur
                $payeur_agent = $fetchInfo['payeur'];
                $statut_paiement = $fetchInfo['paiement_statut'];

                // Type Account
                $type_of_acc = $fetchInfo['type_of_acc'];

                // URL Encoded
                $urlEncode = base64_encode($transaction_id);

                if ($login_name == $current_init_agent) {
                  ?>
                    <tr>
                      <td data-title='Identifiant'> <?= $transaction_id; ?> </td>
                      <td data-title='Type Transaction'>
                        <?php
                          if ($type == 'send') {
                            echo '<span style="background-color: var(--primary-color);" class="badge text-white fw-bold">
                              <i class="fa-solid fa-paper-plane"></i>
                              Envoi
                            </span>';
                          } else {
                            echo '<span style="background-color: #27ae60;" class="badge text-white fw-bold">
                              <i class="fa-solid fa-circle-arrow-left"></i>
                              Paiement
                            </span>
                            ';
                          }
                        ?>
                      </td>
                      <td data-title='Pays Agent'> <?= $transaction_agant_country; ?> </td>
                      <td data-title='Agent'>
                        <?php
                          if ($login_name == $transaction_agant_name) {
                            echo $current_init_agent;
                          } else {
                            echo $transaction_agant_name;
                          }
                        ?>
                      </td>
                      <td data-title='Somme reçue'><?= number_format($transaction_amount_received, 0, ',', ' '); ?></td>
                      <td data-title='Somme à transférer'><?= number_format($transaction_amount_to_send, 0, ',', ' '); ?></td>
                      <td data-title='Réseaux'> <?= $transaction_network; ?> </td>
                      <td data-title='Bénéfiçiaire'> <?= $transaction_receiver_name; ?> </td>
                      <td data-title='Réception'>
                        <?php
                          if ($type == 'send') {
                            echo '<span style="background-color: var(--primary-color);" class="badge text-white fw-bold">
                              <i class="fa-solid fa-toggle-on"></i>
                              Confirmé
                            </span>';
                          } else if ($type == 'paiement' && $statut == 'enabled') {
                            echo '<span style="background-color: #27ae60;" class="badge text-white fw-bold">
                              <i class="fa-solid fa-toggle-on"></i>
                              Validé
                            </span>';
                          } else {
                            echo '<span style="background-color: #fed330;" class="badge text-dark fw-bold">
                              <i class="fa-solid fa-toggle-off"></i>
                              En attente
                            </span>';
                          }
                        ?>
                      </td>
                      <td data-title='Paiement'>
                        <?php
                          if ($type == 'send' && $statut == 'enabled') {
                            echo '<span style="background-color: #27ae60;" class="badge text-white fw-bold">
                              <i class="fa-solid fa-toggle-on"></i>
                              Confirmé
                            </span>';
                          } else if ($type == 'paiement' && $statut_paiement == 'disabled') {
                            echo '<span style="background-color: #fed330;" class="badge text-dark fw-bold">
                              <i class="fa-solid fa-clock"></i>
                              En cours...
                            </span>';
                          } else if ($type == 'paiement' && $statut_paiement == 'enabled') {
                            echo '<span style="background-color: #27ae60;" class="badge text-white fw-bold">
                              <i class="fa-solid fa-check-circle"></i>
                              Effectué
                            </span>';
                          }
                          else {
                            echo '<span style="background-color: #fed330;" class="badge text-dark fw-bold">
                              <i class="fa-solid fa-clock"></i>
                              En attente
                            </span>';
                          }
                        ?>
                      </td>
                    </tr>
                  <?php
                }
              }
            }
          ?>
        </tbody>
      </table>
    </div>
  </div>
  <!-- Transactions Retrait via Site -->
  <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
    <div class="table-responsive" id="no-more-tables">
      <table class="table table-hover table-bordered table-striped table-sm">
        <thead class="bg-dark text-white text-center fw-bold">
          <tr>
            <td>ID</td>
            <td>Type</td>
            <td>Pays Agent</td>
            <td>Nom Agent</td>
            <td>Somme Reçue</td>
            <td>Somme à T</td>
            <td>Réseaux</td>
            <td>Bénéficiaire</td>
            <td>Reception</td>
            <td>Paiement</td>
          </tr>
        </thead>
        <tbody class="text-center">
          <?php
            if ($set_payer_siteTransaction->rowCount() > 0) {
              while ($fetchPayer = $set_payer_siteTransaction->fetch(PDO::FETCH_ASSOC)) {
                // Vars
                $id_transac_paiement = $fetchPayer['id'];
                $amount_to_send = $fetchPayer['montant_rouble'];
                $bank = $fetchPayer['bank_withdrawal'];
                $other_bank = $fetchPayer['bankUser_withdrawal'];
                $name_user = $fetchPayer['name_withdrawal'];
                $phone_user = $fetchPayer['number_phone_withdrawal'];
                $payer_agent_site = $fetchPayer['payer'];
                $code_transaction = $fetchPayer['code'];
                $statut_paiement_site = $fetchPayer['statut_paiement'];

                // Set URL
                $urlPaiementEncode = base64_encode($id_transac_paiement);
                $urlCode = base64_encode($code_transaction);

                if ($login_name == $payer_agent_site) {
                  ?>
                    <tr>
                      <td data-title='Identifiant'> <?= $code_transaction; ?> </td>
                      <td data-title='Type'>
                        <span style="background-color: #27ae60;" class="badge text-white fw-bold">
                          <i class="fa-solid fa-circle-arrow-left"></i>
                          Retrait - Site
                        </span>
                      </td>
                      <td data-title='Pays Agent'> <?= '---'; ?> </td>
                      <td data-title='Nom Agent'> <?= '---'; ?> </td>
                      <td data-title='Somme Reçue'> <?= '---'; ?> </td>
                      <td data-title='A transférer'> <?= $amount_to_send; ?> </td>
                      <td data-title='Reseaux'> <?= $bank; ?> </td>
                      <td data-title='Reseaux'> <?= $name_user; ?> </td>
                      <td data-title='Reception'> <?= $phone_user; ?> </td>
                      <td data-title='Statut Paiement'>
                        <?php
                          if ($statut_paiement_site == 'disabled') {
                            ?>
                              <a href="./statusPaiementRetrait?id=<?= $urlCode; ?>">
                                <i class="fa-solid fa-toggle-off" style="color: #a5b1c2; font-size: 1.3rem; cursor: pointer;"></i>
                              </a>
                            <?php
                          } else {
                            echo '<i class="fa-solid fa-toggle-on" style="color: #20bf6b; font-size: 1.3rem;"></i>';
                          }
                        ?>
                      </td>
                    </tr>
                  <?php
                }
              }
            }
          ?>
        </tbody>
      </table>
    </div>
  </div>
  <!-- Transactions initiées par l'agent pour la confirmation du paiement -->
  <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab" tabindex="0">
    <div class="table-responsive" id="no-more-tables">
      <table class="table table-hover table-bordered table-striped table-sm">
        <thead class="bg-dark text-white text-center fw-bold">
          <tr>
            <td>ID</td>
            <td>Type</td>
            <td>Pays Agent</td>
            <td>Nom Agent</td>
            <td>Somme Reçue</td>
            <td>Somme à T</td>
            <td>Réseaux</td>
            <td>Bénéficiaire</td>
            <td>Reception</td>
            <td>Paiement</td>
          </tr>
        </thead>
        <tbody class="text-center">
          <?php
            if ($getTransctionsPaiementManuel->rowCount() > 0) {
              while ($fetchPayerManuel = $getTransctionsPaiementManuel->fetch(PDO::FETCH_ASSOC)) {
                // Vars
                $transaction_id = $fetchPayerManuel['id'];
                $transaction_agant_name = $fetchPayerManuel['agent_name'];
                $transaction_agant_country = $fetchPayerManuel['agent_contry'];
                $transaction_amount_received = $fetchPayerManuel['amount_received'];
                $transaction_amount_to_send = $fetchPayerManuel['amount_to_send'];
                $transaction_network = $fetchPayerManuel['network'];
                $transaction_receiver_name = $fetchPayerManuel['receiver_name'];
                $current_init_agent = $fetchPayerManuel['current_agent_name'];
                $receiver_phone = $fetchPayerManuel['receiver_phone'];
                $network_russie = $fetchPayerManuel['network_russie'];
                $type = $fetchPayerManuel['type_form'];
                $statut = $fetchPayerManuel['statut'];
                $wave_amount_val = $fetchPayerManuel['wave_amount'];
                // Payeur
                $payeur_agent = $fetchPayerManuel['payeur'];
                $statut_paiement = $fetchPayerManuel['paiement_statut'];
                // Type Account
                $type_of_acc = $fetchPayerManuel['type_of_acc'];
                // URL Encoded
                $urlEncode = base64_encode($transaction_id);

                if ($login_name == $payeur_agent) {
                  ?>
                    <tr>
                      <td data-title='Identifiant'> <?= $transaction_id; ?> </td>
                      <td data-title='Type'>
                        <span style="background-color: #27ae60;" class="badge text-white fw-bold">
                          <i class="fa-solid fa-circle-arrow-left"></i>
                          P. Manuel
                        </span>
                      </td>
                      <td data-title='Pays Agent'> <?= '---'; ?> </td>
                      <td data-title='Nom Agent'> <?= '---'; ?> </td>
                      <td data-title='Somme Reçue'> <?= '---'; ?> </td>
                      <td data-title='A transférer'> <?= $transaction_amount_to_send; ?> </td>
                      <td data-title='Reseaux'> <?= $network_russie; ?> </td>
                      <td data-title='Bénéfiçiaire'> <?= $transaction_receiver_name; ?> </td>
                      <td data-title='Reception'> <?= $receiver_phone; ?> </td>
                      <td data-title='Statut Paiement'>
                        <?php
                          if ($statut_paiement == 'disabled') {
                            ?>
                              <a href="./statusPaiement?id=<?= $urlEncode; ?>">
                                <i class="fa-solid fa-toggle-off" style="color: #a5b1c2; font-size: 1.3rem; cursor: pointer;"></i>
                              </a>
                            <?php
                          } else {
                            echo '<i class="fa-solid fa-toggle-on" style="color: #20bf6b; font-size: 1.3rem;"></i>';
                          }
                        ?>
                    </tr>
                  <?php
                }
              }
            }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>