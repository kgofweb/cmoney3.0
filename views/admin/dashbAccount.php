<?php
  // Get ID via account connexion
  $account_id = $_SESSION['id'];

  // Get Login Admin Name
  if (isset($_SESSION['user_admin'])) {
    $login_name = $_SESSION['user_admin'];
  }
  // Get Country Admin Name
  if (isset($_SESSION['account_contry'])) {
    $login_country = $_SESSION['account_contry'];
  }
  
  $getAccountInfos = $db->prepare('SELECT account_contry, account_type, account_solde, gains FROM `other_profile` WHERE id = ?');
  $getAccountInfos->execute([$account_id]);

  // If we have a result after request
  if ($getAccountInfos->rowCount() > 0) {
    // Get result
    $accountInfosResult = $getAccountInfos->fetch();
    // Get variables
    $acc_country = $accountInfosResult['account_contry'];
    $acc_type = $accountInfosResult['account_type'];
    $acc_solde = $accountInfosResult['account_solde'];
    $gains = $accountInfosResult['gains'];
  }

  // Set Devices Money
  switch ($acc_country) {
    case 'Russie':
      $change = '<i class="fa-solid fa-ruble-sign"></i>';
      break;
    case 'RDC':
      $change = '<i class="fa-solid fa-dollar-sign"></i>';
      break;
    default:
      $change = '<span class="fw-bold">FCFA</span>';
      break;
  }

  // ============= Transaction Via le Site =================== //
  $transaction_site = $db->prepare("SELECT * FROM `new_transaction` WHERE af_name = ? ORDER BY date DESC");
  $transaction_site->execute([$login_name]);
  // Payer
  $set_payer_site_transaction = $db->prepare("SELECT * FROM `retrait` WHERE payer = ?");
  $set_payer_site_transaction->execute([$login_name]);

  // Logic to show Manuelles transactions
  $getTransctionsInfgos = $db->prepare("SELECT * FROM `manuel_transaction` ORDER BY id DESC");
  $getTransctionsInfgos->execute();

  // Logic to show only transactions sent buy account
  $getTransctionsByAccount = $db->prepare("SELECT * FROM `manuel_transaction` ORDER BY id DESC");
  $getTransctionsByAccount->execute();
  // Transaction recues par le suatres agents
  $getTransctionsByOtherAccount = $db->prepare("SELECT * FROM `manuel_transaction` ORDER BY id DESC");
  $getTransctionsByOtherAccount->execute();
  // Transaction recues via le site
  $getTransctionsViaWebSite = $db->prepare("SELECT * FROM `manuel_transaction` ORDER BY id DESC");
  $getTransctionsViaWebSite->execute();
  // Transaction via Site
  $transaction_siteAF = $db->prepare("SELECT * FROM `new_transaction` WHERE af_name = ? ORDER BY date DESC");
  $transaction_siteAF->execute([$login_name]);

  // ================= Transactions compte CHAPMONEY ================= //
  $getTransctionsByAccountCM = $db->prepare("SELECT * FROM `manuel_transaction` ORDER BY id DESC");
  $getTransctionsByAccountCM->execute();
  // Payer (Retrait Site)
  $set_payer_siteTransaction = $db->prepare("SELECT * FROM `retrait` WHERE payer = ?");
  $set_payer_siteTransaction->execute([$login_name]);
  // Transaction Paiement Manuel
  $getTransctionsPaiementManuel = $db->prepare("SELECT * FROM `manuel_transaction` ORDER BY id DESC");
  $getTransctionsPaiementManuel->execute();


  // Check Transaction
  $checkTransactionStatut = $db->prepare("SELECT statut, trans_gains FROM `manuel_transaction` WHERE current_agent_name = ?");
  $checkTransactionStatut->execute([$login_name]);

  $dispo_gains = 0;
  if ($checkTransactionStatut->rowCount() > 0) {
    while ($fetch_statut_res = $checkTransactionStatut->fetch(PDO::FETCH_ASSOC)) {
      $statut_result = $fetch_statut_res['statut'];
      $transaction_gains = $fetch_statut_res['trans_gains'];

      if ($statut_result == 'enabled') {
        $dispo_gains += $transaction_gains;
      }
    } 
  }
?>

<style>
  .header_content {
    display: flex;
  }
  .solde_gains {
    margin-right: 1rem;
  }
  .solde {
    color: #05c46b;
  }
  .services {
    display: flex;
  }
  .send {
    width: 39rem;
  }
  .send, .payement {
    margin-right: 1rem;
  }
  @media screen and (max-width: 765px) {
    .account {
      width: 100%;
    }
  }
  @media screen and (max-width: 992px) {
    .header_content {
      flex-direction: column;
    }
    .solde_gains {
      margin-right: 0rem;
    }
    .country_account {
      margin: 0 0 1rem 0 !important;
    }
    .button {
      margin: 1rem 0;
    }
  }
  @media screen and (max-width: 1000px) {
    .services {
      flex-direction: column;
    }
    .send {
      width: 100%;
    }
    .historique {
      margin-left: 0rem;
    }
  }
</style>

<!-- Success messages -->
<?php include '../../views/includes/alerts/alert_success.php'; ?>

<section>
  <!-- Solde for user Account -->
  <div class="header_content">
    <div class="card solde_gains my-3">
      <div class="card-body">
        <?php
          if ($acc_type == 'Afrique' || $acc_type == 'ChapMoney') {
            ?>
              <div class="my-0">
                <span><i class="fa-solid fa-wallet"></i></span>
                Solde :
                <span class="fw-bold solde">
                  <?= number_format($acc_solde, 0, ',', ' '). ' '. $change; ?>
                </span>
              </div>
            <?php
          } else {
            ?>
              <div class="my-0">
                <span><i class="fa-solid fa-wallet"></i></span>
                Payés :
                <span class="fw-bold solde">
                  <?= number_format($acc_solde, 0, ',', ' '); ?>
                </span>
              </div>
            <?php
          }
        ?>
        <!-- Gains for user Account -->
        <div class="gains">
          <i class="fa-solid fa-coins"></i>
          <?php
            if ($acc_type == 'ChapMoney') {
              ?>
                Total gains : 
                <span class="fw-bold"><?= $gains; ?></span>
              <?php
            } else {
              ?>
                Vos gains : <span class="fw-bold solde"> <?= $gains; ?> </span>
              <?php
            }
          ?>
        </div>
      </div>
    </div>
    <!-- Infos user Account -->
    <div class="card country_account my-3">
      <div class="card-body">
        <div>
          Pays : <span class="fw-bold"><?= $acc_country; ?></span>
        </div>
        <div>
          Compte : <span class="fw-bold"><?= $acc_type; ?></span>
        </div>
      </div>
    </div>

    <?php
      if ($acc_type == 'ChapMoney') {
        ?>
          <div class="card country_account mx-3 my-3">
            <div class="card-body">
              <i class="fa-solid fa-coins"></i>
              Gains valides : 
              <span class="fw-bold solde"> 
                <?= $dispo_gains; ?> 
              </span>
            </div>
          </div>
        <?php
      }
    ?>
  </div>

  <!-- Button Action -->
  <?php
    if ($acc_type == 'ChapMoney') {
      ?>
        <div class="button">
          <a class="btn me-2 my-2 btn-sm" style="text-decoration: none; color: #fff;" href="./sendTransaction">
            <i class="fa-solid fa-paper-plane me-1"></i>
            Envoi
          </a>
          <a class="btn me-2 my-2 btn-sm" style="text-decoration: none; color: #fff;" href="./paiementTransaction">
            <i class="fa-solid fa-wallet me-1"></i>
            Paiement
          </a>
        </div>
      <?php
    } else if ($acc_type == 'Afrique') {
      ?>
        <div class="button">
          <a class="btn me-2 my-2 btn-sm" style="text-decoration: none; color: #fff;" href="./sendTransaction">
            <i class="fa-solid fa-wallet me-1"></i>
            Envoi
          </a>
        </div>
      <?php
    }
  ?>

  <section id="sec-1"></section>
  <!-- Scroll Down -->
  <div class="text-center">
    <a href="#sec-2" class="scroll_d">
      <div class="scroll-down text-white">
        <i class="fa-solid fa-angles-down"></i>
      </div>
    </a>
  </div>

  <!-- Send service -->
  <div class="services">
    <!-- ========= Historique ========= -->
    <div class="card my-3 w-100 service historique"> 
      <div class="card-body">
        <h6><i class="fa-solid fa-rotate-right"></i> Historique de transactions</h6>

        <!-- Affichage dans les diffrents comptes -->
        <?php
          if ($acc_type == 'Afrique') {
            ?>
              <!-- ======= Compte Afrique ======= -->
              <?php include '../../views/admin/accountShowing/afriqueAccount.php'; ?>
            <?php
          } else if ($acc_type == 'ChapMoney') {
            ?>
              <!-- ======= Compte ChapMoney ======= -->
              <?php include '../../views/admin/accountShowing/chapmoneyAccount.php'; ?>
            <?php
          } else if ($acc_type == 'Payeur') {
            
          }
        ?>
        



        <div class="table-responsive" id="no-more-tables">
          <table class="table table-hover table-bordered table-striped table-sm">
            <thead class="bg-dark text-white text-center">
              <tr>
                <th>ID</th>
                <?php
                  if ($acc_type !== 'Payeur') {
                    echo '<th>Type</th>';
                  }
                ?>
                <?php
                  if ($acc_type == 'ChapMoney') {
                    echo '<th>Pays Agent</th>';
                  }
                ?>
                <th>
                  <?php
                    if ($acc_type == 'ChapMoney') {
                      echo 'Nom Agent';
                    } else if ($acc_type == 'Afrique') {
                      echo 'Agent';
                    } else {
                      echo 'Téléphone';
                    }
                  ?>
                </th>
                <?php
                  if ($acc_type == 'ChapMoney') {
                    echo '<th>Somme Reçue</th>';
                  }
                ?>
                <?php
                  if ($acc_type == 'ChapMoney' || $acc_type == 'Afrique') {
                    echo '<th>Somme</th>';
                  }
                ?>
                <?php
                  if ($acc_type == 'Payeur') {
                    echo '<th>Banque</th>';
                  } else {
                    echo '<th>Réseaux</th>';
                  }
                ?>
                <th>Bénéficiaire</th>
                <?php
                  if ($acc_type == 'Afrique') {
                    echo '<th>Statut</th>';
                    echo '<th>Téléphone</th>';
                  }
                ?>
                <?php
                  if ($acc_type == 'ChapMoney') {
                    echo '<th>Reception</th>';
                    echo '<th>Paiement</th>';
                  }
                ?>
                <?php
                  if ($acc_type == 'Payeur') {
                    echo '<th>Somme</th>';
                    echo '<th>Paiement</th>';
                  }
                ?>
              </tr>
            </thead>
            <tbody class="text-center">
              <?php
                if ($getTransctionsInfgos->rowCount() > 0) {
                  while ($infos = $getTransctionsInfgos->fetch()) {
                    $transaction_id = $infos['id'];
                    $transaction_agant_name = $infos['agent_name'];
                    $transaction_agant_country = $infos['agent_contry'];
                    $transaction_amount_received = $infos['amount_received'];
                    $transaction_amount_to_send = $infos['amount_to_send'];
                    $transaction_network = $infos['network'];
                    $transaction_receiver_name = $infos['receiver_name'];
                    $current_init_agent = $infos['current_agent_name'];
                    $receiver_phone = $infos['receiver_phone'];
                    $network_russie = $infos['network_russie'];
                    $type = $infos['type_form'];
                    $statut = $infos['statut'];
                    $wave_amount_val = $infos['wave_amount'];

                    // Payeur
                    $payeur_agent = $infos['payeur'];
                    $statut_paiement = $infos['paiement_statut'];

                    // Type Account
                    $type_of_acc = $infos['type_of_acc'];

                    // URL Encoded
                    $urlEncode = base64_encode($transaction_id);

                    if ($login_name == $current_init_agent || $login_name == $transaction_agant_name) {
                      ?>
                        <tr>
                          <td data-title='Identifiant'> <?= $transaction_id; ?> </td>
                          <td data-title='Type Transaction'> 
                            <?php
                              if ($acc_type == 'ChapMoney') {
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
                              } else if ($acc_type == 'Afrique') {
                                if ($type == 'send' && $type_of_acc == 'Afrique') {
                                  echo '<span style="background-color: #fa8231;" class="badge text-white fw-bold">
                                    <i class="fa-solid fa-paper-plane"></i>
                                    Envoi Afrique
                                  </span>';
                                }
                                else if ($type == 'send' && $type_of_acc == 'ChapMoney') {
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
                              }
                            ?>
                          </td>
                          <?php
                            if ($acc_type == 'ChapMoney') {
                              ?>
                                <td data-title='Pays Agent'> <?= $transaction_agant_country; ?> </td>
                              <?php
                            }
                          ?>
                          <td data-title='Initiateur'> 
                            <?php
                              if ($login_name == $transaction_agant_name) {
                                echo $current_init_agent;
                              } else {
                                echo $transaction_agant_name;
                              }
                            ?>
                          </td>
                          <?php
                            if ($acc_type == 'ChapMoney') {
                              ?>
                                <td data-title='M. reçue'><?= number_format($transaction_amount_received, 0, ',', ' '); ?></td>
                              <?php
                            } 
                          ?>
                          <td data-title='A transférer'> 
                            <?php
                              if ($acc_type == 'Afrique') {
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
                              } else if ($acc_type == 'ChapMoney') {
                                echo number_format($transaction_amount_to_send, 0, ',', ' ');
                              }
                            ?>
                          </td>
                          <td data-title='Réseaux'> <?= $transaction_network; ?> </td>
                          <td data-title='Nom bénéf'> <?= $transaction_receiver_name; ?> </td>
                          <?php
                            if ($acc_type == 'Afrique') {
                              ?>
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
                              <?php
                            } 
                          ?>
                          <?php
                            if ($acc_type == 'ChapMoney') {
                              if ($type == 'send') {
                                echo '<td data-title="Reception">
                                  <span style="background-color: var(--primary-color);" class="badge text-white fw-bold">
                                    <i class="fa-solid fa-toggle-on"></i>
                                    Confirmé
                                  </span>
                                </td>';
                              } else if ($type == 'paiement' && $statut == 'enabled') {
                                echo '<td data-title="Reception">
                                  <span style="background-color: #27ae60;" class="badge text-white fw-bold">
                                    <i class="fa-solid fa-toggle-on"></i>
                                    Validé
                                  </span>
                                </td>';
                              } else {
                                echo '<td data-title="Statut">
                                  <span style="background-color: #fed330;" class="badge text-dark fw-bold">
                                    <i class="fa-solid fa-toggle-off"></i>
                                    En attente
                                  </span>
                                </td>';
                              }
                            }
                          ?>
                          <?php
                            if ($acc_type == 'ChapMoney') {
                              if ($type == 'send' && $statut == 'enabled') {
                                echo '<td data-title="Paiement">
                                  <span style="background-color: #27ae60;" class="badge text-white fw-bold">
                                    <i class="fa-solid fa-toggle-on"></i>
                                    Confirmé
                                  </span>
                                </td>';
                              } else if ($type == 'paiement' && $statut_paiement == 'disabled') {
                                echo '<td data-title="Paiement">
                                  <span style="background-color: #fed330;" class="badge text-dark fw-bold">
                                    <i class="fa-solid fa-clock"></i>
                                    En cours...
                                  </span>
                                </td>';
                              } else if ($type == 'paiement' && $statut_paiement == 'enabled') {
                                echo '<td data-title="Paiement">
                                  <span style="background-color: #27ae60;" class="badge text-white fw-bold">
                                    <i class="fa-solid fa-check-circle"></i>
                                    Effectué
                                  </span>
                                </td>';
                              } else {
                                echo '<td data-title="Paiement">
                                  <span style="background-color: #fed330;" class="badge text-dark fw-bold">
                                    <i class="fa-solid fa-clock"></i>
                                    En attente
                                  </span>
                                </td>';
                              }
                            } else if ($acc_type == 'Afrique') {
                              if ($type == 'send') {
                                ?>
                                  <td data-title="Téléphone"> <?= $receiver_phone; ?></td>
                                <?php
                              } else {
                                ?>
                                  <td data-title="Téléphone"> --- </td>
                                <?php
                              }
                            }
                          ?>
                        </tr>
                      <?php
                    } 
                    // ================== Payeur Statment ================== //
                    if ($login_name == $payeur_agent) {
                      if ($acc_type == 'Payeur') {
                        ?>
                          <tr>
                            <td data-title='Identifiant'> <?= $transaction_id; ?> </td>
                            <td data-title='Téléphone'> <?= $receiver_phone; ?> </td>
                            <td data-title='Banque'> <?= $network_russie; ?> </td>
                            <td data-title='Nom bénéf'> <?= $transaction_receiver_name; ?> </td>
                            <td data-title='A transférer'> <?= number_format($transaction_amount_to_send, 0, ',', ' '); ?> </td>
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
                            </td>
                          </tr>
                        <?php
                      } else if ($acc_type == 'ChapMoney') {
                        ?>
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
                          <td data-title='Reseaux'> <?= $transaction_receiver_name; ?> </td>
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
                          </td>
                        <?php
                      }
                    }
                  }
                }

                // ================== Transaction site Statment ================== //
                if ($transaction_site->rowCount() > 0) {
                  while($info_trabsac_site = $transaction_site->fetch()) {
                    $transaction_site_id = $info_trabsac_site['id'];
                    $client_name = openssl_decrypt($info_trabsac_site['receiver_name'], $chiper, $key, $options, $iv);
                    $client_country = openssl_decrypt($info_trabsac_site['countryTwo'], $chiper, $key, $options, $iv);
                    $client_mode_mobile = openssl_decrypt($info_trabsac_site['receiveMode'], $chiper, $key, $options, $iv);
                    $client_mode_mobile_sender = openssl_decrypt($info_trabsac_site['sendMode'], $chiper, $key, $options, $iv);
                    $client_phone = $info_trabsac_site['numberPhoneTwo'];
                    $client_amount = $info_trabsac_site['amount_rouble'];
                    $client_amount_sending = $info_trabsac_site['amount'];
                    $af_agent_name = $info_trabsac_site['af_name'];
                    $admin = $info_trabsac_site['admin_name'];
                    $type_site_transaction = $info_trabsac_site['type_transac_site'];
                    $amount_wave = $info_trabsac_site['amount_wave'];

                    $code_verified =  $info_trabsac_site['number_verified'];

                    $url_Encode = base64_encode($transaction_site_id);

                    if ($login_name == $af_agent_name) {
                      // =================== Afrique vers Russie =================== //
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
                      } else {
                        // =================== Russie vers Afrique =================== //
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

                // ==================== Payer =============== //
                if ($set_payer_site_transaction->rowCount() > 0) {
                  while ($setPayer = $set_payer_site_transaction->fetch()) {
                    $id_transac_paiement = $setPayer['id'];
                    $amount_to_send = $setPayer['montant_rouble'];
                    $bank = $setPayer['bank_withdrawal'];
                    $other_bank = $setPayer['bankUser_withdrawal'];
                    $name_user = $setPayer['name_withdrawal'];
                    $phone_user = $setPayer['number_phone_withdrawal'];
                    $payer_agent_site = $setPayer['payer'];
                    $code_transaction = $setPayer['code'];
                    $statut_paiement_site = $setPayer['statut_paiement'];

                    // Set URL
                    $urlPaiementEncode = base64_encode($id_transac_paiement);
                    $urlCode = base64_encode($code_transaction);

                    // ============ Payeur Statment ============ //
                    if ($login_name == $payer_agent_site) {
                      if ($acc_type == 'ChapMoney') {
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
                      } else if ($acc_type == 'Payeur') {
                        ?>
                          <tr>
                            <td data-title='Identifiant'> <?= $code_transaction; ?> </td>
                            <td data-title='Reception'> <?= $phone_user; ?> </td>
                            <td data-title='Reseaux'> <?= $bank; ?> </td>
                            <td data-title='Bénéficiaire'> <?= $name_user; ?> </td>
                            <td data-title='A transférer'> <?= $amount_to_send; ?> </td>
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
                }
              ?>
            </tbody>
          </table>
        </div>
        
        <section id="sec-2"></section>
      </div>
    </div>
  </div>

  <!-- Scroll Up -->
  <div class="text-center mb-2">
    <a href="#sec-1" class="scroll_d">
      <div class="scroll-down text-white">
        <i class="fa-solid fa-angles-up"></i>
      </div>
    </a>
  </div>
</section>