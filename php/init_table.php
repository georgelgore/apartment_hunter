<?php
  $configs = include('../config/config.php');

  $conn = mysqli_connect($configs['host'], $configs['username'], $configs['password'], $configs['db']);

    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }

    $val = mysqli_query($conn, 'select 1 from `listings` LIMIT 1');

    if($val == FALSE)
    {
      $sql = "CREATE TABLE listings (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        apartmentname VARCHAR(30) NOT NULL,
        beds VARCHAR(30) NOT NULL,
        baths VARCHAR(30) NOT NULL,
        floorplanname VARCHAR(60) NOT NULL,
        rentlow VARCHAR(30) NOT NULL,
        renthigh VARCHAR(30) NOT NULL,
        applylink VARCHAR(150) NOT NULL,
        reg_date TIMESTAMP
      ) ";

      if (mysqli_query($conn, $sql)) {
      }else{
        echo "Error creating table: " . mysqli_error($conn);
      }
   }

  mysqli_close($conn);

?>
