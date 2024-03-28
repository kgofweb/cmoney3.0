<?php
// Si le user est un sous membre
if (isset($_SESSION['role_admin'])) {
  header('Location: ../admin/dashboard');
}