<?php
session_start();
require_once "../konek.php";
require_once "../fungsi.php";
session_destroy();
lapor($_SESSION['nama'] . "logout", "../log/");

header("location:login.php");
