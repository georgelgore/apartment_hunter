<?php
  include('init_db.php');
  include('init_table.php');
  include('pop_db.php');
  $configs = include('../config/config.php');

  $conn = mysqli_connect($configs['host'], $configs['username'], $configs['password'], $configs['db']);

  if (!$conn) {
      die('Could not connect: ' . mysqli_error($conn));
  }

  mysqli_select_db($conn,"listings");
  $sql="SELECT * FROM listings";

  $result = mysqli_query($conn,$sql);
  $rows = array();

  while($row =mysqli_fetch_assoc($result))
    {
        $rows[] = $row;
    }
  print json_encode($rows);

?>
