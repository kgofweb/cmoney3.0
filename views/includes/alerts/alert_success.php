<?php 
  if (isset($_SESSION['success'])) {
    ?>
      <!-- Validate -->
      <div class="d-flex justify-content-end">
        <div class="toast align-items-center fw-bold border-0 mt-3" role="alert" aria-live="assertive" aria-atomic="true" style="z-index: 1000;">
          <div class="d-flex">
            <div class="toast-body d-flex align-items-center">
              <i class="fa-solid fa-circle-check" style="font-size: 1.2rem; margin-right: .3rem; color: #00b894;"></i>
              <?php echo $_SESSION['success']; ?>
            </div>
            <button type="button" class="btn-close btn-close-dark me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
          </div>
        </div>
      </div>
    <?php
    unset($_SESSION['success']);
  } 
?>