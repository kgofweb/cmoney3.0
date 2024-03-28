<?php
  if (isset($_POST['logout'])) {
    $_SESSION = [];
    session_destroy();
    header('Location: ./admin');
  }