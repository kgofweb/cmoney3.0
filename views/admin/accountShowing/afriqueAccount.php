<ul class="nav nav-pills fw-bold mb-3" id="pills-tab" role="tablist">
  <li class="nav-item" role="presentation">
    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">T. Manuelles</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">T. Site</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">T. Agents</button>
  </li>
</ul>

<div class="tab-content" id="pills-tabContent">
  <!-- Slmts le stransactions effectuées par l'agent en question -->
  <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
    <div class="table-responsive" id="no-more-tables">
      <table class="table table-hover table-bordered table-striped table-sm">
        <thead class="bg-dark text-white text-center fw-bold">
          <tr>
            <td>ID</td>
            <td>Type T.</td>
            <td>Agent</td>
            <td>Somme</td>
            <td>Réseaux</td>
            <td>Bénéficiaire</td>
            <td>Statut</td>
            <td>Téléphone</td>
          </tr>
        </thead>
        <tbody class="text-center">
          <?php
            if ($getTransctionsByAccount->rowCount() > 0) {
              while ($sendMySelf = $getTransctionsByAccount->fetch()) {
                // Vars
                $transaction_id = $sendMySelf['id'];
                $transaction_agant_name = $sendMySelf['agent_name'];
                $transaction_agant_country = $sendMySelf['agent_contry'];
                $transaction_amount_received = $sendMySelf['amount_received'];
                $transaction_amount_to_send = $sendMySelf['amount_to_send'];
                $transaction_network = $sendMySelf['network'];
                $transaction_receiver_name = $sendMySelf['receiver_name'];
                $current_init_agent = $sendMySelf['current_agent_name'];
                $receiver_phone = $sendMySelf['receiver_phone'];
                $network_russie = $sendMySelf['network_russie'];
                $type = $sendMySelf['type_form'];
                $statut = $sendMySelf['statut'];
                $wave_amount_val = $sendMySelf['wave_amount'];
                // Payeur
                $payeur_agent = $sendMySelf['payeur'];
                $statut_paiement = $sendMySelf['paiement_statut'];
                // Type Account
                $type_of_acc = $sendMySelf['type_of_acc'];
                // URL Encoded
                $urlEncode = base64_encode($transaction_id);

                // Afficher slmt les transactions initiées par le compte
                if ($login_name == $current_init_agent) {
                  ?>
                    <tr>
                      <td data-title='Identifiant'> <?= $transaction_id; ?> </td>
                      <td data-title='Type Transaction'>
                        <?php
                          if ($type == 'send' && $type_of_acc == 'Afrique') {
                            echo '<span style="background-color: #fa8231;" class="badge text-white fw-bold">
                              <i class="fa-solid fa-paper-plane"></i>
                              Envoi Afrique
                            </span>';
                          }
                        ?>
                      </td>
                      <td data-title='Agent'> 
                        <?php
                          if ($login_name == $transaction_agant_name) {
                            echo $current_init_agent;
                          } else {
                            echo $transaction_agant_name;
                          }
                        ?>
                      </td>
                      <td data-title='A Transférer'> 
                        <?php
                          if ($type == 'paiement') {
                            if ($transaction_network == 'Wave Money') {
                              echo number_format($wave_amount_val, 0, ',', ' ');
                            } else {
                              echo number_format($transaction_amount_received, 0, ',', ' ');
                            }
                          } else if ($type == 'send' && ($login_name == $current_init_agent)) {
                            echo number_format($transaction_amount_received, 0, ',', ' ');
                          } else {
                            echo number_format($transaction_amount_to_send, 0, ',', ' ');
                          }
                        ?>
                      </td>
                      <td data-title='Réseaux'> <?= $transaction_network; ?> </td>
                      <td data-title='Nom bénéf.'> <?= $transaction_receiver_name; ?> </td>
                      <td data-title='Statut'>
                        <?php
                          if ($statut == 'disabled') {
                            if ($login_name == $current_init_agent) {
                              echo '
                                <span style="background-color: #fed330;" class="badge text-dark fw-bold">
                                  En attente
                                  <i class="fa-solid fa-circle-arrow-right"></i>
                                </span>
                              ';
                            } else {
                              ?>
                                <a href="./statusTransaction?id=<?= $urlEncode; ?>">
                                  <i class="fa-solid fa-toggle-off" style="color: #a5b1c2; font-size: 1.3rem; cursor: pointer;"></i>
                                </a>
                              <?php
                            }
                          } else {
                            echo '<i class="fa-solid fa-toggle-on" style="color: #20bf6b; font-size: 1.3rem;"></i>';
                          }
                        ?>
                      </td>
                      <td data-title="Téléphone">
                        <?php
                          if ($type == 'send') {
                            echo $receiver_phone;
                          } else {
                            echo '---';
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
  <!-- Transactions recues via web site -->
  <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
    <div class="table-responsive" id="no-more-tables">
      <table class="table table-hover table-bordered table-striped table-sm">
        <thead class="bg-dark text-white text-center fw-bold">
          <tr>
            <td>ID</td>
            <td>Type T.</td>
            <td>Agent</td>
            <td>Somme</td>
            <td>Réseaux</td>
            <td>Bénéficiaire</td>
            <td>Statut</td>
            <td>Téléphone</td>
          </tr>
        </thead>
        <tbody class="text-center">
          <?php
            if ($transaction_siteAF->rowCount() > 0) {
              while ($info_site = $transaction_siteAF->fetch()) {
                // Vars
                $transaction_site_id = $info_site['id'];
                $client_name = openssl_decrypt($info_site['receiver_name'], $chiper, $key, $options, $iv);
                $client_country = openssl_decrypt($info_site['countryTwo'], $chiper, $key, $options, $iv);
                $client_mode_mobile = openssl_decrypt($info_site['receiveMode'], $chiper, $key, $options, $iv);
                $client_mode_mobile_sender = openssl_decrypt($info_site['sendMode'], $chiper, $key, $options, $iv);
                $client_phone = $info_site['numberPhoneTwo'];
                $client_amount = $info_site['amount_rouble'];
                $client_amount_sending = $info_site['amount'];
                $af_agent_name = $info_site['af_name'];
                $admin = $info_site['admin_name'];
                $type_site_transaction = $info_site['type_transac_site'];
                $amount_wave = $info_site['amount_wave'];

                $code_verified =  $info_site['number_verified'];

                $url_Encode = base64_encode($transaction_site_id);

                // Afficher les transactions envoyées par l'ADMIN du site
                if ($login_name == $af_agent_name) {
                  // =================== Afrique vers Russie (Paiement) =================== //
                  if ($type_site_transaction == 'afrique_to_russian') {
                    ?>
                      <tr>
                        <td data-title='Identifiant'> <?= $transaction_site_id; ?> </td>
                        <td data-title='Type Transaction'>
                          <?php
                            if ($client_mode_mobile == '-- chapmoney online --') {
                              ?>
                                <span style="background-color: #2ecc71;" class="badge text-white fw-bold">
                                  <i class="fa-solid fa-paper-plane"></i>
                                  Site - Paiement
                                </span>
                              <?php
                            } else {
                              ?>
                                <span style="background-color: #2f3542;" class="badge text-white fw-bold">
                                  <i class="fa-solid fa-paper-plane"></i>
                                  Site - Envoi
                                </span>
                              <?php
                            }
                          ?>
                        </td>
                        <td data-title='Agent'>
                          <?= $admin; ?>
                        </td>
                        <td data-title="Somme">
                          <?php
                            if ($client_mode_mobile_sender == 'Wave Money') {
                              echo number_format($amount_wave,  0, ',', ' '); 
                            } else {
                              echo number_format($client_amount_sending,  0, ',', ' '); 
                            }
                          ?>
                        </td>
                        <td data-title="Mobile Money">
                          <?= $client_mode_mobile_sender; ?>
                        </td>
                        <td data-title="Bénéficiaire">
                          <?= $client_name; ?>
                        </td>
                        <td data-title="Statut">
                          <?php
                            if ($code_verified == NULL) {
                              ?>
                                <a href="./activation?id=<?= $url_Encode; ?>">
                                  <i class="fa-solid fa-toggle-off" style="color: #a5b1c2; font-size: 1.3rem; cursor: pointer;"></i>
                                </a>
                              <?php
                            } else {
                              ?>
                                <span style="background-color: #2ed573;" class="badge text-white fw-bold">
                                  <i class="fa-solid fa-check-circle"></i>
                                  Activé
                                </span>
                              <?php
                            }
                          ?>
                        </td>
                        <td data-title="Téléphone">
                          <?= $client_phone; ?>
                        </td>
                      </tr>
                    <?php
                  } 
                  // =================== Russie vers Afrique (Envoi) =================== //
                  else if ($type_site_transaction == 'russian_to_afrique') {
                    ?>
                      <tr>
                        <td data-title='Identifiant'> <?= $transaction_site_id; ?> </td>
                        <td data-title='Type Transaction'>
                          <?php
                            if ($client_mode_mobile == '-- chapmoney online --') {
                              ?>
                                <span style="background-color: #2ecc71;" class="badge text-white fw-bold">
                                  <i class="fa-solid fa-paper-plane"></i>
                                  Site - Paiement
                                </span>
                              <?php
                            } else {
                              ?>
                                <span style="background-color: #2f3542;" class="badge text-white fw-bold">
                                  <i class="fa-solid fa-paper-plane"></i>
                                  Site - Envoi
                                </span>
                              <?php
                            }
                          ?>
                        </td>
                        <td data-title='Agent'>
                          <?= $admin; ?>
                        </td>
                        <td data-title="Somme">
                          <?= number_format($client_amount,  0, ',', ' '); ?>
                        </td>
                        <td data-title="Mobile Money">
                          <?= $client_mode_mobile; ?>
                        </td>
                        <td data-title="Bénéficiaire">
                          <?= $client_name; ?>
                        </td>
                        <td data-title="Statut">
                          <?php
                            if ($code_verified == NULL) {
                              ?>
                                <a href="./activation?id=<?= $url_Encode; ?>">
                                  <i class="fa-solid fa-toggle-off" style="color: #a5b1c2; font-size: 1.3rem; cursor: pointer;"></i>
                                </a>
                              <?php
                            } else {
                              ?>
                                <span style="background-color: #2ed573;" class="badge text-white fw-bold">
                                  <i class="fa-solid fa-check-circle"></i>
                                  Activé
                                </span>
                              <?php
                            }
                          ?>
                        </td>
                        <td data-title="Téléphone">
                          <?= $client_phone; ?>
                        </td>
                      </tr>
                    <?php
                  }
                }
              }
            }
          ?>
        </tbody>
      </table>
    </div>
  </div>
  <!-- Transactions recues par les autres Agents -->
  <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab" tabindex="0">
    <div class="table-responsive" id="no-more-tables">
      <table class="table table-hover table-bordered table-striped table-sm">
        <thead class="bg-dark text-white text-center fw-bold">
          <tr>
            <td>ID</td>
            <td>Type T.</td>
            <td>Agent</td>
            <td>Somme</td>
            <td>Réseaux</td>
            <td>Bénéficiaire</td>
            <td>Statut</td>
            <td>Téléphone</td>
          </tr>
        </thead>
        <tbody class="text-center">
          <?php
            if ($getTransctionsByOtherAccount->rowCount() > 0) {
              while ($sendMySelf = $getTransctionsByOtherAccount->fetch()) {
                // Vars
                $transaction_id = $sendMySelf['id'];
                $transaction_agant_name = $sendMySelf['agent_name'];
                $transaction_agant_country = $sendMySelf['agent_contry'];
                $transaction_amount_received = $sendMySelf['amount_received'];
                $transaction_amount_to_send = $sendMySelf['amount_to_send'];
                $transaction_network = $sendMySelf['network'];
                $transaction_receiver_name = $sendMySelf['receiver_name'];
                $current_init_agent = $sendMySelf['current_agent_name'];
                $receiver_phone = $sendMySelf['receiver_phone'];
                $network_russie = $sendMySelf['network_russie'];
                $type = $sendMySelf['type_form'];
                $statut = $sendMySelf['statut'];
                $wave_amount_val = $sendMySelf['wave_amount'];
                // Payeur
                $payeur_agent = $sendMySelf['payeur'];
                $statut_paiement = $sendMySelf['paiement_statut'];
                // Type Account
                $type_of_acc = $sendMySelf['type_of_acc'];
                // URL Encoded
                $urlEncode = base64_encode($transaction_id);

                // Afficher slmt les transactions initiées par le compte
                if ($login_name == $transaction_agant_name) {
                  ?>
                    <tr>
                      <td data-title='Identifiant'> <?= $transaction_id; ?> </td>
                      <td data-title='Type Transaction'>
                        <?php
                          if ($type == 'send' && $type_of_acc == 'Afrique') {
                            echo '<span style="background-color: #fa8231;" class="badge text-white fw-bold">
                              <i class="fa-solid fa-paper-plane"></i>
                              Envoi Afrique
                            </span>';
                          } else if ($type == 'send' && $type_of_acc == 'ChapMoney') {
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
                      <td data-title='A. Initiateur'> 
                        <?php
                          if ($login_name == $transaction_agant_name) {
                            echo $current_init_agent;
                          } else {
                            echo $transaction_agant_name;
                          }
                        ?>
                      </td>
                      <td data-title='A Transférer'>
                        <?php
                          if ($type == 'paiement') {
                            if ($transaction_network == 'Wave Money') {
                              echo number_format($wave_amount_val, 0, ',', ' ');
                            } else {
                              echo number_format($transaction_amount_received, 0, ',', ' ');
                            }
                          } else if ($type == 'send' && ($login_name == $current_init_agent)) {
                            echo number_format($transaction_amount_received, 0, ',', ' ');
                          } else {
                            echo number_format($transaction_amount_to_send, 0, ',', ' ');
                          }
                        ?>
                      </td>
                      <td data-title='Réseaux'> <?= $transaction_network; ?> </td>
                      <td data-title='Nom bénéf.'> <?= $transaction_receiver_name; ?> </td>
                      <td data-title='Statut'>
                        <?php
                          if ($statut == 'disabled') {
                            if ($login_name == $current_init_agent) {
                              echo '
                                <span style="background-color: #fed330;" class="badge text-dark fw-bold">
                                  En attente
                                  <i class="fa-solid fa-circle-arrow-right"></i>
                                </span>
                              ';
                            } else {
                              ?>
                                <a href="./statusTransaction?id=<?= $urlEncode; ?>">
                                  <i class="fa-solid fa-toggle-off" style="color: #a5b1c2; font-size: 1.3rem; cursor: pointer;"></i>
                                </a>
                              <?php
                            }
                          } else {
                            echo '<i class="fa-solid fa-toggle-on" style="color: #20bf6b; font-size: 1.3rem;"></i>';
                          }
                        ?>
                      </td>
                      <td data-title="Téléphone">
                        <?php
                          if ($type == 'send') {
                            echo $receiver_phone;
                          } else {
                            echo '---';
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
</div>