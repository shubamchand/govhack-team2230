<?php
require_once('../../config.php');
$stmt = $conn->query("SELECT * FROM vehicle_registration ORDER BY id DESC LIMIT 1");
while ($row = $stmt->fetch_assoc()) {
  $id = $row['id'];
  echo ($id);
}
 ?>


<script>
 function popup()
{
  var id = document.getElementById('vid').value;
  window.open('https://govhack.x10.mx/admin/vehicles/qrgen.php?id=' + id, 'newwin', 'height=500px,width=500px');
}
</script>

<h4>Successfully added a vehicle</h4>
<input type='button' value='Generate QR Code' id='test' onClick='popup()'>
<input type="hidden" name="vehicle_id" id="vid" value="<?php echo $id; ?>">

