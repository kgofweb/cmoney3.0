<style>
  .card {
    border: none;
    border-radius: .6rem;
    width: 42%;
    margin: auto;
    margin-top: 1rem;
  }
  .icon {
    text-align: center;
  }
  .validate__icon {
    color: #2ed573; 
    font-size: 3rem;
    text-align: center;
  }
  .cancel__icon {
    color: #e74c3c;
    font-size: 3rem;
  }
  .content {
    margin-top: 1rem;
  }
  .message {
    padding: .7rem 1rem;
    background-color: #eff5f7;
    border-radius: .7rem;
  }
  .message div {
    display: flex;
    align-items: center;
    justify-content: space-between;
  }
  .message div span:nth-child(2) {
    font-weight: bold;
    font-size: .900rem;
  }
  .message div span:nth-child(1) {
    margin-bottom: .5rem;
    color: #636e72;
    font-size: .900rem;
  }
  .montant, .montant__total {
    color: #2ed573;
  }
  .montant__total {
    font-size: 1.5rem;
  }
  .code {
    font-size: 1.2rem !important;
  }
  .fa-copy {
    margin-left: .3rem;
    cursor: pointer;
    font-size: 1rem;
  }
  .check__copy {
    font-size: 1.2rem; 
    margin-right: .3rem;
  }
  .space {
    border-bottom: 2px dashed #bdc3c7;
    width: 100%;
    margin: 1rem auto;
  }
  /* Start Loader */
  .load {
    display: grid;
    place-items: center;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: #e5eff1;
    z-index: 100;
  }
  .load__gif {
    width: 150px;
    height: 150px;
  }
  /* End Loader */
  @media screen and (max-width: 912px) {
    .card {
      width: 100%;
      margin: auto;
    }
  }
</style>