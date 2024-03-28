<div class="accordion accordion-flush" id="accordionFlushExample">
  <div class="accordion-item">
    <h2 class="" id="flush-headingOne">
      <button class="accordion-button collapsed mb-0" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
        <h6>Expéditeur</h6>
      </button>
    </h2>
    <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
    <div class="sender mb-2">
      <div class="content mb-3">
        <i class="fa-solid fa-earth-americas icons"></i>
        <span class="country">
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
      </div>
      <div class="content mb-3">
        <i class="fa-solid fa-building-columns icons"></i>
        <span class="country">
          <?php 
            if (isset($senderMode)) {
              echo $senderMode;
            }
          ?>
        </span>
      </div>
      <div class="content mb-3">
        <i class="fa-solid fa-phone icons"></i>
        <span class="country">
          <?php
            if (isset($senderPhone)) {
              echo $senderPhone;
            }
          ?>
        </span>
      </div>
      <div class="content mb-3">
        <i class="fa-solid fa-sack-dollar icons"></i>
        <span class="country">
          <?php 
            if (isset($amount)) {
              echo number_format($amount, 2, ',', ' '). ' '. $change;
            }
          ?>
        </span>
      </div>
    </div>
    </div>
  </div>
  <!-- =========== Bénéficiaire =========== -->
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingTwo">
      <button class="accordion-button mb-0" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
        <h6>Bénéficiaire</h6>
      </button>
    </h2>
    <div id="flush-collapseTwo" class="accordion-collapse collapse show mt-2" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
      <div>
        <div class="receiver mb-2">
          <div class="content mb-3">
            <i class="fa-solid fa-user icons"></i>
            <span class="country">
              <?php 
                if (isset($receiverName)) {
                  echo $receiverName;
                }
              ?>
            </span>
          </div>
          <div class="content mb-3">
            <i class="fa-solid fa-earth-americas icons"></i>
            <span class="country">
              <?php 
                if (isset($receiverCountry)) {
                  if ($receiverCountry == 'russie') {
                    echo "Russie";
                  } else if ($receiverCountry == 'civ') {
                    echo "Côte d'Ivoire";
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
                  } else if ($receiverCountry == 'centreAfrique') {
                    echo "Centre Afrique";
                  } else if ($receiverCountry == 'tchad') {
                    echo "Tchad";
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
          </div>
          <?php
            if (isset($receiverCountry)) {
              if ($receiverCountry == 'russie') {} else {
                ?>
                  <div class="content mb-3">
                    <i class="fa-solid fa-building-columns icons"></i>
                    <span class="country">
                      <?php 
                        if (isset($receiverMode)) {
                          echo $receiverMode;
                        }
                      ?>
                    </span>
                  </div>
                <?php
              }
            }
          ?>
          <div class="content mb-3">
            <i class="fa-solid fa-phone icons"></i>
            <span class="country">
              <?php 
                if (isset($receiverPhone)) {
                  echo $receiverPhone;
                }
              ?>
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="gains">
    <i class="fa-solid fa-sack-dollar icons mt-3"></i>
    <h6 class="mt-1">Bénéficiaire</h6>
    <span class="money fw-bold" style="color: #2ed573;">
      <?= $finalAmount; ?>
    </span>
    <div>
      Frais de transaction: 
      <b class="money__get">
        <?= '+ '. number_format($percentage, 2, ',', ' '). ' '. $change ?>
      </b> <br>
      (Frais Opérateur)
    </div>
  </div>
</div>