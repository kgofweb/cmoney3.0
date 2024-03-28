<style>
  textarea:hover,
  input:hover,
  textarea:active,
  input:active,
  textarea:focus,
  input:focus,
  button:focus,
  button:active,
  button:hover,
  label:focus,
  select:focus,
  .btn:active,
  .btn.active {
    outline: none;
    box-shadow: none !important;
  }
  .card {
    border: none;
    border-radius: .6rem;
    width: 40%;
    margin: auto;
    margin-top: 1rem;
    padding: .800rem;
  }
  .label {
    display: flex;
    align-items: center;
  }
  .label span {
    font-size: .894rem;
    font-weight: bold;
    margin-left: .5rem;
  }
  .label i {
    font-size: 1rem;
    font-weight: bold;
  }
  .label__money {
    text-align: center;
  }
  .label__money i {
    font-size: 2rem;
    color: #2ed573;
  }
  .label__money div {
    font-size: .800rem;
  }
  input, select {
    background-color: #ecf0f1 !important;
    border: none !important;
  }
  .fields {
    display: none;
  }
  .validate__icon {
    color: #2ed573; 
    font-size: .9rem;
    text-align: center;
  }
  .amount_receive {
    color: #2ed573;
    text-align: center;
    font-size: 1.5rem;
    font-weight: bold;
    background: none !important;
  }
  .space {
    border-bottom: 2px dashed #bdc3c7;
    width: 100%;
    margin: 1.5rem auto;
  }
  @media screen and (max-width: 540px) {
    .card {
      width: 70% !important;
    }
  }
  @media screen and (max-width: 920px) {
    .card {
      width: 70% !important;
    }
  }
  @media screen and (max-width: 500px) {
    .card {
      width: 100% !important;
    }
  }
</style>