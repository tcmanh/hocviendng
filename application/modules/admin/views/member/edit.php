<?php if($member){ ?>
<form role="form" method="post" action="<?php echo site_url('admin/member/add') ?>" enctype="multipart/form-data">
    <div class="row">
        <div class="col-xs-12 col-sm-6">
            <div class="box box-primary">
                <div class="box-header">
                    <div class="box-title">Thông tin cơ bản: Mã học viên: <?php echo $member->code;?></div>
                </div>
        	    <div class="box-body">
        			<input type="hidden" name="id" class="form-control" value="<?php echo $member->id; ?>" />
        			<input type="hidden" name="picture" class="form-control" value="<?php echo $member->avatar; ?>" />
                   	<div class="form-group">
                      	<label class="control-label">Tên học viên</label>
                      	<input type="text" name="name" class="form-control" value="<?php echo $member->name; ?>" />
                   	</div>
                    <div class="form-group">
                        <label class="control-label">Khu vực</label>
                        <select class="form-control" name="area" />
                            <option <?php if ($member->area == 'HCM') echo 'selected="selected"'; ?> value="HCM">Hồ Chí Minh</option>
                            <option <?php if ($member->area == 'DN') echo 'selected="selected"'; ?> value="DN">Đà Nẵng</option>
                            <option <?php if ($member->area == 'CT') echo 'selected="selected"'; ?> value="CT">Cần Thơ</option>
                        </select>
                    </div>
                   	<div class="form-group dv-blah">
                        <label class="control-label"></label>
                        <img id="blah" src="../assets/uploads/member/<?php if($member->avatar == '') echo 'default.png'; else echo $member->avatar; ?>" style="max-width: 300px" >
                    </div>
                    <div class="form-group">
                      	<label class="control-label">Avatar</label>
                      	<input type="file" name="avatar" id="imgInp" class="form-control" value="<?php echo $member->name; ?>" />
                   	</div>
                   	<div class="form-group">
                      	<label class="control-label">Số điện thoại</label>
                      	<input type="text" class="form-control" name="phone" value="<?php echo $member->phone; ?>" />
                   	</div>
                    <div class="form-group">
                        <label class="control-label">Mật khẩu</label>
                        <input type="text" class="form-control" name="password" value="" />
                    </div>
                   	<div class="form-group">
                      	<label class="control-label">Ngày sinh</label>
                      	<input name="birthday" type="text" maxlength="10" class="datepicker form-control" value="<?php echo $member->birthday; ?>" >
                   	</div>
                   	<div class="form-group">
                        <label for="" class="control-label">Giới tính
                        	<span class='required'>*</span>                             
                        </label>
                        <div>
                        	<label>
                        		<input type="radio" name="gender" <?php if ($member->gender == 1) echo 'checked="checked"'; ?> value="1"  /> Nữ
                        	</label> 
                        	<label>
                        		<input type="radio" name="gender" <?php if ($member->gender == 0) echo 'checked="checked"'; ?> value="0"  /> Nam
                        	</label>
                        </div>                            
                    </div>
                   	<div class="form-group">
                      	<label class="control-label">Mail</label>
                      	<input type="email" class="form-control" name="mail" value="<?php echo $member->mail; ?>" />
                   	</div>
                   	<div class="form-group">
                      	<label class="control-label">Địa chỉ</label>
                      	<input type="text" class="form-control" name="address" value="<?php echo $member->address; ?>" />
                   	</div>
        	   </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-6">
            <div class="box">
                <div class="box-header">
                    <div class="box-title">Thông tin liên hệ</div>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label class="control-label">Điện thoại liên hệ khi cần<span class="required">*</span></label>
                        <input type="text" class="form-control" name="phone_contact" placeholder="Điện thoại" required="required" value="<?php echo $member->phone_contact;?>">   
                    </div>

                    <div class="form-group">
                        <label class="control-label">Địa chỉ liên lạc<span class="required">*</span></label>
                        <input type="text" class="form-control" name="address_contact" placeholder="Địa chỉ liên lạc" value="<?php echo $member->address_contact;?>">   
                    </div>
                    <div class="form-group">
                        <label class="control-label">Số chứng minh thư<span class="required">*</span></label>
                        <input type="text" class="form-control" name="id_card" required="required" placeholder="Số chứng minh thư" value="<?php echo $member->id_card;?>">   
                    </div>
                    <div class="form-group">
                        <label class="control-label">Ngày cấp<span class="required">*</span></label>
                        <input type="text" class="form-control datepicker" required="required" name="id_date" value="<?php echo $member->id_date;?>">   
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-6">
            <div class="box">
                <div class="box-header">
                    <div class="box-title">Thông tin chung</div>
                </div>
                <div class="box-body">

                    <div class="form-group">
                        <label class="control-label">Hồ sơ<span class="required">*</span></label>
                        <input type="file" name="file[]" class="form-control">
                        <input type="file" name="file[]" class="form-control"> 
                        <input type="file" name="file[]" class="form-control">
                    </div>
                    <div class="form-group">
                        <div class="form-submit">
                            <input class="btn btn-success" type="submit" name="add-member" value="Lưu"> 
                        </div>   
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-6">
            <div class="box">
                <div class="box-header">
                    <div class="box-title">Hồ sơ đã upload</div>
                </div>
                <div class="box-body">
                    <?php if($member->profiles){?>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="row">
                                <?php foreach ($member->profiles as $key => $profile) {?>
                                    <div class="col-xs-6 col-sm-3">
                                        <img data-toggle="modal" data-target="#image" style="cursor: pointer; width: 100%; height: 70px; object-fit: cover" src="<?php echo base_url();?>assets/uploads/user_infos/<?php echo $profile->file;?>" >
                                     
                                        <div class="text-center">
                                            <a class="label label-danger" href="member/remove_img/<?php echo $profile->id;?>">Xóa</a>
                                        </div>
                                    
                                    </div>
                                <?php } ?>
                            </div>
                        </div><div class="clearfix"></div>
                    </div>

                    <div class="modal fade" id="image" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel" data-interval="false">
                                    <div class="carousel-inner text-center">
                                        <?php foreach ($member->profiles as $key => $profile) {?>
                                        <div class="item <?php if($key==0) echo 'active'; ?>">   
                                            <img class="img-responsive" src="<?php echo base_url();?>assets/uploads/user_infos/<?php echo $profile->file;?>">

                                        </div>
                                        <?php } ?>
                                    </div>
                                    <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
                                    <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
                               </div>
                             </div>
                         </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</form>
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