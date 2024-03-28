<?php
require('../../../backend/security/security.php');
require('../../../backend/auth/authProfile.php');
require('../../../backend/role/roleUnderAdmin.php');
require('../../../backend/db/database.php');

$getInfos = $db->prepare("SELECT * FROM timbrepassport");
$getInfos->execute();