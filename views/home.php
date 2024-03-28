<?php require('../backend/security/security.php'); ?>

<!DOCTYPE html>
<html lang="fr">
<?php 
  include '../views/includes/homeHead.php';
  include '../views/assets/css/global.php';
  include '../views/assets/css/home.php'; 
?>
<style>
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
</style>
<body>
  <div class="container">
    <?php include '../views/includes/alerts/alert_index.php'; ?>
    
    <div class="content">
      <div class="content__div">
        <!-- =========== Logo =========== -->
        <?php include '../views/includes/logo/logo.php'; ?>
        <!-- =========== Description =========== -->
        <?php include '../views/includes/homeTitle/description.php'; ?>
        <!-- =========== Menu =========== -->
        <?php include '../views/includes/menu/menu.php'; ?>
      </div>
    </div>

    <div class="float-end">
      <button class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
        <i class="fa-solid fa-arrow-right-arrow-left"></i>
      </button>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">

            <div class="items mb-3">
              <div class="card mb-0">
                <div class="card-body">
                  <div class="text-center">
                    <i class="fa-solid fa-rotate icon__exchange"></i>
                    <h5>ChapMoney - Exchange Rate</h5>
                  </div>
                  <!-- Exchange -->
                  <section class="convertor">
                    <!-- Sender -->
                    <div class="convertor__box">
                      <div class="convertor__box__informations">
                        <div class="convertor__box__input">
                          <input id="amout__one" type="text" class="form-control" value="1">
                        </div>
                        <div class="convertor__box__currency">
                          <select id="list__one" class="form-select">
                            <option value="XOF">XOF</option>
                            <option value="XAF">XAF</option>
                            <option value="GNF">GNF</option>
                            <option value="RUB">RUB</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <!-- Receiver -->
                    <div class="convertor__box">
                      <div class="convertor__box__informations">
                        <div class="convertor__box__input">
                          <input id="amout__two" type="text" class="form-control">
                        </div>
                        <div class="convertor__box__currency">
                          <select id="list__two" class="form-select">
                            <option value="RUB">RUB</option>
                            <option value="XOF">XOF</option>
                            <option value="XAF">XAF</option>
                            <option value="GNF">GNF</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </section>
                  <div class="text-center currency__footer">Réceptions des fonds en <b>5 min</b> max</div>
                </div>
              </div>
            </div>

          </div>
          <div class="modal-footer">
            <button class="btn btn-sm" data-bs-dismiss="modal">Fermer</button>
          </div>
        </div>
      </div>
    </div>

  </div>
  <script src="../views/assets/js/scrollreveal.min.js"></script>
  <?php include '../views/assets/js/home.php'; ?>
  <?php include '../views/includes/formSend/formConvertorJS.php'; ?>
</body>
</html>