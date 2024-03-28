<?php if (isset($_SESSION['success'])) {
  ?>
    <!-- Success -->
    <div class="d-flex justify-content-end">
      <div class="toast align-items-center fw-bold text-white bg-success border-0 mt-4" role="alert" aria-live="assertive" aria-atomic="true" style="z-index: 1000;">
        <div class="d-flex">
          <div class="toast-body">
            <?php echo $_SESSION['success']; ?>
          </div>
          <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
      </div>
    </div>
    <?php
    unset($_SESSION['success']);
  } 
  else if (isset($_SESSION['error'])) {
    ?>
    <!-- Error -->
      <div class="d-flex justify-content-end">
        <div class="toast align-items-center mt-3 fw-bold border-0" role="alert" aria-live="assertive" aria-atomic="true" style="z-index: 1000;">
          <div class="d-flex">
            <div class="toast-body d-flex align-items-center">
            <i class="fa-solid fa-circle-minus" style="font-size: 1.2rem; margin-right: .3rem;color: #eb4d4b;"></i>
              <?php echo $_SESSION['error']; ?>
            </div>
            <button type="button" class="btn-close btn-close-dark me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
          </div>
        </div>
      </div>
    <?php
    unset($_SESSION['error']);
    session_destroy();
  } 
  else if (isset($_SESSION['validate'])) {
    ?>
      <!-- Validate -->
      <div class="d-flex justify-content-end">
        <div class="toast align-items-center fw-bold border-0 mt-3" role="alert" aria-live="assertive" aria-atomic="true" style="z-index: 1000;">
          <div class="d-flex">
            <div class="toast-body d-flex align-items-center">
              <i class="fa-solid fa-circle-check" style="font-size: 1.2rem; margin-right: .3rem; color: #00b894;"></i>
              <?php echo $_SESSION['validate']; ?>
            </div>
            <button type="button" class="btn-close btn-close-dark me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
          </div>
        </div>
      </div>
    <?php
    unset($_SESSION['validate']);
    session_destroy();
  } 
  else if (isset($_SESSION['alreadyAsk'])) {
    ?>
    <!-- Already Asked -->
      <div class="d-flex justify-content-end">
        <div class="toast border-0 mt-4 text-dark" role="alert" aria-live="assertive" aria-atomic="true" style="z-index: 1000;">
          <div class="d-flex">
            <div class="toast-body d-flex align-items-center text-dark fw-bold">
              <i class="fa-sharp fa-solid fa-circle-exclamation" style="font-size: 1.2rem; margin-right: .3rem;color: #f9ca24;"></i>
              <?php echo $_SESSION['alreadyAsk'];?>
            </div>
            <button type="button" class="btn-close btn-close-dark me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
          </div>
        </div>
      </div>
    <?php
    unset($_SESSION['alreadyAsk']);
    session_destroy();
  }
  else if (isset($_SESSION['cancel'])) {
    ?>
      <!-- Cancel -->
      <div class="d-flex justify-content-end">
        <div class="toast align-items-center mt-2 fw-bold border-0" role="alert" aria-live="assertive" aria-atomic="true" style="z-index: 1000;">
          <div class="d-flex">
            <div class="toast-body d-flex align-items-center">
            <i class="fa-solid fa-circle-minus" style="font-size: 1.2rem; margin-right: .3rem;color: #eb4d4b;"></i>
              <?php echo $_SESSION['cancel']; ?>
            </div>
            <button type="button" class="btn-close btn-close-dark me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
          </div>
        </div>
      </div>
    <?php
    unset($_SESSION['cancel']);
    session_destroy();
  }
?>