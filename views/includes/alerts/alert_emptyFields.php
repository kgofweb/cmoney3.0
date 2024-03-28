<?php
  if (isset($_SESSION['emptyFiled'])) {
    ?>
      <div class="d-flex justify-content-end mt-2">
        <div class="toast border-0 text-dark" role="alert" aria-live="assertive" aria-atomic="true" style="z-index: 1000;">
          <div class="d-flex">
            <div class="toast-body d-flex align-items-center text-dark fw-bold">
              <i class="fa-sharp fa-solid fa-circle-exclamation" style="font-size: 1.2rem; margin-right: .3rem;color: #f9ca24;"></i>
              <?php echo $_SESSION['emptyFiled'];?>
            </div>
            <button type="button" class="btn-close btn-close-dark me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
          </div>
        </div>
      </div>
    <?php
    unset($_SESSION['emptyFiled']);
  }
?>