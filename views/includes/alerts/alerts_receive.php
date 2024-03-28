<?php
  if (isset($_SESSION['error'])) {
    ?>
      <div class="d-flex justify-content-end">
        <div class="toast align-items-center mt-2 fw-bold border-0" role="alert" aria-live="assertive" aria-atomic="true" style="z-index: 1000;">
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
  } 
?>