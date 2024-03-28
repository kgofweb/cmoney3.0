<?php
// Data Base
require('../backend/db/database.php');

$getInfosProfile = $db->prepare("SELECT member_name, account_status, what_link FROM profile ORDER BY account_status DESC");
$getInfosProfile->execute();