<div class="box box-primary">
	<div class="box-body">
		<form action="" class="form-horizontal" method="post" accept-charset="utf-8">
            <!-- <div class="form-group">
                <label class="col-md-3 control-label">APIKey SMS</label>
                <div class="col-md-4">
                    <input type="text" value="<?php echo get_option('APIKeySMS');?>" class="form-control" name="APIKeySMS">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">SecretKey SMS</label>
                <div class="col-md-4">
                    <input type="text" value="<?php echo get_option('SecretKeySMS');?>" class="form-control" name="SecretKeySMS">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">Đặt lịch</label>
                <div class="col-md-6">
                    <textarea class="form-control" rows="4" name="appointment"><?php echo get_option('appointment');?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">SMTP Username</label>
                <div class="col-md-4">
                    <input type="text" value="<?php echo get_option('smtpuser');?>" class="form-control" name="smtpuser" readonly>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">SMTP Password</label>
                <div class="col-md-4">
                    <input type="password" value="<?php echo get_option('smtppw');?>" class="form-control" name="smtppw" readonly>
                </div>
            </div> -->

            <div class="form-group">
                <label class="col-md-3 control-label">Bật/tắt thông báo</label>
                <div class="col-md-6">
                    <select class="form-control" name="notify_status">
                        <option <?php if(get_option('notify_status') == 'true') echo 'selected="selected"';?> value="true">Bật</option>
                        <option <?php if(get_option('notify_status') == 'false') echo 'selected="selected"';?> value="false">Tắt</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">Thông báo</label>
                <div class="col-md-6">
                    <textarea class="form-control" rows="4" name="notify_content"><?php echo get_option('notify_content');?></textarea>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-offset-3 col-md-9">
                    <input type="submit" name="submit" class="btn btn-danger" value="Lưu">
                </div>
            </div>
        </form>
	</div>
</div>

 <script type="text/javascript">
      $(function () {
        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"]').iCheck({
          checkboxClass: 'icheckbox_flat-blue',
          radioClass: 'iradio_flat-blue'
        });
      });
  </script>





	