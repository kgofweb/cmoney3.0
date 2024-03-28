<?php
if (!$_SESSION['user_admin'] && !$_SESSION['password_admin']) {
  header('Location: ./admin');
}

require('../../backend/db/database.php');
require('../../backend/env/decrypt.php');

$getInfos = $db->prepare("SELECT * FROM new_transaction ORDER BY id DESC LIMIT 25");
$getInfos->execute();

$getPlusInfos = $db->prepare("SELECT * FROM new_transaction");
$getPlusInfos->execute();

$getInfosProfile = $db->prepare("SELECT member_name, account_status FROM profile");
$getInfosProfile->execute();