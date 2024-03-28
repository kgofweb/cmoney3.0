<style> 
  :root {
    --primary-color: rgb(11, 78, 179);
  }
  .form-select,
  input {
    color: #0E2F56;
    border: none !important;
    background-color: #ecf0f1 !important;
  }
  .width-50 {
    width: 50%;
  }
  .ml-auto {
    margin-left: auto;
  }
  .text-center {
    text-align: center;
  }
  /* Progressbar */
  .progressbar {
    position: relative;
    display: flex;
    justify-content: space-between;
    counter-reset: step;
    margin: .3rem 0 4rem;
  }
  .progressbar::before,
  .progress {
    content: "";
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    height: 8px;
    width: 100%;
    background-color: #dcdcdc !important;
  }
  .progress {
    background-color: var(--primary-color) !important;
    width: 0%;
    transition: 0.3s;
  }

  .progress-step {
    width: 2.800rem;
    height: 2.800rem;
    background-color: #dcdcdc !important;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 10;
  }

  .progress-step::before {
    counter-increment: step;
    content: counter(step);
    z-index: 10;
  }

  .progress-step::after {
    content: attr(data-title);
    position: absolute;
    top: calc(100% + 0.5rem);
    font-size: 0.85rem;
    color: #0E2F56;
    font-weight: bold;
  }
  .progress-step-active {
    background-color: var(--primary-color) !important;
    color: #f3f3f3 !important;
    font-weight: bold;
  }
  /* Form */
  .form {
    width: clamp(480px, 30%, 430px);
    background-color: #fff;
    margin: auto;
    border-radius: 0.7rem;
    padding: 1.5rem;
  }
  @media screen and (max-width: 768px) {
    .form {
      width: 100% !important;
    }
  }
  .form-step {
    display: none;
    transform-origin: top;
    animation: animate 0.5s;
  }
  .form-step-active {
    display: block;
  }
  @keyframes animate {
    from {
      transform: scale(1, 0);
      opacity: 0;
    }
    to {
      transform: scale(1, 1);
      opacity: 1;
    }
  }
  /* Button */
  .btns-group {
    display: flex;
    align-items: center;
    justify-content: space-between;
  }
  .btn:hover {
    box-shadow: 0 0 0 2px #fff, 0 0 0 3px var(--primary-color) !important;
  }
  .btn-prev {
    background-color: #d3e6ed;
    color: #3742fa;
  }
  /* ======================================= */
  .description {
    display: flex;
    align-items: center;
    justify-content: flex-start;
  }
  .description span {
    font-weight: bold;
    font-size: .794rem;
    color: #0E2F56;
    margin-left: 2rem;
  }
  .content,
  .content__div__input {
    display: flex;
    align-items: center;
    justify-content: space-between;
  }
  .content__div__input {
    margin-left: .7rem !important;
    border: none;
    background-color: #ecf0f1;
    border-radius: .5rem;
  }
  .content__div__input span {
    margin-left: .4rem;
    margin-right: .4rem;
    font-size: .5rem;
  }
  .content__div__input, .form-select {
    margin-left: .5rem;
  }
  .icons {
    display: flex;
    align-items: center;
    font-weight: bold;
  }
  .icons i {
    font-size: 1.1rem;
    color: #0E2F56;
  }
  .precision {
    margin-left: 2.3rem; 
    font-size: .800rem; 
    color: #27ae60;
    font-weight: bold;
  }
  .suggestion {
    margin-left: 2rem;
    margin-bottom: 2rem;
  }
  .suggestion span {
    color: #3742fa;
    background-color: #D8E9F0;
    cursor: pointer;
  }
  .form-control {
    color: #0E2F56 !important;
  }
  .devise {
    font-size: 1rem !important;
  }
  .infos {
    font-size: .780rem;
  }
  .card {
    border: none;
    border-radius: .8rem;
  }
  .subtitle {
    font-size: .850rem;
    color: #95a5a6;
  }
  .icon__exchange {
    font-size: 1.2rem;
    color: #3742fa;
  }
  /* ========= Start Convertor ========= */
  .convertor {
    margin-top: 1rem;
  }
  .convertor__box {
    padding: .6rem 0;
    border-radius: .8rem;
  }
  .convertor__box__currency > .form-select {
    margin-left: 0 !important;
  }
  .convertor__box__informations {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background-color: #ecf0f1;
    border-radius: .8rem;
    padding: .3rem;
  }
  .convertor__box__informations input,
  .convertor__box__currency select {
    padding: .65rem;
    border-radius: .6rem;
    cursor: pointer;
  }
  .convertor__box__input {
    width: 65%;
  }
  .convertor__box__currency {
    width: 32%;
  }
  .convertor__box__currency select {
    font-weight: bold;
    background-color: #0E2F56 !important;
    color: #fff;
    border-radius: .8rem;
  }
  .currency__footer {
    font-size: .700rem;
    color: #95a5a6;
  }
  /* ========= End Convertor ========= */
  @media screen and (max-width: 912px) {
    .row {
      flex-direction: column !important;
    }
    .items {
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
    outline: none;
    box-shadow: none !important;
  }
</style>