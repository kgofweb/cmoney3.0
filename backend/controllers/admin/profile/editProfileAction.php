<?php
if (isset($_POST['edit'])) {
  // Verifier si les champs ne sont pas vide
  if (!empty($_POST['member_name']) && !empty($_POST['member_country']) && !empty($_POST['member_city']) && !empty($_POST['member_phone']) && !empty($_POST['member_salary'])) {

    // Recuperer les nouvelles données
    function secure_data_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }

    $new_user_name = secure_data_input($_POST['member_name']);
    $new_user_country = secure_data_input($_POST['member_country']);
    $new_user_city = secure_data_input($_POST['member_city']);
    $new_user_phone = secure_data_input($_POST['member_phone']);
    $new_user_salary = secure_data_input($_POST['member_salary']);

    // Modifier les informations de la question qui possède l'id rentré en paramètre dans l'URL
    $editUserProfile = $db->prepare('UPDATE profile SET member_name = ?, member_country = ?, member_city = ?, member_phone = ?,  member_salary = ? WHERE id = ?');
    $editUserProfile->execute([
      $new_user_name,
      $new_user_country,
      $new_user_city,
      $new_user_phone,
      $new_user_salary,
      $idOfProfile
    ]);

    $_SESSION['success'] = 'Profil modifier avec success';
    header(htmlspecialchars('Location: ./profile'));
    
  } else {
    $_SESSION['emptyFiled'] = 'Veuillez renseigner tous les champs';
  }
}