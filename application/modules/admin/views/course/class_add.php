<div class="row">
	<div class="col-md-12">
		<div class="box box-primary">
			<div class="box-body">
				<form role="form" method="post" action="course/save_class" class="form-horizontal" enctype="multipart/form-data">
					<div class="form-group">
	               		<label class="col-sm-3 text-right">Chọn khóa học</label>
	               		<div class="col-sm-9">
	                     	<select name="course_id" class="form-control">
	                        	<?php 
	                        	foreach (all_course() as $course) { ?>
	                           	<option value="<?php echo $course->id; ?>"><?php echo $course->name;?></option>
	                        	<?php } ?>
	                     	</select>
                     	</div>
                  	</div>
	               	<div class="form-group">
	                  	<label class="col-sm-3 text-right">Tên lớp học</label>
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
	                  	<label class="col-sm-3 text-right">Ghi chú</label>
	                  	<div class="col-sm-9">
	                  		<textarea name="note" class="form-control" rows="4" /></textarea>
	                  	</div>
	               	</div>
	               	<div class="col-sm-9 col-sm-offset-3">
	               		<button type="submit" name="add-class" class="btn btn-success">Lưu</button>
	               	</div>
	            </form>
			</div>
		</div>
	</div>
</div>