<?php
session_start();
session_unset();
session_destroy();
header("Location: ../index.html/InitSes.html"); // O la página que quieras tras cerrar sesión
exit();
?>
