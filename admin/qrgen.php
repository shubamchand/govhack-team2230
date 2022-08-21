<!DOCTYPE html>
<html>
<head>
<title>QR Code Generator</title>
<script src="qr/qrcode.min.js"></script>
<script src="qr/jquery.min.js"></script>
<body>
  <?php $id = $_GET['id'];?>
  <div id="qrcode"></div>
  <script type="text/javascript">
  var qrcode = new QRCode(document.getElementById("qrcode"), {
  	text: "https://govhack.x10.mx/portal.php?id=<?=$id>",
  	width: 400,
  	height: 400,
  	colorDark : "#000000",
  	colorLight : "#ffffff",
  	correctLevel : QRCode.CorrectLevel.H
  });
  </script>
</body>
</html>
