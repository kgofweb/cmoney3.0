<style>
  a {
    text-decoration: none;
    color: #0E2F56;
  }
  a:hover {
    color: #0E2F56;
  }
  .message {
    position: fixed;
    bottom: 0;
    right: 1.2rem;
    margin-top: 5rem;
  }
  .message__content {
    width: 50px;
    height: 50px;
    line-height: 50px;
    border-radius: 50px;
    background-color: #89c8e1;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .message__content a {
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .message i {
    font-size: 1.7rem;
    cursor: pointer;
  }
</style>

<div class="message mb-3 d-flex align-items-center">
  <span class="mx-2 fw-bold">Assistance</span>
  <div class="message__content">
    <a href="../views/help" target="_blank">
      <i class="fa-solid fa-message"></i>
    </a>
  </div>
</div>