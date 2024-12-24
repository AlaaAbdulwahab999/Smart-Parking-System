<?php
  require_once('database.php');

  DATABASE::connect('localhost', 'smartparking', '123456', 'smartparking');

  $slots = DATABASE::query("select * from slots");
?>

<style>
  * {
    background-color: #222;
    /* border: 2px solid; */
  }
  #container {
    border: 2px solid;
    width: 550px;
    height: 500px;
    /* top: 50%;
    left: 50%; */
  }
  .slot {
    display: inline-block;
    background-color: white;
    width: 6em;
    height: 2em;
    text-align: center;
    padding-top: 1em;
    margin: 2em;
    box-shadow: black 10px 10px 10px;
  }
  .vline {
    display: inline-block;
    background-color: white;
    height: 3em;
    width: 3px;
    transform: translate(0, 40%);
  }
  .hline {
    background-color: white;
    margin: auto;
    width: 90%;
    height: 1%;
  }
  /* .street {
    width: 100%;
    height: 20%;
  } */
  .dots {
    display: inline-block;
    border-top: 2px dashed white;
    width: 5em;
    /* height: 5em; */
    margin-top: 3em;
    margin-bottom: 3em;
    margin-left: 12.5%;
    /* transform: translate(0, 2.5em); */
  }
</style>

<div id="container">
  
<?php
$numberOfColumns = 3;
$numberOfRows = ceil(sizeof($slots)/$numberOfColumns);

for($r = 0; $r < $numberOfRows; $r++) {
  echo '<div class="row"><div class="hline"></div>';
  for($c = 0; $c < $numberOfColumns; $c++) {
    $slotId = $c + $numberOfColumns*$r;

    if($slotId >= sizeof($slots)) break;

    $color = $slots[$slotId]['status_of_slot'] === NULL ? 'red' : 'green';

    echo "<div class='slot' style='background-color: $color;'>Slot $slotId</div>";

    if($c < $numberOfColumns - 1)
      echo "<div class='vline'></div>";
  }
  echo '<div class = "hline"></div>';
  echo '<div class="street"><div class="dots"></div><div class="dots"></div><div class="dots"></div></div>';
  echo '</div>';
}
?>
</div>