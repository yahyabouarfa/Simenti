<?php

include '../config/connexion.php';

session_start();
session_unset();
session_destroy();

header('location:login.php');

?>