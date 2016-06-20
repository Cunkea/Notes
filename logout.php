<?php
include 'spoj.php';

session_start(); 
session_destroy(); 
header("Location: login.php");


?>