<?php 
require_once('../../config.php');
if(isset($_GET['id']) && !empty($_GET['id'])){
	$qry = $conn->query("SELECT * FROM vehicle_registration where id = {$_GET['id']}");
	foreach($qry->fetch_array() as $k => $v){
		if(!is_numeric($k)){
			$$k = $v;
		}
	}
}
?>
<form action="" id="vehicle_frm">
	<div id="msg" class="form-group"></div>
	<input type="hidden" name='id' value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>">
	<div class="form-group">
		<label for="regType" class="control-label">Vehicle Type</label>
		<select name="regType" id="regType" class="custom-select select2" required>
			<option></option>
			<?php 
				$qry = $conn->query("SELECT id, type FROM vehicle_type order by type asc ");
				while($row = $qry->fetch_assoc()):
			?>
				<option value="<?php echo $row['id'] ?>" <?php echo isset($regType) && $regType == $row['id'] ? "selected" : '' ?>><?php echo ucwords($row['type']) ?></option>
			<?php endwhile; ?>
		</select>
	</div>
	<div class="form-group">
		<label for="registrationId" class="control-label">Registration ID</label>
		<input type="text" class="form-control form-control-sm" name="registrationId" id="registrationId" value="<?php echo isset($registrationId) ? $registrationId : '' ?>" required>
	</div>
	<div class="form-group">
		<label for="make" class="control-label">Make</label>
		<input type="text" class="form-control form-control-sm" name="make" id="make" required value="<?php echo isset($make) ? $make : '' ?>" />
	</div>
	<div class="form-group">
		<label for="model" class="control-label">Model</label>
		<input type="text" class="form-control form-control-sm" name="model" id="model" required value="<?php echo isset($model) ? $model : '' ?>" />
	</div>
	<div class="form-group">
		<label for="transmission" class="control-label">Transmission Type</label>
		<input type="text" class="form-control form-control-sm" name="transmission" id="transmission" required value="<?php echo isset($transmission) ? $transmission : '' ?>" />
	</div>
	<div class="form-group">
		<label for="body" class="control-label">Body</label>
		<input type="text" class="form-control form-control-sm" name="body" id="body" required value="<?php echo isset($body) ? $body : '' ?>" />
	</div>
	<div class="form-group">
		<label for="color" class="control-label">Color</label>
		<input type="text" class="form-control form-control-sm" name="color" id="color" required value="<?php echo isset($color) ? $color : '' ?>" />
	</div>
	<div class="form-group">
		<label for="year" class="control-label">Year</label>
		<input type="number" class="form-control form-control-sm" maxlength="4" name="year" id="year" required value="<?php echo isset($year) ? $year : '' ?>" />
	</div>
	<div class="form-group">
		<label for="vin" class="control-label">VIN</label>
		<input type="text" class="form-control form-control-sm" name="vin" id="vin" required value="<?php echo isset($vin) ? $vin : '' ?>" />
	</div>
</form>
<script>
	
	$(document).ready(function(){
		$('.select2').select2();
		$('#vehicle_frm').submit(function(e){
			e.preventDefault()
			start_loader()
			if($('.err_msg').length > 0)
				$('.err_msg').remove()
			$.ajax({
				url:_base_url_+'classes/Master.php?f=save_vehicle',
				data: new FormData($(this)[0]),
			    cache: false,
			    contentType: false,
			    processData: false,
			    method: 'POST',
			    type: 'POST',
			    dataType: 'json',
				error:err=>{
					console.log(err)
					alert_toast("an error occured","error")
					end_loader()
				},
				success:function(resp){
				if(resp.status == 'success'){
                  uni_modal("Generate QR","./vehicles/afterAddition.php")
					//location.reload();
				}else if(resp.status == 'duplicate'){
					var _frm = $('#vehicle_frm #msg')
					var _msg = "<div class='alert alert-danger text-white err_msg'><i class='fa fa-exclamation-triangle'></i> Vehicle already exists.</div>"
					_frm.prepend(_msg)
					_frm.find('input#title').addClass('is-invalid')
					$('[name="title"]').focus()
				}else{
					alert_toast("An error occured.",'error');
				}
					end_loader()
				}
			})
		})
	})
</script>