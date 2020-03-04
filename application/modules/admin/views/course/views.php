
<link href='<?php echo plugins_url('iCheck/flat/blue.css'); ?>' rel='stylesheet'>
<link href='<?php echo plugins_url('iCheck/flat/green.css'); ?>' rel='stylesheet'>
<link href='<?php echo plugins_url('iCheck/flat/orange.css'); ?>' rel='stylesheet'>
<link href='<?php echo plugins_url('iCheck/flat/red.css'); ?>' rel='stylesheet'>
<link href="<?php echo plugins_url('toastr-master/build/toastr.min.css'); ?>" rel="stylesheet">

<section class="content">
   <div class="row">
      <ul class="nav nav-tabs">
         <?php foreach ($list_class as $key => $class) { ?>
         <li class="<?php if($key == 0) echo 'active';?>"><a data-toggle="tab" href="#class-<?php echo $key;?>"><?php echo get_class_name($key);?></a></li>
         <?php } ?>
      </ul>
      <div class="tab-content">
         <?php foreach ($list_class as $key => $class) { ?>
         <div id="class-<?php echo $key;?>" class="tab-pane fade <?php if($key == 0) echo 'in active';?>">
            <div class="box box-info">
               <div class="box-body">
                  <div class="table-responsive">
                     <table class="table table-bordered">
                        <thead>
                           <tr>
                              <th rowspan="2" class="text-center" style="vertical-align: middle;">STT</th>
                              <th rowspan="2" style="vertical-align: middle;">Học viên</th>
                              <th style="width:142px" colspan="3" class="text-center">
                                 <table class="table" style="padding: 0; margin-bottom: 0">
                                    <tr>
                                       <th colspan="3" class="text-center">Điểm danh</th>
                                    </tr>
                                    <tr>
                                       <th class="text-center" width="33%">Có</th>
                                       <th class="text-center" width="33%">Trễ</th>
                                       <th class="text-center" width="33%">Vắng</th>
                                    </tr>
                                 </table>
                              </th>
                              <th class="text-center" style="width:42px; vertical-align: middle;">Đã TN</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php $count = 0;
                           ?>
                           <?php foreach ($class as $value) {
                           $count++; ?>
                           <tr>
                              <td class="text-center"><?php echo $count;?></td>
                              <td><a href="course/detail/<?php echo $value->id; ?>" target="_blank"><?php echo get_member_name($value->member_id);?></a></td>
                              <td class="text-center">
                                 <?php echo check_checkin($value->id); ?>
                              </td>
                              <td class="text-center">
                                 <?php echo check_checklate($value->id); ?>
                              </td>
                              <td class="text-center">
                                 <?php echo check_checkout($value->id); ?>
                              </td>
                              <td>
                                 <label class="switch">
                                    <input type="checkbox" name="status" <?php if($value->status == 1) echo 'checked="checked"';?> class="bd-change-status" data-table="course_member" value="<?php echo $value->id; ?>" >
                                    <div class="slider round"></div>
                                 </label>
                              </td>
                           </tr>
                           <?php } ?>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
         <?php } ?>
      </div>

   </div>
</section>
<script type="text/javascript">
   $(function () {
      $('input.default').iCheck({
         checkboxClass: 'icheckbox_flat-default',
         radioClass: 'iradio_flat-blue'
      });
      $('input.blue').iCheck({
         checkboxClass: 'icheckbox_flat-blue',
         radioClass: 'iradio_flat-blue'
      });
      $('input.green').iCheck({
         checkboxClass: 'icheckbox_flat-green',
         radioClass: 'iradio_flat-green'
      });
      $('input.orange').iCheck({
         checkboxClass: 'icheckbox_flat-orange',
         radioClass: 'iradio_flat-orange'
      });
      $('input.red').iCheck({
         checkboxClass: 'icheckbox_flat-red',
         radioClass: 'iradio_flat-red'
      });

      $('input[type="radio"]').on('ifClicked', function(e) {
         var action = $(this).data('action');
         var course_member_id = $(this).data('course_member_id');
         if(action == 'checkin'){
            var status = 1;
            var note = 'Có mặt';
            send_checkin(course_member_id, status, note);
         }
         else if(action == 'checklate'){
            console.log('Di muộn');
            var status = 4;
            var note = 'Đi muộn';
            send_checkin(course_member_id, status, note);
         }
         else if(action == 'checkout'){
            swal({
               title: "<small>Vắng mặt</small>",
               text: 
                  '<textarea rows="5" id="mytextarea" class="form-control" placeholder="Ghi chú"></textarea>' +
                  '<button class="btn-checkout" data-status="2">Có phép</button>' +
                  '<button class="btn-checkout" data-status="3">Không phép</button>',
               html: true,
               showConfirmButton: false
            });

            $('.btn-checkout').click(function(){
               var note = $('#mytextarea').val();
               var status = $(this).data('status');
               send_checkin(course_member_id, status, note);
            });
         }
      });
   });

   function send_checkin(course_member_id, status, note){
      $.ajax({
         url:  base_url + "admin/course/checkin",
         data: {'course_member_id':course_member_id, 'status': status, 'note': note},
         type: "POST",
         success: function(data){ 
            if(data=='success')
               toastr["success"]("Điểm danh thành công");
            else
               toastr["error"]("Lỗi dữ liệu");
         },
         error: function(){
            toastr["error"]("Lỗi Gửi Ajax");
         }
      });
      $('#mytextarea').val('');
   }
</script>


