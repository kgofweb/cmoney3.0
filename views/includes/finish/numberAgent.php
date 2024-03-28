<span class="principal-color">
  <?php
    if (isset($senderCountry) && isset($senderMode)) {
      if ($senderCountry == 'civ' && $senderMode == 'Wave Money') {
        echo $waveNameCIV;
      } else if ($senderCountry == 'civ' && $senderMode == 'Orange Money') {
        echo $omNameCIV;
      } else if ($senderCountry == 'civ' && $senderMode == 'Moov Money') {
        echo $moovNameCIV;
      } else if ($senderCountry == 'civ' && $senderMode == 'MTN') {
        echo $mtnNameCIV;
      } else if ($senderCountry == 'senegal' && $senderMode == 'Wave Money') {
        echo $waveNameSEN;
      } else if ($senderCountry == 'senegal' && $senderMode == 'Orange Money') {
        echo $omNameSEN;
      } else if ($senderCountry == 'mali' && $senderMode == 'Orange Money') {
        echo $omNameMAL;
      } else if ($senderCountry == 'benin' && $senderMode == 'MTN Money') {
        echo $mtnNameBEN;
      } else if ($senderCountry == 'congo' && $senderMode == 'MTN Money' || $senderMode == 'AIRTEL Money') {
        echo $nameBRAZAVILLE;
      } else if ($senderCountry == 'cameroun' && $senderMode == 'Orange Money') {
        echo $omNameCAMR;
      } else if ($senderCountry == 'russie' && $senderMode == 'Potchta Bank' || $senderMode == 'VTB') {
        echo $namePotchtaBank_VTB;
      } else if ($senderCountry == 'gabon' && $senderMode == 'AIRTEL Mobile Money') {
        echo $nameGAB;
      } else if ($senderCountry == 'togo' && $senderMode == 'Flooz') {
        echo $floozNameTOG;
      } else if ($senderCountry == 'togo' && $senderMode == 'TMONEY') {
        echo $tmoneyNameTOG;
      } else if ($senderCountry == 'burkina' && $senderMode == 'Orange Money') {
        echo $omNameBURK;
      } else if ($senderCountry == 'rdc' && $senderMode == 'Orange Money' || $senderMode == 'Mpesa' || $senderMode == 'Airtel') {
        echo $nameCONG;
      } else if ($senderCountry == 'russie' && $senderMode == 'SberBank') {
        echo $nameSberBank;
      } else if ($senderCountry == 'guinee' && $senderMode == 'Orange Money' || $senderMode == 'MTN areeba') {
        echo $nameGUI;
      } else if ($senderCountry == 'niger' && $senderMode == 'Orange Money') {
        echo $nameNIGER;
      }
    }
  ?>
</span>