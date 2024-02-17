<?php 
session_start();
require_once "fungsi.php";
lapor($_SESSION['nama']."logout");
session_destroy();
header("location:index.php?p=login");
