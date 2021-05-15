<?php
session_start();
echo "<h1>Login</h1>";
echo "<p>Callsign:".$_SESSION['callsign']."</p>";
print_r($_SESSION);exit;
?>