<?php
$search= isset($_GET['search'])? $_GET['search'] : '';
?>

<div class="h-100  pt-2">
	<form action="" class="h-100">
		<div class="w-100 d-flex justify-content-center">
			<div class="input-group col-md-5">
				<input type="text" class='form-control' name="search" value="<?php echo isset($search) ? $search : "" ?>" placeholder="Search Vehicle">
				<div class="input-group-append">
				<button type="submit" class="btn btn-light border">
					<i class="fas fa-search text-muted"></i>
				</button>
				</div>
			</div>
		</div>
	</form>
	<hr>
	<div class="col-md-12">
		<div class="row row-cols-lg-3 row-cols-sm-2 row-cols-1 row-cols-xs-1">
			<?php
			$qry = $conn->query("SELECT * FROM vehicle_registration vr, vehicle_type vt WHERE vt.type LIKE '%".$search."%' AND vt.id = vr.regType ");
			while($row = $qry->fetch_assoc()):
				$typeId = $row['id'];
				$typeqry = $conn->query("SELECT * FROM vehicle_type WHERE id = '$typeId'");
			?>
			<a href="./?page=attendance&e=<?php echo md5($row['id']) ?>" class="col m-2">
				<div class="callout callout-info m-2 col event_item text-dark">
					<dl>
						<dt><b><?php while($rowType = $typeqry->fetch_assoc()): echo "Type:"." ".$rowType['type']; endwhile; ?></b></dt>
						<dd><?php echo "<small>Registration no:"." ".$row['registrationId']."</small>"; ?></dd>
						<dd><?php echo "<small>Make:"." ".$row['make']."</small>"; ?></dd>
						<dd><?php echo "<small>Model:"." ".$row['model']."</small>"; ?></dd>
						<dd><?php echo "<small>Year:"." ".$row['year']."</small>"; ?></dd>
						<dd><?php echo "Condition: <span class='badge badge-success'>Good</span>"; ?></dd>
					<dl>
					<!-- <div class="w-100 d-flex justify-content-end">
					<?php 
					//if(strtotime($row['datetime_start']) > time()): ?>
						<span class="badge badge-light">Pending</span>
					<?php //elseif(strtotime($row['datetime_end']) <= time()): ?>
						<span class="badge badge-success">Done</span>
					<?php //elseif((strtotime($row['datetime_start']) < time()) && (strtotime($row['datetime_end']) > time())): ?>
						<span class="badge badge-primary">On-Going</span>
					<?php //endif; ?>
					</div> -->
				</div>
			</a>
			<?php endwhile; ?>
		</div>
	</div>
</div>