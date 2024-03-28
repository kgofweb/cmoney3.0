<?php
// Si le user est un sous membre
if (isset($_SESSION['role_admin'])) {
  header('Location: ../dashboard');
}

// Si le user est un sous membre
if (isset($_SESSION['account_type'])) {
  header('Location: ../dashboard');
}