<div class="row">
	<div class="col-md-12">
		<?php if($course){ ?>
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title"><?php echo $course->name; ?></h3>
			</div>
			<div class="box-body">
				<form role="form" method="post" action="<?php echo site_url('admin/course/add') ?>" class="form-horizontal" enctype="multipart/form-data">
					<input type="hidden" name="id" class="form-control" value="<?php echo $course->id; ?>" />
	               	<div class="form-group">
	                  	<label class="col-sm-3 text-right">Mã khóa học</label>
						<div class="col-sm-9">
	                  		<input type="text" name="code" class="form-control" value="<?php echo $course->code; ?>" />
	                  	</div>
	               	</div>
	               	<div class="form-group">
	                  	<label class="col-sm-3 text-right">Tên khóa học</label>
	                  	<div class="col-sm-9">
	                  		<input type="text" name="name" class="form-control" value="<?php echo $course->name; ?>" />
	                  	</div>
	               	</div>
	               	<div class="form-group">
	               		<label class="col-sm-3 text-right">Tên giảng viên</label>
	               		<div class="col-sm-9">
	                     	<select name="user_id" class="form-control">
	                     		<?php foreach (get_teachers() as $user) { ?>
	                           	<option <?php if($user->id == $course->user_id) echo 'selected="selected"'; ?> value="<?php echo $user->id; ?>"><?php echo $user->first_name.' '. $user->last_name; ?></option>
	                        	<?php } ?>
	                     	</select>
                     	</div>
                  	</div>
	               	<div class="form-group">
	                  	<label class="col-sm-3 text-right">Mô tả</label>
	                  	<div class="col-sm-9">
	                  		<textarea name="describe" class="form-control" rows="5" ><?php echo $course->describe; ?></textarea>
	                  	</div>
	               	</div>
	               	<div class="form-group">
	                  	<label class="col-sm-3 text-right">Ngày bắt đầu</label>
	                  	<div class="col-sm-9">
	                  		<input type="text" name="date_added" class="form-control datepicker" name="date" value="<?php echo $course->date_added; ?>">
	                  	</div>
	               	</div>
	                <div class="form-group">
	                  	<label class="col-sm-3 text-right">Ngày kết thúc</label>
	                  	<div class="col-sm-9">
	                  		<input type="text" name="date_end" class="form-control datepicker" name="date" value="<?php echo $course->date_end; ?>">
	                  	</div>
	               	</div>
	               	<div class="form-group">
	                  	<label class="col-sm-3 text-right">Tình trạng</label>
	                  	<div class="col-sm-9">
							<select class="form-control" name="status">
								<option <?php if($course->status == 1) echo 'selected="selected"'; ?> value="1">Đang hoạt động</option>
								<option <?php if($course->status == 0) echo 'selected="selected"'; ?> value="0">Dừng hoạt động</option>
							</select>
	                  	</div>
	               	</div>
	               	<div class="form-group">
	                  	<label class="col-sm-3 text-right">Ghi chú</label>
	                  	<div class="col-sm-9">
	                  		<textarea name="note" class="form-control" rows="4" /><?php echo $course->note; ?></textarea>
	                  	</div>
	               	</div>
	               	<div class="col-sm-9 col-sm-offset-3">
	               		<button type="submit" name="add-course" class="btn btn-success">Lưu</button>
	               	</div>
	            </form>
			</div>
		</div>
		<?php } else{ ?>
		<section class="content">
			<div id="new_feed"></div>	
			<div class="error-page">
				<div class="alert alert-danger alert-dismissable">
  					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  					<h4><i class="icon fa fa-ban"></i> Error!</h4>
  					Trang này không tồn tại hoặc đang được xây dựng vui lòng quay lại sau!.
				</div>
				<a class="btn btn-primary " href="<?php echo site_url();?>"> Trở về trang chủ</a>
			</div>
		</section>
		<?php } ?>
	</div>
</div>
