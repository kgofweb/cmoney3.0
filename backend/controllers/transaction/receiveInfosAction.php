<?php
if (!$_SESSION['phoneNumber']) {
  header(htmlspecialchars('Location: ./home'));
} else if ((time() - $_SESSION['last_time']) > 700) {
  $_SESSION['cancel'] = 'Votre session a été annulée. Veuillez reprendre la procédure.';
  header(htmlspecialchars('Location: ./home'));
}

// PHP Mailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
// Import PHPMailer components
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$montant_rouble = $_SESSION['montant_a_transferer'];
$code = $_SESSION['otpCode'];

if (isset($_POST) & !empty($_POST)) {
  if (isset($_POST['csrf_token_save'])) {
    if ($_POST['csrf_token_save'] == $_SESSION['csrf_token_save']) {
      $max_time = 300;

      if (isset($_SESSION['token_time'])) {
        $token_time = $_SESSION['token_time'];

        if (($token_time + $max_time) >= time()) {

          // Logic
          if (isset($_POST['data_withdrawal'])) {

            if (!empty($_POST['bank_withdrawal']) AND !empty($_POST['name_withdrawal']) AND !empty($_POST['number_phone_withdrawal']) || !empty($_POST['bankUser_withdrawal'])) {

              // secrure data function
              function secure_data_input($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
              }

              // Récupérer les données des inputs
              $bankName = secure_data_input($_POST['bank_withdrawal']);
              $numberPhoneTypeByUser = secure_data_input($_POST['number_phone_withdrawal']);
              $bankNameTypeByUser = secure_data_input($_POST['bankUser_withdrawal']);
              $nameUser = secure_data_input($_POST['name_withdrawal']);

              $init_retrait = $db->prepare('SELECT id, verification_code, status_payement, ask_withdrawal FROM new_transaction WHERE verification_code = ?');
              $init_retrait->execute(array($code));

              if ($init_retrait->rowCount() > 0) {
                // Recupérer les données de la transaction qui demande le retrait
                $ask = $init_retrait->fetch();
                // Recuperer l'id de la transaction
                $idOfTransaction = $ask['id'];

                // Si la demande n'a pas encore ete effectuée, alors on effectue une nouvelle demande
                if ($ask['status_payement'] == NULL) {
                  // Si le paiement n'a pas deja été effectué
                  if ($ask['ask_withdrawal'] == NULL) {
                    
                    // Lancer la demande de retrait
                    $nouvelle_demande = $db->prepare("UPDATE new_transaction SET ask_withdrawal = NOW() WHERE verification_code = '" . $code . "' AND verification_code = '" . $code . "'");
                    $nouvelle_demande->execute(array());

                    // Save user infos in data base
                    $insertAskWithdrawal = $db->prepare('INSERT INTO retrait(bank_withdrawal, bankUser_withdrawal, number_phone_withdrawal, name_withdrawal, montant_rouble, id_transaction, code) VALUES (?, ?, ?, ?, ?, ?, ?)');
                    $insertAskWithdrawal->execute([
                      $bankName,
                      $bankNameTypeByUser,
                      $numberPhoneTypeByUser,
                      $nameUser,
                      $montant_rouble,
                      $idOfTransaction,
                      $code
                    ]);
                    
                    // Send to email
                    $mail = new PHPMailer(true);
                    
                    // Send email Notifications
                    try {
                      //Send using SMTP
                      $mail->isSMTP();
                      //Set the SMTP server to send through
                      $mail->Host = 'smtp.gmail.com';
                      //Enable SMTP authentication
                      $mail->SMTPAuth = true;
                      //SMTP username
                      $mail->Username = 'chapmoneyapp@gmail.com';
                      //SMTP password
                      $mail->Password = 'muhutxwdqbxumuko';
                      // Enable TLS encryption;
                      // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                      $mail->SMTPSecure = 'ssl';
                      $mail->Port = 465;
                      //Recipients
                      $mail->setFrom('chapmoneyapp@gmail.com', 'ChapMoney Transfert');
                      //Add a recipient
                      $mail->addAddress('chapmoneyonline@gmail.com');
                      //Set email format to HTML
                      $mail->isHTML(true);

                      $mail->Subject = 'Demande de retrait';
                      $mail->Body = "
                        <p style='font-size: 1.1rem; text-align: center;'>
                          Nouvelle demande de retrait sur ChapMoney Online. Veuillez la vérifier en <a href='https://chapmoney.org/views/admin/admin'>cliquant ici</a>.
                        </p>
                        <p style='text-align: center;'>2023 - &copy; - Tout droit réservé</p>
                      ";
                      // Send email
                      $mail->send();

                    } catch (Exception $e) {
                      echo "Une erreur est survenue; Veuillez réessayer.";
                    }
                    
                    $_SESSION['validate'] = "Votre demande a bien été prise en compte et est en cours de traitement";
                    header(htmlspecialchars('Location: ./home'));
                    
                  } else {
                    $_SESSION['alreadyAsk'] = "Vous avez déjà demandé un retrait. Suivez son évolution dans l'onglet SUIVI.";
                    header(htmlspecialchars('Location: ./home'));
                  }
                } else {
                  $_SESSION['validate'] = "Votre paiement a déjà effectué.";
                  header(htmlspecialchars('Location: ./home'));
                }
              }

            } else {
              $_SESSION['error'] = 'Completez tous les champs !';
            }
          }

        } else {
          unset($_SESSION['csrf_token_save']);
          unset($_SESSION['token_time']);

          $_SESSION['cancel'] = 'Session annulée. Vueillez reprendre.';
          header(htmlspecialchars('Location: ./home'));
        }
      }
    }
  }
}

$token = md5(uniqid(rand(), true));
$_SESSION['csrf_token_save'] = $token;
$_SESSION['token_time'] = time();

if (isset($_POST['cancel'])) {
  $_SESSION['cancel'] = 'La demande de retrait a bien été anulée.';
  header(htmlspecialchars('Location: ./home'));
}