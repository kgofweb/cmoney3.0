<form method="POST" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  <input type="hidden" class="d-none" name="csrf_token" value="<?php echo $token; ?>">
  <div class="label">
    <i class="fa-solid fa-barcode icon"></i>
    <span>Votre code de retrait</span>
  </div>
  <div class="input__code mb-3">
    <div class="d-flex flex-row mt-2">
      <input name="otp1" type="text" id="txt1" maxlength="1" class="form-control fs-5 me-2 otpInput" onkeyup="move(event, '', 'txt1', 'txt2')">
      <input name="otp2" type="text" id="txt2" maxlength="1" class="form-control fs-5 mx-2 otpInput" onkeyup="move(event, 'txt1', 'txt2', 'txt3')">
      <input name="otp3" type="text" id="txt3" maxlength="1" class="form-control fs-5 mx-2 otpInput" onkeyup="move(event, 'txt2', 'txt3', 'txt4')">
      <input name="otp4" type="text" id="txt4" maxlength="1" class="form-control fs-5 mx-2 otpInput" onkeyup="move(event, 'txt3', 'txt4', 'txt5')">
      <input name="otp5" type="text" id="txt5" maxlength="1" class="form-control fs-5 otpInput"  onkeyup="move(event, 'txt4', 'txt5', '')">
    </div>
  </div>
  <!-- Phone number -->
  <div class="mt-4">
    <div class="mb-3">
      <div class="label">
        <i class="fa-solid fa-phone icon"></i>
        <span>Votre numéro de téléphone</span>
      </div>
      <div class="input__code mb-3">
        <input data-mask="+7 (999) 999 99-99" id="phone_number" name="phoneNumber" type="text" class="form-control mt-1 py-2 px-2 fw-bold">
      </div>
    </div>
  </div>

  <button name="verify_otp" class="btn w-100 fw-bold mt-3">Continuer</button>
</form>