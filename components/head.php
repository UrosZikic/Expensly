<?php
session_start();

if (!isset($_COOKIE['signed']) && isset($_SESSION['m_si_d'])) {
  session_unset();
  // Header("Location: index.php");
  // exit();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Expensly</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="/styles/style.css">
</head>

<body>
  <?php require 'navigation.php'; ?>