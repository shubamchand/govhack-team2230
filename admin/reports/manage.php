<?php 
require_once('../../config.php');
$event_id = isset($_GET['vid'])? $_GET['vid'] : '';
if(isset($_GET['id']) && !empty($_GET['id'])){
	$qry = $conn->query("SELECT r.id, r.event_id, r.audience_id, r.user_id, r.date_created FROM registration_history r inner join event_audience a on a.id =r.audience_id where r.event_id = '{$event_id}' AND r.id = '{$_GET['id']}' order by r.id asc ");
	foreach($qry->fetch_assoc() as $k => $v){
		if(!is_numeric($k)){
			$$k = $v;
		}
	}
}
?>
<form action="" id="report-frm">
	<div id="msg" class="form-group"></div>
	<input type="hidden" name='id' value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>">
	<div class="form-group">
		<label for="date_created" class="control-label">Date/Time</label>
		<input type="datetime-local" class="form-control form-control-sm" name="date_created" id="date_created" value="<?php echo isset($date_created) ? date("Y-m-d\\TH:i",strtotime($date_created)) : '' ?>" required>
	</div>
	<div class="form-group">
		<input type="hidden" class="form-control form-control-sm" name="user_id" id="user_id" value="<?php echo isset($user_id) ? $user_id : '' ?>" required>
	</div>
	<div class="form-group">
		<label for="audience_id" class="control-label">Name</label>
		<select name="audience_id" id="audience_id" class="custom-select select2" required>
			<option></option>
			<?php 
				$qry = $conn->query("SELECT * FROM event_audience order by concat(name) asc ");
				while($row = $qry->fetch_assoc()):
			?>
				<option value="<?php echo $row['id'] ?>" <?php echo isset($audience_id) && $audience_id == $row['id'] ? "selected" : '' ?>><?php echo ucwords($row['name']) ?></option>
			<?php endwhile; ?>
		</select>
	</div>
	<div class="form-group">
		<label for="event_id" class="control-label">Course</label>
		<select name="event_id" id="event_id" class="custom-select select2" required>
			<option></option>
			<?php 
				$qry = $conn->query("SELECT id,title FROM vehicle_registration order by concat(title) asc ");
				while($row = $qry->fetch_assoc()):
			?>
				<option value="<?php echo $row['id'] ?>" <?php echo isset($event_id) && $event_id == $row['id'] ? "selected" : '' ?>><?php echo ucwords($row['title']) ?></option>
			<?php endwhile; ?>
		</select>
	</div>
<script>
$(document).ready(function(){
	$('.select2').select2();
		$('#report-frm').submit(function(e){
			e.preventDefault()
			start_loader()
			if($('.err_msg').length > 0)
				$('.err_msg').remove()
			$.ajax({
				url:_base_url_+'classes/Master.php?f=save_report',
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
					location.reload();
				}else{
					alert_toast("No changes recorded.",'error');
				}
					end_loader()
				}
			})
		})
	})
</script>