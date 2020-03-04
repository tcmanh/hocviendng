
<div class="row">
	<div class="col-md-12">
		<?php if($member){ ?>
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title"><?php echo $member->name; ?></h3>
			</div>
			<div class="box-body">
				<form role="form" method="post" action="<?php echo site_url('admin/member/add') ?>" class="form-horizontal" enctype="multipart/form-data">
					<input type="hidden" name="id" class="form-control" value="<?php echo $member->id; ?>" />
					<input type="hidden" name="picture" class="form-control" value="<?php echo $member->avatar; ?>" />
	               	<div class="form-group">
	                  	<label class="col-sm-3 text-right">Mã học viên</label>
						<div class="col-sm-9">
	                  		<input type="text" name="code" class="form-control" value="<?php echo $member->code; ?>" />
	                  	</div>
	               	</div>
	               	<div class="form-group">
	                  	<label class="col-sm-3 text-right">Tên học viên</label>
	                  	<div class="col-sm-9">
	                  		<input type="text" name="name" class="form-control" value="<?php echo $member->name; ?>" />
	                  	</div>
	               	</div>
	               	<div class="form-group dv-blah">
		                <label class="col-xs-3 col-form-label"></label>
		                <div class="col-xs-9">
		                    <img id="blah" src="../assets/uploads/member/<?php if($member->avatar == '') echo 'default.png'; else echo $member->avatar; ?>" style="max-width: 300px" >
		                </div>
		            </div>
		            <div class="form-group">
	                  	<label class="col-sm-3 text-right">Avatar</label>
	                  	<div class="col-sm-9">
	                  		<input type="file" name="avatar" id="imgInp" class="form-control" value="<?php echo $member->name; ?>" />
	                  	</div>
	               	</div>
	               	<div class="form-group">
	                  	<label class="col-sm-3 text-right">Số điện thoại</label>
	                  	<div class="col-sm-9">
	                  		<input type="text" class="form-control" name="phone" value="<?php echo $member->phone; ?>" />
	                  	</div>
	               	</div>
	               	<div class="form-group">
	                  	<label class="col-sm-3 text-right">Ngày sinh</label>
	                  	<div class="col-sm-9">
	                  		<input name="birthday" type="text" maxlength="10" class="datepicker form-control" value="<?php echo $member->birthday; ?>" >
	                  	</div>
	               	</div>
	               	<div class="form-group">
                        <label for="" class="col-sm-3 control-label">Giới tính
                        	<span class='required'>*</span>                             
                        </label>
                        <div class="col-sm-9">
                            <div>
                            	<label>
                            		<input type="radio" name="gender" <?php if ($member->gender == 1) echo 'checked="checked"'; ?> value="1"  /> Nữ
                            	</label> 
                            	<label>
                            		<input type="radio" name="gender" <?php if ($member->gender == 0) echo 'checked="checked"'; ?> value="0"  /> Nam
                            	</label>
                            </div>                            
                        </div>
                    </div>
	               	<div class="form-group">
	                  	<label class="col-sm-3 text-right">Mail</label>
	                  	<div class="col-sm-9">
	                  		<input type="text" class="form-control" name="mail" value="<?php echo $member->mail; ?>" />
	                  	</div>
	               	</div>
	               	<div class="form-group">
	                  	<label class="col-sm-3 text-right">Địa chỉ</label>
	                  	<div class="col-sm-9">
	                  		<input type="text" class="form-control" name="address" value="<?php echo $member->address; ?>" />
	                  	</div>
	               	</div>
	               	<div class="form-group">
	                  	<label class="col-sm-3 text-right">Mô tả</label>
	                  	<div class="col-sm-9">
	                  		<textarea name="describe" class="form-control" rows="5" ><?php echo $member->describe; ?></textarea>
	                  	</div>
	               	</div>
	               	<div class="form-group">
	                  	<label class="col-sm-3 text-right">Ghi chú</label>
	                  	<div class="col-sm-9">
	                  		<textarea name="note" class="form-control" rows="4" /><?php echo $member->note; ?></textarea>
	                  	</div>
	               	</div>
	               	<div class="col-sm-9 col-sm-offset-3">
	               		<button type="submit" name="add-member" class="btn btn-success">Lưu</button>
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