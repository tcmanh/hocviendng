
<div class="row">
	<div class="col-md-12">
		<?php if($result){ ?>
		<div class="box box-primary">
			<div class="box-body">
				<form role="form" method="post" action="" class="form-horizontal" enctype="multipart/form-data">
					<input type="hidden" name="id" class="form-control" value="<?php echo $result->id; ?>" />
	               	<div class="form-group">
	                  	<label class="col-sm-3 text-right">Trạng thái</label>
	                  	<div class="col-sm-9">
	                  		<select class="form-control" name="status">
                              <option <?php if($result->status == 0) echo 'selected'; ?> value="0">Đang học</option>
                              <option <?php if($result->status == 1) echo 'selected'; ?> value="1">Đã tốt nghiệp</option>
                              <option <?php if($result->status == 2) echo 'selected'; ?> value="2">Bảo lưu</option>
                              <option <?php if($result->status == 3) echo 'selected'; ?> value="3">Ngỉ ngang</option>
                           </select>
	                  	</div>
	               	</div>

	               	<div class="form-group">
	                  	<label class="col-sm-3 text-right">Thời gian (ngày)</label>
	                  	<div class="col-sm-9">
	                  		<input class="form-control" name="status_date" value="<?php echo $result->status_date;?>">
	                  	</div>
	               	</div>

	               	
	               	<div class="form-group">
	                  	<label class="col-sm-3 text-right">Ghi chú</label>
	                  	<div class="col-sm-9">
	                  		<textarea name="status_note" class="form-control" rows="4" /><?php echo $result->status_note; ?></textarea>
	                  	</div>
	               	</div>
	               	<div class="col-sm-9 col-sm-offset-3">
	               		<button type="submit" name="save" class="btn btn-success">Lưu</button>
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
  					Học viên không tồn tại!.
				</div>
				<a class="btn btn-primary " href="<?php echo site_url();?>"> Trở về trang chủ</a>
			</div>
		</section>
		<?php } ?>
	</div>
</div>