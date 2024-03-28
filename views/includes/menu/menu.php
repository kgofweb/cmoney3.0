<?php include '../views/assets/css/menu.php'; ?>

<div class="cards justify-content-center mt-4">
  <div class="row row-cols-2 justify-content-center">
    <!-- ============ Envoi ============ -->
    <div class="col">
      <div class="card send mb-3">
        <div class="card-body">
          <h6 class="text-start">
            <i class="icon fas fa-exchange-alt"></i>
            <b>Transaction</b>
          </h6>
          <div>
            <img src="../views/assets/img/transfert-money.jpg" alt="ChapMoney Online">
          </div>
          <a href="./send" class="btn float-end">
            <i class="fa-solid fa-angle-right"></i>
          </a>
        </div>
      </div>
    </div>
    <!-- ============ Assistance ============ -->
    <div class="col">
      <div class="card receive mb-3">
        <div class="card-body">
          <h6 class="text-start">
            <i class="fa-solid fa-headphones-simple"></i>
            <b>Assistance</b>
          </h6>
          <div>
            <img src="../views/assets/img/assis.jpg" alt="ChapMoney Online">
          </div>
          <a href="./help" class="btn float-end">
            <i class="fa-solid fa-angle-right"></i>
          </a>
        </div>
      </div>
    </div>
    <!-- ============ Tracker ============ -->
    <div class="col">
      <div class="card tracker mb-3">
        <div class="card-body follow">
          <h6 class="text-start">
            <b>Suivi</b>
          </h6>
          <a href="./tracker" class="btn float-end">
            <i class="fa-solid fa-angle-right"></i>
          </a>
        </div>
      </div>
    </div>
    <!-- ============ Help ============ -->
    <div class="col">
      <div class="card helps mb-3">
        <div class="card-body help">
          <h6 class="text-start">
            <b>Passport</b>
          </h6>
          <a href="./timbrePassport" class="btn float-end">
            <i class="fa-solid fa-angle-right"></i>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>