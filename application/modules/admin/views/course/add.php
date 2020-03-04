
<div class="row">
	<div class="col-md-12">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title">Thêm khóa học</h3>
			</div>
			<div class="box-body">
				<form role="form" method="post" action="" class="form-horizontal" enctype="multipart/form-data">
	               	<div class="form-group">
	                  	<label class="col-sm-3 text-right">Mã khóa học</label>
						<div class="col-sm-9">
	                  		<input type="text" name="code" class="form-control" required>
	                  	</div>
	               	</div>
	               	<div class="form-group">
	                  	<label class="col-sm-3 text-right">Tên khóa học</label>
	                  	<div class="col-sm-9">
	                  		<input type="text" name="name" class="form-control" required>
	                  	</div>
	               	</div>
	               	<div class="form-group">
	               		<label class="col-sm-3 text-right">Tên giảng viên</label>
	               		<div class="col-sm-9">
	                     	<select name="user_id" class="form-control">
	                        	<?php 
	                        	foreach (get_teachers() as $user) { ?>
	                           	<option value="<?php echo $user->id; ?>"><?php echo $user->first_name.' '. $user->last_name; ?></option>
	                        	<?php } ?>
	                     	</select>
                     	</div>
                  	</div>
	               	<div class="form-group">
	                  	<label class="col-sm-3 text-right">Mô tả</label>
	                  	<div class="col-sm-9">
	                  		<textarea name="describe" class="form-control" rows="5" ></textarea>
	                  	</div>
	               	</div>
	               	<div class="form-group">
	                  	<label class="col-sm-3 text-right">Ngày bắt đầu</label>
	                  	<div class="col-sm-9">
	                  		<input name="date_added" type="text" class="datepicker form-control" required>
	                  	</div>
	               	</div>
	                <div class="form-group">
	                  	<label class="col-sm-3 text-right">Ngày kết thúc</label>
	                  	<div class="col-sm-9">
	                  		<input name="date_end" type="text" class="datepicker form-control">
	                  	</div>
	               	</div>
	               	<div class="form-group">
	                  	<label class="col-sm-3 text-right">Tình trạng</label>
	                  	<div class="col-sm-9">
							<select class="form-control" name="status">
								<option value="1">Đang hoạt động</option>
								<option value="0">Dừng hoạt động</option>
							</select>
	                  	</div>
	               	</div>
	               	<div class="form-group">
	                  	<label class="col-sm-3 text-right">Ghi chú</label>
	                  	<div class="col-sm-9">
	                  		<textarea name="note" class="form-control" rows="4" /></textarea>
	                  	</div>
	               	</div>
	               	<div class="col-sm-9 col-sm-offset-3">
	               		<button type="submit" name="add-course" class="btn btn-success">Lưu</button>
	               	</div>
	            </form>
			</div>
		</div>
	</div>
</div>