<span id="numberOne" class="principal-color">
  <?php
    if (isset($senderCountry) && isset($senderMode)) {
      if ($senderCountry == 'civ' && $senderMode == 'Wave Money') {
        echo $wavePhoneCIV;
      } else if ($senderCountry == 'civ' && $senderMode == 'Orange Money') {
        echo $omPhoneCIV;
      } else if ($senderCountry == 'civ' && $senderMode == 'Moov Money') {
        echo $moovPhoneCIV;
      } else if ($senderCountry == 'civ' && $senderMode == 'MTN') {
        echo $mtnPhoneCIV;
      } else if ($senderCountry == 'senegal' && $senderMode == 'Wave Money') {
        echo $wavePhoneSEN;
      } else if ($senderCountry == 'senegal' && $senderMode == 'Orange Money') {
        echo $omPhoneSEN;
      } else if ($senderCountry == 'mali' && $senderMode == 'Orange Money') {
        echo $omPhoneMAL;
      } else if ($senderCountry == 'benin' && $senderMode == 'MTN Money') {
        echo $mtnPhoneBEN;
      } else if ($senderCountry == 'congo' && $senderMode == 'AIRTEL Money') {
        echo $airtelPhoneBRAZAVILLE;
      } else if ($senderCountry == 'congo' && $senderMode == 'MTN Money') {
        echo $mtnPhoneRAZAVILLE;
      } else if ($senderCountry == 'cameroun' && $senderMode == 'Orange Money') {
        echo $omPhoneCAMR;
      } else if ($senderCountry == 'gabon' && $senderMode == 'AIRTEL Mobile Money') {
        echo $phoneGAB;
      } else if ($senderCountry == 'russie' && $senderMode == 'Potchta Bank' || $senderMode == 'VTB') {
        echo $phonePotchtaBank_VTB;
      } else if ($senderCountry == 'togo' && $senderMode == 'Flooz') {
        echo $floozPhoneTOG;
      } else if ($senderCountry == 'togo' && $senderMode == 'TMONEY') {
        echo $tmoneyPhoneTOG;
      } else if ($senderCountry == 'burkina' && $senderMode == 'Orange Money') {
        echo $omPhoneBURK;
      } else if ($senderCountry == 'rdc' && $senderMode == 'Orange Money') {
        echo $orangePhoneCONG;
      } else if ($senderCountry == 'rdc' && $senderMode == 'Mpesa') {
        echo $m_pesaPhoneCONG;
      } else if ($senderCountry == 'rdc' && $senderMode == 'Airtel') {
        echo $airtelPhoneCONG;
      } else if ($senderCountry == 'russie' && $senderMode == 'SberBank') {
        echo $phoneSberBank;
      } else if ($senderCountry == 'guinee' && $senderMode == 'Orange Money' || $senderMode == 'MTN areeba') {
        echo $phoneGUI;
      } else if ($senderCountry == 'niger' && $senderMode == 'Orange Money') {
        echo $phoneNIGER;
      }
    }
  ?> 
  <i id="copy" class="fa-regular fa-copy text-primary"></i>
</span>