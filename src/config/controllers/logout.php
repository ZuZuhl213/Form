<?php
session_start();
session_destroy();
header("Location: ../views/Login.html");
exit();
?>