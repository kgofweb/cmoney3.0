<?php
require('../backend/src/rate.php');
// Convert amount
$amountConvert = intval($amount);
require('../backend/src/percentage.php');

$percentage;
$finalAmount;

$amount_retrait;

// ============= AO vers Russie 2% ============= //
if (($senderCountry === 'civ' || $senderCountry === 'mali' || $senderCountry === 'senegal' || $senderCountry === 'benin' || $senderCountry === 'burkina' || $senderCountry == 'togo' || $senderCountry == 'niger') && $receiverCountry === 'russie') {
  $amount_retrait = $amountConvert * $civRussia;
  $finalAmount = number_format($amount_retrait, 2, ',', ' '). ' <i class="fa-solid fa-ruble-sign"></i>';
  $change = 'FCFA';
  $percentage = $amountConvert * $percentageAfriqueOuest;
} 
// ============= AC vers Russie 6% ============= //
else if (($senderCountry === 'gabon') && $receiverCountry == 'russie') {
  $amount_retrait = $amountConvert * $rateAC;
  $finalAmount = number_format($amount_retrait, 2, ',', ' '). ' <i class="fa-solid fa-ruble-sign"></i>';
  $change = 'FCFA';
  $percentage = $amountConvert * $frais_gabon;
} 
else if (($senderCountry === 'congo') && $receiverCountry == 'russie') {
  $amount_retrait = $amountConvert * $rateAC;
  $finalAmount = number_format($amount_retrait, 2, ',', ' '). ' <i class="fa-solid fa-ruble-sign"></i>';
  $change = 'FCFA';
  $percentage = $amountConvert * $frais_congo;
}
// ========= 5% ======== //
else if ($senderCountry === 'cameroun' && $receiverCountry == 'russie') {
  $amount_retrait = $amountConvert * $rateAC;
  $finalAmount = number_format($amount_retrait, 2, ',', ' '). ' <i class="fa-solid fa-ruble-sign"></i>';
  $change = 'FCFA';
  $percentage = $amountConvert * $camerounVersRussie;
}
// ======= Russie vers AC 2% ====== //
else if ($senderCountry === 'russie' && ($receiverCountry === 'gabon' || $receiverCountry === 'congo' || $senderCountry == 'tchad' || $senderCountry == 'centreAfrique' || $receiverCountry == 'cameroun')) {
  $amount_retrait = $amountConvert * $rateRubAc;
  $finalAmount = number_format($amount_retrait, 2, ',', ' '). ' FCFA';
  $change = 'RUB';
  $percentage = $amountConvert * $russieVersAfriqueOuestEtCentrale;
}

// ================= Entre AO 2.5% ================= //
else if (($senderCountry == 'civ' || $senderCountry == 'benin' || $senderCountry == 'burkina' || $senderCountry == 'senegal' || $senderCountry == 'mali' || $senderCountry == 'togo' || $senderCountry == 'niger') && ($receiverCountry == 'civ' || $receiverCountry == 'mali' || $receiverCountry == 'senegal' || $receiverCountry == 'benin' || $receiverCountry == 'burkina' || $receiverCountry == 'togo' || $receiverCountry == 'niger')) {
  $amount_retrait = $amountConvert * $rate;
  $finalAmount = number_format($amount_retrait, 2, ',', ' '). ' FCFA';
  $change = 'FCFA';
  $percentage = $amountConvert * $percentageEntreAfriqueOuest;
} 
// ================= Entre AC 4% ================= //
else if (($senderCountry == 'cameroun' || $senderCountry == 'gabon' || $senderCountry == 'congo') && ($receiverCountry == 'cameroun' || $receiverCountry == 'gabon' || $receiverCountry == 'congo' || $receiverCountry == 'tchad' || $receiverCountry == 'centreAfrique')) {
  $amount_retrait = $amountConvert * $rate;
  $finalAmount = number_format($amount_retrait, 2, ',', ' '). ' FCFA';
  $change = 'FCFA';
  $percentage = $amountConvert * $percentageEntreAfriqueCentrale;
}
// ================ AO vers AC 5% ============= //
else if (($senderCountry == 'civ' || $senderCountry == 'mali' || $senderCountry == 'senegal' || $senderCountry == 'benin' || $senderCountry == 'burkina' || $senderCountry == 'togo' || $senderCountry == 'niger') && ($receiverCountry == 'cameroun' || $receiverCountry == 'gabon' || $receiverCountry == 'congo' || $receiverCountry == 'centreAfrique' || $receiverCountry == 'tchad')) {
  $amount_retrait = $amountConvert * $rate;
  $finalAmount = number_format($amount_retrait, 2, ',', ' '). ' FCFA';
  $change = 'FCFA';
  $percentage = $amountConvert * $percentageAfriqueOuestVersAfriqueCentrale;
}
// ================= AC vers AO 8% ================= //
else if (($senderCountry == 'congo' || $senderCountry == 'gabon' || $senderCountry == 'cameroun') && ($receiverCountry == 'civ' || $receiverCountry == 'mali' || $receiverCountry == 'benin' || $receiverCountry == 'senegal' || $receiverCountry == 'togo' || $receiverCountry == 'burkina' || $receiverCountry == 'niger')) {
  $amount_retrait = $amountConvert * $rate;
  $finalAmount = number_format($amount_retrait, 2, ',', ' '). ' FCFA';
  $change = 'FCFA';
  $percentage = $amountConvert * $percentageAfriqueCentraleVersAfriqueOuest;
}
// ================ Entre Russie =============== //
else if ($senderCountry == 'russie' && $receiverCountry == 'russie') {
  $amount_retrait = $amountConvert * $rate;
  $finalAmount = number_format($amount_retrait, 2, ',', ' '). ' <i class="fa-solid fa-ruble-sign"></i>';
  $change = 'RUB';
  $percentage = $amountConvert * $percentageEntreRussie;
}

// **************** Debut Guinee **************** //
// Guinee vers Russie
else if ($senderCountry == 'guinee' && $receiverCountry == 'russie') {
  $amount_retrait = $amountConvert * $guineeVersRussie;
  $finalAmount = number_format($amount_retrait, 2, ',', ' '). ' <i class="fa-solid fa-ruble-sign"></i>';
  $change = 'GNF';
  $percentage = $amountConvert * $percentageAfriqueOuest;
}
// Russie vers Guinee
else if ($senderCountry == 'russie' && $receiverCountry == 'guinee') {
  $amount_retrait = $amountConvert * $russieVersGuinee;
  $finalAmount = number_format($amount_retrait, 2, ',', ' '). ' GNF';
  $change = '<i class="fa-solid fa-ruble-sign"></i>';
  $percentage = $amountConvert * $russieVersAfriqueOuestEtCentrale;
} 
// Guinee vers AO
else if ($senderCountry == 'guinee' && ($receiverCountry == 'civ' || $receiverCountry == 'niger' || $receiverCountry == 'mali' || $receiverCountry == 'senegal' || $receiverCountry == 'benin' || $receiverCountry == 'burkina' || $receiverCountry == 'togo')) {
  $amount_retrait = $amountConvert * $guineeVersAO_AC;
  $finalAmount = number_format($amount_retrait, 2, ',', ' '). ' FCFA';
  $change = 'GNF';
  $percentage = $amountConvert * $percentage_Guinee_Vers_AfriqueOuest;
}
// Guinee vers AC
else if ($senderCountry == 'guinee' && ($receiverCountry == 'congo' || $receiverCountry == 'gabon' || $receiverCountry == 'tchad' || $receiverCountry == 'centreAfrique' || $receiverCountry == 'cameroun')) {
  $amount_retrait = $amountConvert * $guineeVersAO_AC;
  $finalAmount = number_format($amount_retrait, 2, ',', ' '). ' FCFA';
  $change = 'GNF';
  $percentage = $amountConvert * $percentage_Guinee_Vers_AfriqueCentrale;
}
// AO vers guinee
else if (($senderCountry === 'civ' || $senderCountry === 'niger' || $senderCountry === 'mali' || $senderCountry === 'senegal' || $senderCountry === 'benin' || $senderCountry === 'burkina' || $senderCountry == 'togo') && $receiverCountry == 'guinee') {
  $amount_retrait = $amountConvert * $AO_AC_vers_Guinee;
  $finalAmount = number_format($amount_retrait, 2, ',', ' '). ' GNF';
  $change = 'FCFA';
  $percentage = $amountConvert * $percentage_AO_vers_Guinee;
}
// AC vers guinee
else if (($senderCountry === 'cameroun' || $senderCountry === 'congo' || $senderCountry === 'gabon') && $receiverCountry == 'guinee') {
  $amount_retrait = $amountConvert * $AO_AC_vers_Guinee;
  $finalAmount = number_format($amount_retrait, 2, ',', ' '). ' GNF';
  $change = 'FCFA';
  $percentage = $amountConvert * $percenageAC_vers_Guinee;
}
// Entre guinee
else if ($senderCountry == 'guinee' && $receiverCountry == 'guinee') {
  $amount_retrait = $amountConvert * $rate;
  $finalAmount = number_format($amount_retrait, 2, ',', ' '). ' GNF';
  $change = 'GNF';
  $percentage = $amountConvert * $percentage_Guinee_Vers_AfriqueOuest;
}
// **************** Fin Guinee **************** //

// **************** Debut RDC **************** //
// RDC vers Russie
else if ($senderCountry == 'rdc' && $receiverCountry == 'russie') {
  $amount_retrait = $amountConvert * $rdc_Vers_Russie;
  $finalAmount = number_format($amount_retrait, 2, ',', ' '). ' <i class="fa-solid fa-ruble-sign"></i>';
  $change = '<i class="fa-solid fa-dollar-sign"></i>';
  $percentage = $amountConvert * $percentageAfriqueCentrale;
}
// Russie vers RDC
else if ($senderCountry == 'russie' && $receiverCountry == 'rdc') {
  $amount_retrait = $amountConvert * $russie_Vers_RDC;
  $finalAmount = number_format($amount_retrait, 2, ',', ' '). ' <i class="fa-solid fa-dollar-sign"></i>';
  $change = '<i class="fa-solid fa-ruble-sign"></i>';
  $percentage = $amountConvert * $russieVersAfriqueOuestEtCentrale;
}
// RDC vers AO
else if ($senderCountry == 'rdc' && ($receiverCountry == 'civ' || $receiverCountry == 'mali' || $receiverCountry == 'senegal' || $receiverCountry == 'benin' || $receiverCountry == 'burkina' || $receiverCountry == 'togo')) {
  $amount_retrait = $amountConvert * $rdc_Vers_AO;
  $finalAmount = number_format($amount_retrait, 2, ',', ' '). ' FCFA';
  $change = '<i class="fa-solid fa-dollar-sign"></i>';
  $percentage = $amountConvert * $percentageAfriqueCentraleVersAfriqueOuest;
}
// RDC vers AC
else if ($senderCountry == 'rdc' && ($receiverCountry == 'congo' || $receiverCountry == 'gabon' || $receiverCountry == 'tchad' || $receiverCountry == 'centreAfrique' || $receiverCountry == 'cameroun')) {
  $amount_retrait = $amountConvert * $rdc_Vers_AC;
  $finalAmount = number_format($amount_retrait, 2, ',', ' '). ' FCFA';
  $change = '<i class="fa-solid fa-dollar-sign"></i>';
  $percentage = $amountConvert * $percentageEntreAfriqueCentrale;
}
// AO vers RDC
else if (($senderCountry === 'civ' || $senderCountry === 'mali' || $senderCountry === 'senegal' || $senderCountry === 'benin' || $senderCountry === 'burkina' || $senderCountry == 'togo') && $receiverCountry == 'rdc') {
  $amount_retrait = $amountConvert * $AO_Vers_rdc;
  $finalAmount = number_format($amount_retrait, 2, ',', ' '). ' <i class="fa-solid fa-dollar-sign"></i>';
  $change = 'FCFA';
  $percentage = $amountConvert * $percentageAfriqueOuestVersAfriqueCentrale;
}
// AC Vers RDC
else if (($senderCountry === 'cameroun' || $senderCountry === 'congo' || $senderCountry === 'gabon') && $receiverCountry == 'rdc') {
  $amount_retrait = $amountConvert * $AC_Vers_rdc;
  $finalAmount = number_format($amount_retrait, 2, ',', ' '). ' <i class="fa-solid fa-dollar-sign"></i>';
  $change = 'FCFA';
  $percentage = $amountConvert * $percentageEntreAfriqueCentrale;
}
// Entre RDC
else if ($senderCountry == 'rdc' && $receiverCountry == 'rdc') {
  $amount_retrait = $amountConvert * $rate;
  $finalAmount = number_format($amount_retrait, 2, ',', ' '). ' <i class="fa-solid fa-dollar-sign"></i>';
  $change = '<i class="fa-solid fa-dollar-sign"></i>';
  $percentage = $amountConvert * $percentageEntreAfriqueCentrale;
}
// **************** Fin RDC **************** //

// ============== Russie vers AO 2% =============== //
else {
  $amount_retrait = $amountConvert * $russiaCIV;
  $finalAmount = number_format($amount_retrait, 2, ',', ' '). ' FCFA';
  $change = '<i class="fa-solid fa-ruble-sign"></i>';
  $percentage = ($amountConvert * $russieVersAfriqueOuestEtCentrale);
}

// Save amount 
$_SESSION['percentage'] = $percentage;
$_SESSION['amount_retrait'] = $amount_retrait;