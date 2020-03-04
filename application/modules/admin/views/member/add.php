<form role="form" method="post" action="<?php echo site_url('admin/member/add') ?>" enctype="multipart/form-data">
    <div class="row">
        <div class="col-xs-12 col-sm-6">
            <div class="box box-primary">
                <div class="box-header">
                    <div class="box-title">Thông tin cơ bản</div>
                </div>
              <div class="box-body">
                    <div class="form-group">
                        <label class="control-label">Tên học viên</label>
                        <input type="text" name="name" class="form-control" value="" />
                    </div>
                    <div class="form-group">
                        <label class="control-label">Khu vực</label>
                        <select class="form-control" name="area" />
                            <option value="HCM">Hồ Chí Minh</option>
                            <option value="DN">Đà Nẵng</option>
                            <option value="CT">Cần Thơ</option>
                        </select>
                    </div>
                    <div class="form-group dv-blah">
                        <label class="control-label"></label>
                        <img id="blah" src="../assets/uploads/member/default.png" style="max-width: 300px" >
                    </div>
                    <div class="form-group">
                        <label class="control-label">Avatar</label>
                        <input type="file" name="avatar" id="imgInp" class="form-control" value="" />
                    </div>
                    <div class="form-group">
                        <label class="control-label">Số điện thoại</label>
                        <input type="text" class="form-control" name="phone" value="" />
                    </div>
                    <div class="form-group">
                        <label class="control-label">Mật khẩu</label>
                        <input type="text" class="form-control" name="password" value="" />
                    </div>
                    <div class="form-group">
                        <label class="control-label">Ngày sinh</label>
                        <input name="birthday" type="text" maxlength="10" class="datepicker form-control" value="" >
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label">Giới tính
                          <span class='required'>*</span>                             
                        </label>
                        <div>
                          <label>
                            <input type="radio" name="gender" checked="checked" value="1"  /> Nữ
                          </label> 
                          <label>
                            <input type="radio" name="gender" /> Nam
                          </label>
                        </div>                            
                    </div>
                    <div class="form-group">
                        <label class="control-label">Mail</label>
                        <input type="email" class="form-control" name="mail" value="" />
                    </div>
                    <div class="form-group">
                        <label class="control-label">Địa chỉ</label>
                        <input type="text" class="form-control" name="address" value="" />
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
                        <input type="text" class="form-control" name="phone_contact" placeholder="Điện thoại" required="required" value="">   
                    </div>
                    <div class="form-group">
                        <label class="control-label">Địa chỉ liên lạc<span class="required">*</span></label>
                        <input type="text" class="form-control" name="address_contact" placeholder="Địa chỉ liên lạc" value="">   
                    </div>
                    <div class="form-group">
                        <label class="control-label">Số chứng minh thư<span class="required">*</span></label>
                        <input type="text" class="form-control" name="id_card" required="required" placeholder="Số chứng minh thư" value="">   
                    </div>
                    <div class="form-group">
                        <label class="control-label">Ngày cấp<span class="required">*</span></label>
                        <input type="text" class="form-control datepicker" required="required" name="id_date" value="">   
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
    </div>
</form>