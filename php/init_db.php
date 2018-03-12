<?php
   $configs = include('../config/config.php');

   // CREATE DB
   $conn = mysqli_connect($configs['host'], $configs['username'], $configs['password']);

   if(!$conn) {
      die('Could not connect: ' . mysqli_connect_error());
   }


   $sql = 'CREATE DATABASE IF NOT EXISTS apartments';
   $retval = mysqli_query($conn, $sql);

   if(!$retval ) {
      die('Could not create database: ' . mysqli_error($conn));
   }

   mysqli_close($conn);
?>
