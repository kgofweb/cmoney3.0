<?php
  include '../views/assets/css/global.php';
  include '../views/includes/formSend/formCss.php';
?>

<div class="row my-3">
  <!-- Strart Exchange -->
  <div class="col-sm-4 items mb-3">
    <div class="card mb-0">
      <div class="card-body">
        <div class="text-center">
          <i class="fa-solid fa-rotate icon__exchange"></i>
          <h5>ChapMoney - Exchange Rate</h5>
        </div>
        <!-- Exchange -->
        <section class="convertor">
          <!-- Sender -->
          <div class="convertor__box">
            <div class="convertor__box__informations">
              <div class="convertor__box__input">
                <input id="amout__one" type="number" class="form-control" value="1">
              </div>
              <div class="convertor__box__currency">
                <select id="list__one" class="form-select">
                  <option value="XOF">XOF</option>
                  <option value="XAF">XAF</option>
                  <option value="GNF">GNF</option>
                  <option value="RUB">RUB</option>
                </select>
              </div>
            </div>
          </div>
          <!-- Receiver -->
          <div class="convertor__box">
            <div class="convertor__box__informations">
              <div class="convertor__box__input">
                <input id="amout__two" type="text" class="form-control">
              </div>
              <div class="convertor__box__currency">
                <select id="list__two" class="form-select">
                  <option value="RUB">RUB</option>
                  <option value="XOF">XOF</option>
                  <option value="XAF">XAF</option>
                  <option value="GNF">GNF</option>
                </select>
              </div>
            </div>
          </div>
        </section>
        <div class="text-center currency__footer">Réceptions des fonds en <b>5 min</b> max</div>
      </div>
    </div>
  </div>
  <!-- End Exchange -->

  <div class="col-sm-8 items">
    <div class="card mb-4">
      <form class="form needs-validation" novalidate method="POST" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="hidden" class="d-none" name="token" value="<?php echo $token; ?>">

        <div class="progressbar">
          <div class="progress" id="progress"></div>
          <div class="progress-step progress-step-active" data-title="Expéditeur"></div>
          <div class="progress-step" data-title="Bénéficiaire"></div>
          <div class="progress-step" data-title="Montant"></div>
        </div>

        <!-- Steps -->
        <div class="form-step form-step-active">
          <!-- Country -->
          <div class="mb-3">
            <div class="description">
              <span>Pays</span>
            </div>
            <div class="content mb-2">
              <span class="icons">
                <i class="fa-solid fa-earth-americas"></i>
              </span>
              <div class="content__div__input w-100">
                <span id="draft"></span>
                <select class="form-select m-1 py-1 px-0 w-90" id="country__one" name="countryOne">
                  <option selected value=""></option>
                  <option data-mask="+7 (999) 999 99-99" value="russie">Russie</option>
                  <option data-mask="(+229) 99 99 99 99" value="benin">Bénin</option>
                  <option data-mask="(+226) 99 99 99 99" value="burkina">Burkina</option>
                  <option data-mask="(+237) 99 99 999 99" value="cameroun">Cameroun</option>
                  <option data-mask="(+225) 99 99 99 99 99" value="civ">Côte d'Ivoire</option>
                  <option data-mask="(+242) 99 999 99 99" value="congo">Congo Brazaville</option>
                  <option data-mask="(+241) 9 99 99 99 99" value="gabon">Gabon</option>
                  <option data-mask="(+224) 999 99 99 99" value="guinee">Guinée</option>
                  <option data-mask="(+243) 99 99 99 99" value="rdc">RD Congo</option>
                  <option data-mask="(+223) 99 99 99 99" value="mali">Mali</option>
                  <!-- <option data-mask="(+227) 99 99 99 99" value="niger">Niger</option> -->
                  <option data-mask="(+221) 99 999 99 99" value="senegal">Sénégal</option>
                  <option data-mask="(+228) 99 99 99 99" value="togo">Togo</option>
                </select>
              </div>
            </div>
          </div>
          <!-- Mobile Money -->
          <div>
            <div class="description">
              <span>Mode d'envoi</span>
            </div>
            <div class="content mb-2">
              <span class="icons">
                <i class="fa-solid fa-building-columns"></i>
              </span>
              <div class="content__div__input w-100">
                <select class="form-select my-1 py-1 px-0" name="sendMode" id="modeSend">
                  <option value=""></option>
                </select>
              </div>
            </div>
          </div>
          <!-- Phone -->
          <div class="mt-3 mb-4">
            <div class="mb-0">
              <div class="description">
                <span>Numéro de téléphone</span>
              </div>
              <div class="content mb-3">
                <span class="icons">
                  <i class="fa-solid fa-phone"></i>
                </span>
                <div class="content__div__input w-100">
                  <input type="text" name="numberPhoneOne" id="phoneNumber" class="form-control my-1 py-1 px-2 numberTel"
                    value="<?php if (isset($_SESSION['numberPhoneOne'])) {echo $_SESSION['numberPhoneOne'];} ?>" disabled>
                </div>
              </div>
            </div>
          </div>
          <div>
            <div class="btns-group">
              <a href="#" class="btn btn-next ml-auto">Suivant</a>
            </div>
          </div>
        </div>
        <div class="form-step">
          <!-- Receiver Name -->
          <div class="mt-2">
            <div class="mb-3">
              <div class="description">
                <span>Nom prénom</span>
              </div>
              <div class="content mb-2">
                <span class="icons">
                  <i class="fa-solid fa-user"></i>
                </span>
                <div class="content__div__input w-100">
                  <input type="text" name="receiver_name" id="receiver_name" class="form-control my-1 py-1 px-1" placeholder="Méné jean" value="<?php if (isset($_SESSION['receiver_name'])) {echo $_SESSION['receiver_name'];} ?>">
                </div>
              </div>
            </div>
          </div>
          <!-- Receiver Country -->
          <div class="mb-2">
            <div class="description">
              <span>Pays</span>
            </div>
            <div class="content mb-3">
              <span class="icons">
                <i class="fa-solid fa-earth-americas"></i>
              </span>
              <div class="content__div__input w-100">
                <span id="draft_two"></span>
                <select class="form-select m-1 py-1 px-0 w-90" id="country__two" name="countryTwo">
                  <option selected value=""></option>
                  <option data-mask="+7 (999) 999 99-99" value="russie">Russie</option>
                  <option data-mask="(+229) 99 99 99 99" value="benin">Bénin</option>
                  <option data-mask="(+226) 99 99 99 99" value="burkina">Burkina</option>
                  <!-- <option data-mask="(+236) 99 99 99 99" value="centreAfrique">Centrafrique</option> -->
                  <option data-mask="(+237) 99 99 999 99" value="cameroun">Cameroun</option>
                  <option data-mask="(+225) 99 99 99 99 99" value="civ">Côte d'Ivoire</option>
                  <option data-mask="(+242) 99 999 99 99" value="congo">Congo Brazaville</option>
                  <option data-mask="(+241) 9 99 99 99 99" value="gabon">Gabon</option>
                  <option data-mask="(+224) 999 99 99 99" value="guinee">Guinée</option>
                  <option data-mask="(+243) 99 99 99 99 99" value="rdc">RD Congo</option>
                  <option data-mask="(+223) 99 99 99 99" value="mali">Mali</option>
                  <!-- <option data-mask="(+227) 99 99 99 99" value="niger">Niger</option> -->
                  <option data-mask="(+221) 99 999 99 99" value="senegal">Sénégal</option>
                  <!-- <option data-mask="(+235) 99 99 99 99" value="tchad">Tchad</option> -->
                  <option data-mask="(+228) 99 99 99 99" value="togo">Togo</option>
                </select>
              </div>
            </div>
          </div>
          <!-- Receive Mode -->
          <div class="network mb-3">
            <div class="description">
              <span>Mode de retrait</span>
            </div>
            <div class="content mb-2">
              <span class="icons">
                <i class="fa-solid fa-building-columns"></i>
              </span>
              <div class="content__div__input w-100">
                <select class="form-select my-1 py-1 px-0" name="receiveMode" id="modeReceive">
                  <option value=""></option>
                </select>
              </div>
            </div>
          </div>
          <!-- Number Phone -->
          <div class="mb-0">
            <div class="description">
              <span>Numéro de téléphone</span>
            </div>
            <div class="content mb-4">
              <span class="icons">
                <i class="fa-solid fa-phone"></i>
              </span>
              <div class="content__div__input w-100">
                <input type="text" name="numberPhoneTwo" class="form-control numberTel__two my-1 py-1 px-2" id="phoneNumber__two" value="<?php if (isset($_SESSION['numberPhoneTwo'])) {echo $_SESSION['numberPhoneTwo'];} ?>" disabled>
              </div>
            </div>
          </div>
          <div class="btns-group">
            <a href="#" class="btn btn-prev">Retour</a>
            <a href="#" class="btn btn-next">Suivant</a>
          </div>
        </div>
        <div class="form-step">
          <div class="mb-2">
            <div class="description">
              <span>Montant</span>
            </div>
            <div class="content mb-2">
              <span class="icons">
                <i class="fa-solid fa-wallet"></i>
              </span>
              <div class="content__div__input w-100">
                <input type="number" min="1000" name="amount" id="amount" class="form-control my-1 py-1 px-2 fw-bold w-75"
                  value="<?php if (isset($_SESSION['amount'])) {echo $_SESSION['amount'];} ?>">
                <span style="margin-right: .5rem;" class="devise" id="devise"></span>
              </div>
            </div>
          </div>

          <div class="suggestion text-start">
            <span class="badge rounded-pill py-2 px-2">150000</span>
            <span class="badge rounded-pill py-2 px-2">200000</span>
            <span class="badge rounded-pill py-2 px-2">500000</span>
          </div>

          <div class="btns-group">
            <a href="#" class="btn btn-prev">Retour</a>
            <button name="transfert" class="btn">Transférer</button>
          </div>
        </div>
        <div class="mt-4 infos">
          Si votre pays ne figure pas dans la liste, priere <b><a href="../views/help.php" class="nav-link">contactez le service client</a></b>
        </div>
      </form>
    </div>
  </div>
  
</div>


<?php include '../views/includes/formSend/formJS.php'; ?>
<?php include '../views/includes/formSend/formConvertorJS.php'; ?>