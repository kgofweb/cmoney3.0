<?php
  try {
    $db = new PDO('mysql:host=localhost;dbname=cmoney;charset=utf8;', 'root', '');
  } catch (Exception $e) {
    die('Impossible de se connecter à la base de donnée'. $e->getMessage());
  }