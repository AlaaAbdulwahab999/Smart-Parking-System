<?php
  require_once('database.php');

  DATABASE::connect('localhost', 'smartparking', '123456', 'smartparking');

  $cost_per_hour = 50;
  $car_data = [];
  $car_id = '';

  if(isset($_GET['carId'])) {
    #var_dump($_GET);
	  $car_id = $_GET['carId'];
    #var_dump($car_id);
    $car_data = DATABASE::query("select HOUR(timediff(NOW(), entrance_time)) as number_of_hours from cars where plate_number=\"{$_GET['carId']}\" AND departure_time is NULL LIMIT 1");
    #var_dump($car_data);
  }
?>
<style>
  body {
    background-color: #F0F3F4;
  }
  .pp {
    text-align: center;
    color: red;
    font-size: 30px;
  }
</style>
<h1> Check Out </h1>
<form>
  <label> Please Enter car ID </label>
  <input type="Text" name="carId" value="<?php echo $car_id; ?>">
  <submit>
</form>
<?php
  if(isset($_GET['carId'])) {
    #var_dump($_GET);
	  if(sizeof($car_data)) {
      DATABASE::query(
        "UPDATE cars set payment_time = current_timestamp() WHERE plate_number = \""
        . $_GET['carId']
        . "\""
        );
      #var_dump($_GET);
	    $number_of_hours = $car_data[0]['number_of_hours'];
	    $total_cost = $number_of_hours * $cost_per_hour;
	    echo "<p> Number of hours : {$number_of_hours} hours</p>";
	    echo "<p>Amount to be paid: {$total_cost} </p>";
	  }
    else {
	  echo '<p class = "pp">CAR NOT FOUND</p>';
	  }
  }
?>
<p class = "pp"> Thank You </p>