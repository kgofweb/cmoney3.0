<form method="POST" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  <input type="hidden" class="d-none" name="csrf_token_save" value="<?php echo $token; ?>">
  <!-- Bank -->
  <div class="mb-3">
    <div class="label">
      <i class="fa-solid fa-building-columns"></i>
      <span>Mode de retrait</span>
    </div>
    <div class="input__code mb-3">
      <select id="bank_field" name="bank_withdrawal" class="form-select fs-6 mt-1 mt-1 py-2 px-2 fw-bold">
        <option value="" selected></option>
        <option value="SberBank">SberBank</option>
        <option value="Tinkoff">Tinkoff</option>
        <option value="VTB">VTB</option>
        <option value="PotchtaBank">Potchta Bank</option>
        <option value="Autre">Autre</option>
      </select>
    </div>
  </div>
  <!-- Bank name -->
  <div id="comments_field" class="fields mb-3">
    <div class="label">
      <i class="fa-solid fa-building-columns"></i>
      <span>Nom de la banque</span>
    </div>
    <div class="input__code mb-3">
      <input name="bankUser_withdrawal" type="text" class="form-control mt-1 py-2 px-2 fw-bold">
    </div>
  </div>
  <!-- Name -->
  <div id="name_field" class="fields mb-3" >
    <div class="label">
      <i class="fa-solid fa-user"></i>
      <span>Votre nom</span>
    </div>
    <div class="input__code mb-3">
      <input name="name_withdrawal" type="text" class="form-control mt-1 py-2 px-2 fw-bold">
    </div>
  </div>
  <!-- Mobile phone -->
  <div id="number_phone_field" class="fields mb-3">
    <div class="label">
      <i class="fa-solid fa-phone"></i>
      <span>N téléphone</span>
    </div>
    <div class="input__code mb-3">
      <input type="text" class="form-control mt-1 py-2 px-2 fw-bold" data-mask="+7 (999) 999 99-99" id="number_phone_withdrawal" name="number_phone_withdrawal">
    </div>
  </div>
  <div class="space"></div>
  <!-- Amount -->
  <div class="mb-3" >
    <div class="label__money">
      <i class="fa-solid fa-sack-dollar"></i>
      <div class="principal-color">Montant à reçevoir</div>
    </div>
    <div class="mb-3">
      <div class="amount_receive mt-2">
        <?php
          if (isset($montant_rouble)) {
            echo number_format($montant_rouble, 2, ',', ' '). ' <i class="fa-solid fa-ruble-sign"></i>';
          }
        ?>
      </div>
    </div>
  </div>

  <div class="d-flex justify-content-end">
    <button name="cancel" class="btn btn-prev fw-bold mt-4 me-3">
      Annuler
    </button>
    <button name="data_withdrawal" class="btn fw-bold mt-4 ">
      Retrait
    </button>
  </div>
</form>