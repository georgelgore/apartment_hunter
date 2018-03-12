<?php
  $configs = include('../config/config.php');
  $conn = mysqli_connect($configs['host'], $configs['username'], $configs['password'], $configs['db']);

  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

  $curl_handle=curl_init();
  curl_setopt($curl_handle,CURLOPT_URL,'https://www.rentcafe.com/rentcafeapi.aspx?requestType=apartmentavailability&APIToken=NDY5OTI%3d-XDY6KCjhwhg%3d&propertyCode=p0155985');
  curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,2);
  curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER,1);
  $buffer = curl_exec($curl_handle);
  curl_close($curl_handle);

  if (empty($buffer)){
      print "Nothing returned from url.<p>";
  }
  else{
      $json = json_decode($buffer, true);

  }

  // FIRST ROW DATETIME
  $result1 = mysqli_query($conn, "SELECT reg_date FROM listings limit 1");
  $row = mysqli_fetch_array($result1);

  // IF IT HAS BEEN MORE THAN 10 MINS, CLEAR TABLE
  $date_past = strtotime($row[0]);
  $time = date("G:i:s");
  $current_date = strtotime($time);
  // $current_date = strtotime(date('m/d/Y h:i:s a', time()));
  if ($current_date - $date_past  >= 4150 && !empty($buffer)){
    $sql = "DELETE FROM listings";
    if (!mysqli_query($conn, $sql)) {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
  }


  $result2 = mysqli_query($conn, "SELECT reg_date FROM listings limit 1");
  $num_rows = mysqli_num_rows($result2);
  if($num_rows == 0){
    foreach($json as $row){

      $apartment_name = mysqli_real_escape_string($conn, $row["ApartmentName"]);
      $beds = mysqli_real_escape_string($conn, $row["Beds"]);
      $baths = mysqli_real_escape_string($conn, $row["Baths"]);
      $floor_plan_name = mysqli_real_escape_string($conn, $row["FloorplanName"]);
      $rent_low = mysqli_real_escape_string($conn, $row["MinimumRent"]);
      $rent_high = mysqli_real_escape_string($conn, $row["MaximumRent"]);
      $apply_line = mysqli_real_escape_string($conn, $row["ApplyOnlineURL"]);

      $sql = "INSERT INTO listings (apartmentname, beds, baths, floorplanname, rentlow, renthigh, applylink)
      VALUES ('$apartment_name', '$beds', '$baths', '$floor_plan_name', '$rent_low', '$rent_high', '$apply_line')";

      if (!mysqli_query($conn, $sql)) {
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }


    }
  }

  mysqli_close($conn);
?>
