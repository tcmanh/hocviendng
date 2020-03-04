<div class="row">
	<div class="col-md-12">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title">Thông tin nhân viên</h3>
			</div>
			<div class="box-body">
				<table class="table table-striped">
				    <tbody>
					    <tr>
					        <td>Họ tên: <?php echo $user->first_name.' '.$user->last_name;?></td>
					    </tr>
					    <tr>
					        <td>Điện thoại: <?php echo $user->phone;?></td>
					    </tr>
					    <tr>
					        <td>Email: <?php echo $user->email;?></td>
					    </tr>
					    <tr>
					        <td>Nhóm quản trị: 
					        	<?php foreach ($user->users_groups as $key => $value) {
					        		if($key != 0) echo ', ';
					        		echo $value->name;
					        	} ?>
					        </td>
					    </tr>
				    </tbody>
			  	</table>
			</div>
		</div>
	</div>
</div>