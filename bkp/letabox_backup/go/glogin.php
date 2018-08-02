
<?php
if ($success) {
  // Check if user email ID exist
  $sql = "SELECT COUNT(*) AS count from users where email = :email_id";
  try {
    $stmt = $DB->prepare($sql);
    $stmt->bindValue(":email_id", $user->email);
    $stmt->execute();
    $result = $stmt->fetchAll();

    if ($result[0]["count"] > 0) {
      // User Exist 

      $_SESSION["name"] = $user->name;
      $_SESSION["email"] = $user->email;
      $_SESSION["new_user"] = "no";
    } else {
      // New user, Insert in database
      $sql = "INSERT INTO `users` (`name`, `email`) VALUES " . "( :name, :email)";
      $stmt = $DB->prepare($sql);
      $stmt->bindValue(":name", $user->name);
      $stmt->bindValue(":email", $user->email);
      $stmt->execute();
      $result = $stmt->rowCount();
      if ($result > 0) {
        $_SESSION["name"] = $user->name;
        $_SESSION["email"] = $user->email;
        $_SESSION["new_user"] = "yes";
        $_SESSION["e_msg"] = "";
      }
    }
  } catch (Exception $ex) {
    $_SESSION["e_msg"] = $ex->getMessage();
  }

  $_SESSION["user_id"] = $user->id;

} else {
  $_SESSION["e_msg"] = $client->error;
}
header("location:home.php");
exit;