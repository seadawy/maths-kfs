<?php
$dbh = new mysqli('localhost', 'root', '', 'mathskfs') or die("Could not connect to mysql" . mysqli_error($dbh));
mysqli_set_charset($dbh, "utf8");
