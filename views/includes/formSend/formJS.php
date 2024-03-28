<script>
  window.onload = (event) => {
    let myToast = document.querySelector('.toast')
    let alertToast = new bootstrap.Toast(myToast)
    alertToast.show()
  }
  
  const suges = document.querySelectorAll('.badge');
  suges.forEach(sugs => {
    sugs.addEventListener('click', () => {
      const content = sugs.textContent;
      amount.value = content;
    });
  });

  const nextBtns = document.querySelectorAll(".btn-next");
  const prevBtns = document.querySelectorAll(".btn-prev");
  const progress = document.getElementById("progress");
  const formSteps = document.querySelectorAll(".form-step");
  const progressSteps = document.querySelectorAll(".progress-step");

  let formStepsNum = 0;

  nextBtns.forEach((btn) => {
    btn.addEventListener("click", () => {
      formStepsNum++;
      updateFormSteps();
      updateProgressbar();
    });
  });

  prevBtns.forEach((btn) => {
    btn.addEventListener("click", () => {
      formStepsNum--;
      updateFormSteps();
      updateProgressbar();
    });
  });

  function updateFormSteps() {
    formSteps.forEach((formStep) => {
      formStep.classList.contains("form-step-active") && formStep.classList.remove("form-step-active");
    });

    formSteps[formStepsNum].classList.add("form-step-active");
  }

  function updateProgressbar() {
    progressSteps.forEach((progressStep, idx) => {
      if (idx < formStepsNum + 1) {
        progressStep.classList.add("progress-step-active");
      } else {
        progressStep.classList.remove("progress-step-active");
      }
    });

    const progressActive = document.querySelectorAll(".progress-step-active");

    progress.style.width =
      ((progressActive.length - 1) / (progressSteps.length - 1)) * 100 + "%";
  }

  const modeTransfert = {
    russie: ['SberBank', 'Potchta Bank', 'VTB'],
    civ: ['Orange Money', 'Moov Money', 'Wave Money', 'MTN'],
    senegal: ['Orange Money', 'Wave Money'],
    guinee: ['Orange Money', 'MTN areeba'],
    mali: ['Orange Money'],
    congo: ['MTN Money'],
    benin: ['MTN Money'],
    burkina: ['Orange Money'],
    cameroun: ['Orange Money'],
    gabon: ['AIRTEL Mobile Money'],
    rdc: ['Orange Money', 'Mpesa', 'Airtel'],
    togo: ['Flooz'],
    niger: ['Orange Money']
  }
  const receiveModeOnlyAfrique = {
    russie: ['ChapMoney Online'],
    civ: ['Orange Money', 'Moov Money', 'Wave Money', 'MTN'],
    senegal: ['Wave Money'],
    russie: ['-- chapmoney online --'],
    civ: ['Orange Money', 'Moov Money', 'Wave Money', 'MTN'],
    senegal: ['Orange Money', 'Wave Money'],
    guinee: ['Orange Money', 'MTN areeba'],
    mali: ['Orange Money'],
    congo: ['MTN Money'],
    benin: ['MTN Money'],
    burkina: ['Orange Money'],
    cameroun: ['Orange Money'],
    gabon: ['AIRTEL Mobile Money'],
    togo: ['Flooz'],
    tchad: ['Airtel', 'Moov'],
    rdc: ['Orange Money', 'Mpesa', 'Airtel'],
    centreAfrique: ['Orange Money'],
    niger: ['Orange Money']
  }

  // id on select tag
  const countryOne = document.getElementById('country__one')
  // id on select tag
  const countryTwo = document.getElementById('country__two')
  const mode = document.getElementById('modeSend')
  const modeReceive = document.getElementById('modeReceive')
  // Amount
  const amount = document.getElementById('amount')
  // Phone Number
  const phoneOne = document.getElementById('phoneNumber')
  const phoneTwo = document.getElementById('phoneNumber__two')
  const receiverMode = document.querySelector('.network')

  // Event Listener
  countryOne.addEventListener('change', chooseSendMode)
  countryTwo.addEventListener('change', chooseModeReceive)

  function chooseSendMode() {
    // Select Value
    let selectOption = modeTransfert[this.value]
    // Remove old selection
    while (mode.options.length > 0) {
      mode.options.remove(0)
    }
    // From transfert mode table
    Array.from(selectOption).forEach(function (el) {
      let option = new Option(el, el)
      // Append child
      mode.appendChild(option)
      // Phone Number iMask
      $(".numberTel").inputmask($('#country__one').find(':selected').data('mask'));
      
      phoneOne.disabled = false
    })
    
    // Devise
    if (countryOne.value == 'civ' || countryOne.value == 'benin' || countryOne.value == 'burkina' || countryOne.value == 'mali' || countryOne.value == 'senegal' || countryOne.value == 'gabon' || countryOne.value == 'cameroun' || countryOne.value == 'congo' || countryOne.value == 'togo' || countryOne.value == 'niger') {
      document.getElementById('devise').innerHTML = '<span class="fw-bold" style="font-size: .850rem">FCFA</span>';
    } else if (countryOne.value == 'rdc') {
      document.getElementById('devise').innerHTML = '<i class="fa-solid fa-dollar-sign"></i>';
    } else if (countryOne.value == 'guinee') {
      document.getElementById('devise').innerHTML = '<span class="fw-bold" style="font-size: .850rem">GNF</span>';
    } else {
      document.getElementById('devise').innerHTML = '<i class="fa-solid fa-ruble-sign"></i>';
    } 

    switch (countryOne.value) {
      case 'russie':
        document.getElementById('draft').innerHTML = '<img src="https://flagcdn.com/20x15/ru.png" alt="ChapMoney Online">'
        break;
      case 'civ':
        document.getElementById('draft').innerHTML = '<img src="https://flagcdn.com/20x15/ci.png" alt="ChapMoney Online">'
        break;
      case 'benin':
        document.getElementById('draft').innerHTML = '<img src="https://flagcdn.com/20x15/bj.png" alt="ChapMoney Online">'
        break;
      case 'burkina':
        document.getElementById('draft').innerHTML = '<img src="https://flagcdn.com/20x15/bf.png" alt="ChapMoney Online">'
        break;
      case 'cameroun':
        document.getElementById('draft').innerHTML = '<img src="https://flagcdn.com/20x15/cm.png" alt="ChapMoney Online">'
        break;
      case 'congo':
        document.getElementById('draft').innerHTML = '<img src="https://flagcdn.com/20x15/cg.png" alt="ChapMoney Online">'
        break;
      case 'gabon':
        document.getElementById('draft').innerHTML = '<img src="https://flagcdn.com/20x15/ga.png" alt="ChapMoney Online">'
        break;
      case 'mali':
        document.getElementById('draft').innerHTML = '<img src="https://flagcdn.com/20x15/ml.png" alt="ChapMoney Online">'
        break;
      case 'senegal':
        document.getElementById('draft').innerHTML = '<img src="https://flagcdn.com/20x15/sn.png" alt="ChapMoney Online">'
        break;
      case 'togo':
        document.getElementById('draft').innerHTML = '<img src="https://flagcdn.com/20x15/tg.png" alt="ChapMoney Online">'
        break;
      case 'guinee':
        document.getElementById('draft').innerHTML = '<img src="https://flagcdn.com/20x15/gn.png" alt="ChapMoney Online">'
        break;
      case 'rdc':
        document.getElementById('draft').innerHTML = '<img src="https://flagcdn.com/20x15/cd.png" alt="ChapMoney Online">'
        break;
      case 'niger':
        document.getElementById('draft').innerHTML = '<img src="https://flagcdn.com/20x15/ne.png" alt="ChapMoney Online">'
        break;
    
      default:
        break;
    }
  }

  function chooseModeReceive() {
    // Select Value
    let selectReceiveOption = receiveModeOnlyAfrique[this.value]
    // Remove old selection
    while (modeReceive.options.length > 0) {
      modeReceive.options.remove(0)
    }
    // From transfert mode table
    Array.from(selectReceiveOption).forEach(function (el) {
      let option = new Option(el, el)
      // Append child
      modeReceive.appendChild(option)
      // Phone Number iMask
      $(".numberTel__two").inputmask($('#country__two').find(':selected').data('mask'));

      phoneTwo.disabled = false;
    })

    switch (countryTwo.value) {
      case 'russie':
        document.getElementById('draft_two').innerHTML = '<img src="https://flagcdn.com/20x15/ru.png" alt="ChapMoney Online">'
        break;
      case 'civ':
        document.getElementById('draft_two').innerHTML = '<img src="https://flagcdn.com/20x15/ci.png" alt="ChapMoney Online">'
        break;
      case 'benin':
        document.getElementById('draft_two').innerHTML = '<img src="https://flagcdn.com/20x15/bj.png" alt="ChapMoney Online">'
        break;
      case 'burkina':
        document.getElementById('draft_two').innerHTML = '<img src="https://flagcdn.com/20x15/bf.png" alt="ChapMoney Online">'
        break;
      case 'cameroun':
        document.getElementById('draft_two').innerHTML = '<img src="https://flagcdn.com/20x15/cm.png" alt="ChapMoney Online">'
        break;
      case 'congo':
        document.getElementById('draft_two').innerHTML = '<img src="https://flagcdn.com/20x15/cg.png" alt="ChapMoney Online">'
        break;
      case 'gabon':
        document.getElementById('draft_two').innerHTML = '<img src="https://flagcdn.com/20x15/ga.png" alt="ChapMoney Online">'
        break;
      case 'mali':
        document.getElementById('draft_two').innerHTML = '<img src="https://flagcdn.com/20x15/ml.png" alt="ChapMoney Online">'
        break;
      case 'senegal':
        document.getElementById('draft_two').innerHTML = '<img src="https://flagcdn.com/20x15/sn.png" alt="ChapMoney Online">'
        break;
      case 'togo':
        document.getElementById('draft_two').innerHTML = '<img src="https://flagcdn.com/20x15/tg.png" alt="ChapMoney Online">'
        break;
      case 'tchad':
        document.getElementById('draft_two').innerHTML = '<img src="https://flagcdn.com/20x15/ro.png" alt="ChapMoney Online">'
        break;
      case 'centreAfrique':
        document.getElementById('draft_two').innerHTML = '<img src="https://flagcdn.com/20x15/cf.png" alt="ChapMoney Online">'
        break;
      case 'guinee':
        document.getElementById('draft_two').innerHTML = '<img src="https://flagcdn.com/20x15/gn.png" alt="ChapMoney Online">'
        break;
      case 'rdc':
        document.getElementById('draft_two').innerHTML = '<img src="https://flagcdn.com/20x15/cd.png" alt="ChapMoney Online">'
        break;
      case 'niger':
        document.getElementById('draft_two').innerHTML = '<img src="https://flagcdn.com/20x15/ne.png" alt="ChapMoney Online">'
        break;
    
      default:
        break;
    }
  }
</script>