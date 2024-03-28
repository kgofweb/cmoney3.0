<?php
if (!$_SESSION['user_admin'] && !$_SESSION['password_admin']) {
  header('Location: ./admin');
}