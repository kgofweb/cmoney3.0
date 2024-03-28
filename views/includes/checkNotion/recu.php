<?php include '../views/includes/checkNotion/recuCss.php'; ?>

<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-scrollable">
  <div class="modal-content">
    <div class="modal-body">
      <main class="checkNotion" id="checkNotion">
        <div class="img">
          <img src="../views/assets/img/logo/logo-img.png" alt="ChapMoney Online">
        </div>
        <div class="container">
          <div class="my-2">
            <div class="date">Date: <span class="fw-bold"><?= $date ?></span></div>
            <div class="hours">Heure: <span class="fw-bold"><?= $time ?></span></div>
          </div>
          <div class="code-retrait mb-3">
            <?php
              if (isset($receiverCountry)) {
                if($receiverCountry == 'russie') {
                  ?>
                    Code de retrait: <span class="text-primary fw-bold fs-5"><?= $verify_code ?></span>
                  <?php
                } else {
                  ?>
                    Code de suivi: <span class="text-primary fw-bold fs-5"><?= $verify_code ?></span>
                  <?php
                }
              }
            ?>
          </div>
          <div class="space"></div>
          <div class="sender mb-4">
            <h6 class="d-flex align-items-center">
              <i class="fa-solid fa-circle-exclamation"></i>
              Expéditeur
            </h6>
            <div class="">
              <span class="d-flex align-items-center mb-2">
                Pays: 
                <span class="fw-bold mx-2">
                  <?php 
                    if (isset($senderCountry)) {
                      if ($senderCountry == 'russie') {
                        echo "Russie";
                      } else if ($senderCountry == 'civ') {
                        echo "Cote d'Ivoire";
                      } else if ($senderCountry == 'mali') {
                        echo "Mali";
                      } else if ($senderCountry == 'cameroun') {
                        echo "Cameroun";
                      } else if ($senderCountry == 'gabon') {
                        echo "Gabon";
                      } else if ($senderCountry == 'congo') {
                        echo "Congo Brazaville";
                      } else if ($senderCountry == 'senegal') {
                        echo "Sénégal";
                      } else if ($senderCountry == 'benin') {
                        echo "Bénin";
                      } else if ($senderCountry == 'togo') {
                        echo "Togo";
                      } else if ($senderCountry == 'burkina') {
                        echo "Burkina";
                      } else if ($senderCountry == 'tchad') {
                        echo "Tchad";
                      } else if ($senderCountry == 'centreAfrique') {
                        echo "Centre Afrique";
                      } else if ($senderCountry == 'guinee') {
                        echo "Guinée";
                      } else if ($senderCountry == 'rdc') {
                        echo "RD Congo";
                      } else if ($senderCountry == 'niger') {
                      echo "Niger";
                      }
                    } 
                  ?>
                </span>
              </span>
              <span class="d-flex align-items-center mb-2">
                Mode: <span class="fw-bold mx-2"><?= $senderMode ?></span>
              </span>
              <span class="d-flex align-items-center mb-2">
                Téléphone: <span class="fw-bold mx-2"><?= $senderPhone ?></span>
              </span>
            </div>
          </div>
          <div class="space"></div>
          <div class="receiver mb-4">
            <h6 class="d-flex align-items-center">
              <i class="fa-solid fa-circle-exclamation"></i>
              Bénéficiaire
            </h6>
            <div class="">
              <span class="d-flex align-items-center mb-2">
                Nom: <span class="fw-bold mx-2">
                  <?php
                    if (isset($receiverName)) {
                      echo $receiverName;
                    }
                  ?>
                </span>
              </span>
              <span class="d-flex align-items-center mb-2">
                Pays: <span class="fw-bold mx-2">
                <?php 
                  if (isset($receiverCountry)) {
                    if ($receiverCountry == 'russie') {
                      echo "Russie";
                    } else if ($receiverCountry == 'civ') {
                      echo "Cote d'Ivoire";
                    } else if ($receiverCountry == 'mali') {
                      echo "Mali";
                    } else if ($receiverCountry == 'cameroun') {
                      echo "Cameroun";
                    } else if ($receiverCountry == 'gabon') {
                      echo "Gabon";
                    } else if ($receiverCountry == 'congo') {
                      echo "Congo Brazaville";
                    } else if ($receiverCountry == 'senegal') {
                      echo "Sénégal";
                    } else if ($receiverCountry == 'benin') {
                      echo "Bénin";
                    } else if ($receiverCountry == 'togo') {
                      echo "Togo";
                    } else if ($receiverCountry == 'burkina') {
                      echo "Burkina";
                    } else if ($receiverCountry == 'tchad') {
                      echo "Tchad";
                    } else if ($receiverCountry == 'centreAfrique') {
                      echo "Centre Afrique";
                    } else if ($receiverCountry == 'guinee') {
                      echo "Guinée";
                    } else if ($receiverCountry == 'rdc') {
                      echo "RD Congo";
                    } else if ($receiverCountry == 'niger') {
                      echo "Niger";
                    }
                  }
                ?>
                </span>
              </span>
              <?php
                if (isset($receiverCountry)) {
                  if ($receiverCountry == 'russie') {
                  } else {
                    ?>
                      <span class="d-flex align-items-center mb-2">
                        Mode: <span class="fw-bold mx-2"><?= $receiverMode;?></span>
                      </span>
                    <?php
                  }
                }
              ?>
              <?php
                if (isset($senderCountry)) {
                  if ($senderCountry == 'russie') {
                    ?>
                      <span class="d-flex align-items-center mb-2">
                        Téléphone: <span class="fw-bold mx-2"><?= $receiverPhone ?></span>
                      </span>
                    <?php
                  }
                }
              ?>
            </div>
          </div>
          <div class="space"></div>
          <div class="amount ">
            <h6 class="d-flex align-items-center">
              <i class="fa-solid fa-circle-exclamation"></i>
              Montant
            </h6>
            <div class="">
              <span class="d-flex align-items-center mb-2">
                Montant:
                <span class="fw-bold mx-2">
                  <?php if (isset($amount)) {
                    echo number_format($amount, 2, ',', ' '). ' '. $change;
                  } ?>
                </span>
              </span>
            </div>
          </div>
          <div class="text-center mt-3">Nous sommes la référence</div>
        </div>
      </main>
    </div>
    <!-- Buttons Actions -->
    <div class="d-flex justify-content-center my-3">
      <button class="btn fw-bold btn-prev" data-bs-dismiss="modal">Fermer</button>
      <!-- Download PDF -->
      <button id="download-pdf" class="btn fw-bold">Télécharger</button>
    </div>
  </div>
</div>
</div>