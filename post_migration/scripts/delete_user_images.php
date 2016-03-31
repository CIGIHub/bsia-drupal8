<?php
function load_user($user_id) {
  return \Drupal\user\Entity\User::load($user_id);
}

// Get database connection
\Drupal\Core\Database\Database::setActiveConnection();
$connection = \Drupal\Core\Database\Database::getConnection();

// Get all the users
$results = $connection->query('SELECT u.uid, d.name, d.mail FROM users AS u INNER JOIN users_field_data AS d ON u.uid = d.uid;')->fetchAll();

// For each user, remove the user_picture and then save the user
if ($results) {
  foreach ($results as $record) {
    $user_id = $record->uid;
    $user_name = $record->name;
    $user_email = $record->mail;
    print "Removing user_picture from $user_name ($user_email)...\n";
    $user = load_user($user_id);
    $user->set("user_picture", NULL);
    $user->save();
  }
}
?>
