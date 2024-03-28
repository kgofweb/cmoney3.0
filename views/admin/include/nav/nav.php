<style>
  img {
    width: 5rem; 
    height: 100%;
  }
  .btn {
    padding: .5rem .8rem;
  }
</style>

<nav class="navbar">
  <div class="container">
    <a class="navbar-brand fw-bold" style="color: #fff;" href="./dashboard">AdminPanel</a>
    <button class="navbar-toggler" style="background-color: #fff !important;" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
      <div class="offcanvas-header">
        <a class="navbar-brand" href="./dashboard">
          <img src="../../views/assets/img/logo/logo-img.png" alt="ChapMoney Online">
        </a>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <ul class="navbar-nav">
          <?php
            if (isset($_SESSION['role_admin'])) {
              if ($_SESSION['role_admin'] == 0) {};
            } else if (isset($_SESSION['account_type']) && isset($_SESSION['user_admin'])) {
              ?>
                <li class="nav-item text-dark fw-bold"> <?= $_SESSION['user_admin']; ?> </li>
              <?php
            }
            else {
              ?>
                <li>
                  <a class="nav-link fw-bold" aria-current="page" href="./profile/profile">
                    <i class="fa-solid fa-user"></i>
                    Agent Transactions Rapide
                  </a>
                </li>
                <li>
                  <a class="nav-link fw-bold" aria-current="page" href="./profile/otherProfile">
                    <i class="fa-solid fa-user"></i>
                    Agents Transactions Hors Site
                  </a>
                </li>
                <li>
                  <a class="nav-link fw-bold" aria-current="page" href="./passport/timbrePassport">
                    <i class="fa-solid fa-file"></i>
                    Timbre Et Passport
                  </a>
                </li>
                <li>
                  <a class="nav-link fw-bold" aria-current="page" href="./mTransactions/manuelTransaction">
                    <i class="fa-solid fa-right-left"></i>
                    Transactions Manuelles
                  </a>
                </li>
                <li>
                  <a class="nav-link fw-bold" aria-current="page" href="./mTransactions/manuelTransaction">
                    <i class="fa-solid fa-right-left"></i>
                    Transactions Via le Site
                  </a>
                </li>
              <?php
            }
          ?>
          <li class="nav-item text-dark fw-bold">
            <?php
              if (isset($_SESSION['user_admin']) && isset($_SESSION['role_admin'])) {
                echo $_SESSION['user_admin'];
              }
            ?>
          </li>  
          <form method="POST" class="mt-5" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <button name="logout" class="btn btn-primary fw-bold btn-sm">
              <i class="fa-solid fa-right-from-bracket"></i>
            </button>
          </form>
        </ul>
      </div>
    </div>
  </div>
</nav>