<?php
$password_to_hash = 'WHATEVERPASSWORDHERE'; // ← Make sure exactly your password here

$hash = password_hash($password_to_hash, PASSWORD_DEFAULT);
echo "Your new password hash is: <br><textarea rows='2' cols='80'>" . htmlspecialchars($hash) . "</textarea>";
?>
