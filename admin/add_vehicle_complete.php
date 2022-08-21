
<script type="text/javascript">
function popup()
{
  window.open("https://govhack.x10.mx/admin/qrgen.php?=<?php=$id?>", 'newwin', 'height=500px,width=500px');

}
</script>
<?php
include ('includes/config.php');
  $registration_type = $_POST['regType'];
  $regNum = $_POST['regNum'];
  $make = $_POST['make'];
  $model = $_POST['regType'];
  $transmission = $_POST['transmission'];
  $body = $_POST['body'];
  $colour = $_POST['colour'];
  $year = $_POST['year'];
  $vin = $_POST['vin'];

  $sql = "INSERT INTO vehicle_registration (regType, registrationId, make, model, transmission, body, color, year, vin)
VALUES ('$registration_type', '$regNum', '$make', '$model', '$transmission', '$body' , '$colour', '$year', '$vin')";

/*if(mysqli_query($conn, $sql)){
    echo "<h3>Successfully added a vehicle</h3>";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
}*/

$query = $dbh -> prepare($sql);
if($query -> execute())
{
  echo "<h3>Successfully added a vehicle</h3>";
  echo "<input type='button' value='Generate QR Code' id='test' onClick='popup()'>";
}
else {
  echo ('db error!!')
}

//pullind out the id of last record

$stmt = $dbh->query("SELECT * FROM vehicle_registration ORDER BY id DESC LIMIT 1");
while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
  $id = ($row[0]);
}


$dbh->close();
 ?>
