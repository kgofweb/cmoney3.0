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
    outline:0px !important;
    box-shadow: none !important;
  }
  .card {
    border: none;
    border-radius: .6rem;
    width: 45%;
    margin: auto;
    margin-top: 1rem;
  }
  .content {
    display: flex;
    align-items: center;
  }
  .country {
    border-bottom: 2px dotted #bdc3c7;
    font-weight: bold;
    text-align: start;
    width: 100%;
    font-size: .900rem;
    margin-left: 2rem;
  }
  .icons {
    font-size: 1rem; 
    color: #95a5a6;
  }
  .sender, .receiver, .amount {
    background-color: #eff5f7;
    padding: .5rem 1rem;
    border-radius: .7rem;
  }
  .btn-prev {
    background-color: #d3e6ed;
    color: #3742fa;
  }
  .validate__icon {
    color: #2ed573; 
    font-size: 4rem;
  }
  .cancel__icon {
    color: #e74c3c;
    font-size: 4rem;
  }
  .money__get {
    color: #2ed573;
  }
  .montant {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    grid-gap: 1rem;
  }
  .montant h6, div {
    font-size: .900rem;
  }
  .gains i {
    color: #2ed573;
  }
  .gains .icons {
    font-size: 1.5rem;
    margin-top: .400rem;
  }
  .gains .money {
    font-size: 1.3rem;
  }
  .accordion-button {
    background: none !important;
  }
  @media screen and (max-width: 912px) {
    .card {
      width: 100%;
      margin: auto;
    }
    .montant {
      display: flex;
      flex-direction: column;
      grid-gap: 1px;
      font-size: 1rem !important;
    }
  }
</style>