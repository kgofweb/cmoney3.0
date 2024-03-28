<style>
  .container {
    display: grid;
  }
  .card {
    position: relative;
    place-self: center;
    border: none;
    border-radius: .6rem;
    width: 40%;
    margin: auto;
    margin-top: 1rem;
    border: 1px solid #ecf0f1;
  }
  .fa-bell {
    position: absolute;
    right: 1rem;
    font-size: 1.5rem;
    cursor: pointer;
  }
  .infos {
    font-size: .780rem;
  }
  input {
    border: none !important;
    background-color: #ecf0f1 !important;
    font-size: .900rem !important;
    font-weight: 700 !important;
    padding: .8rem !important;
  }
  input:focus {
    border: 2px solid #3742fa !important;
    background: none !important;
  }
  span {
    font-size: .900rem;
  }
  img {
    width: 10rem;
    height: 100%;
  }
  input::placeholder {
    font-size: .750rem !important;
    font-weight: 700;
  }
  @media screen and (max-width: 912px) {
    .card {
      width: 100%;
      margin: auto;
    }
  }
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
</style>