<?php include '../backend/src/rate.php'; ?>

<script>
  // DOM
  const first_select = document.getElementById('list__one');
  const second_select = document.getElementById('list__two');
  const amount_one = document.getElementById('amout__one')
  const amount_two = document.getElementById('amout__two')

  // Event Listener
  first_select.addEventListener('change', getFirstSelectValue);
  second_select.addEventListener('change', getSecondSelectValue);
  amount_one.addEventListener('input', convertor)

  // Rate
  let rateXOF = "<?php echo $civRussia; ?>";
  let rateXAF = "<?php echo $rateAC; ?>";
  let rateGNF_vers_RUB = "<?php echo $guineeVersRussie; ?>";
  let RUB_vers_XOF = "<?php echo $russiaCIV; ?>";
  let RUB_vers_XAF = "<?php echo $rateRubAc; ?>";
  let RUB_vers_GNF = "<?php echo $russieVersGuinee; ?>";
  let XOF_vers_GNF = "<?php echo $AO_AC_vers_Guinee; ?>";
  let GNF_vers_XOF = "<?php echo $guineeVersAO_AC; ?>";
  let rate = 1;

  let selectedValueOne;
  let selectedValueTwo;
  let amoutTypeByUserOne;

  function getFirstSelectValue() {
    // Get selected value
    selectedValueOne = first_select.value;

    convertor();
  }

  function getSecondSelectValue() {
    // Get selected value
    selectedValueTwo = second_select.value;

    convertor();
  }

  function convertor() {
    // Get input value
    amoutTypeByUserOne = amount_one.value;

    if (selectedValueOne == 'XOF' && selectedValueTwo == 'RUB') {
      const currency_result = new Intl.NumberFormat().format(amoutTypeByUserOne * rateXOF);
      amount_two.value = currency_result
    } else if (selectedValueOne == 'XAF' && selectedValueTwo == 'RUB') {
      const currency_result = new Intl.NumberFormat().format(amoutTypeByUserOne * rateXAF);
      amount_two.value = currency_result
    } else if (selectedValueOne == 'GNF' && selectedValueTwo == 'RUB') {
      const currency_result = new Intl.NumberFormat().format(amoutTypeByUserOne * rateGNF_vers_RUB);
      amount_two.value = currency_result
    } else if (selectedValueOne == 'XOF' && selectedValueTwo == 'XOF') {
      const currency_result = new Intl.NumberFormat().format(amoutTypeByUserOne * rate);
      amount_two.value = currency_result
    } 
    // Rubles vers XOF A de l'ouest
    else if (selectedValueOne == 'RUB' && selectedValueTwo == 'XOF') {
      const currency_result = new Intl.NumberFormat().format(amoutTypeByUserOne * RUB_vers_XOF);
      amount_two.value = currency_result
    }
    // Rubles vers XOF A Centrale
    else if (selectedValueOne == 'RUB' && selectedValueTwo == 'XAF') {
      const currency_result = new Intl.NumberFormat().format(amoutTypeByUserOne * RUB_vers_XAF);
      amount_two.value = currency_result
    }
    // Rubles vers GNF
    else if (selectedValueOne == 'RUB' && selectedValueTwo == 'GNF') {
      const currency_result = new Intl.NumberFormat().format(amoutTypeByUserOne * RUB_vers_GNF);
      amount_two.value = currency_result
    }
    // XOF vers GNF Guinee
    else if (selectedValueOne == 'XOF' && selectedValueTwo == 'GNF') {
      const currency_result = new Intl.NumberFormat().format(amoutTypeByUserOne * XOF_vers_GNF);
      amount_two.value = currency_result
    }
    // XAF vers GNF Guinee
    else if (selectedValueOne == 'XAF' && selectedValueTwo == 'GNF') {
      const currency_result = new Intl.NumberFormat().format(amoutTypeByUserOne * XOF_vers_GNF);
      amount_two.value = currency_result
    }
    else if (selectedValueOne == 'GNF' && selectedValueTwo == 'XOF') {
      const currency_result = new Intl.NumberFormat().format(amoutTypeByUserOne * GNF_vers_XOF);
      amount_two.value = currency_result
    }
    else if (selectedValueOne == 'GNF' && selectedValueTwo == 'XAF') {
      const currency_result = new Intl.NumberFormat().format(amoutTypeByUserOne * GNF_vers_XOF);
      amount_two.value = currency_result
    }
    else {
      amount_two.value = amoutTypeByUserOne
    }
  }

  // Call functions
  getFirstSelectValue();
  getSecondSelectValue();
</script>