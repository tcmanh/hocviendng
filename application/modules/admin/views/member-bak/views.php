<section class="content">
   <div class="row">
      <div class="box box-info">
         <div class="box-body">
            <div class="table-responsive">
               <table class="table table-bordered">
                  <thead>
                     <tr>
                        <th>STT</th>
                        <th>Khóa học</th>
                        <th>Giá</th>
                        <th>Cọc</th>
                        <th>Ghi nợ</th>
                        <th>Người tạo</th>
                        <th>Bảng điểm (.pdf)</th>
                        <?php if(is_admin()){ ?>
                        <th>Tình trạng</th>
                        <?php } ?>
                        <th>Tác vụ</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php $count = 0;?>
                     <?php foreach ($details as $package) {  $count++; ?>
                     <tr>
                        <td class="text-center">
                           <?php echo $count; ?>
                           <br>
                           <span class="multi-print">
                              <input type="checkbox" name="list_print" value="<?php echo $package->id;?>">
                           </span>
                        </td>
                        <td><?php echo get_course_name($package->course_id); ?></td>
                        <td><?php echo number_format($package->total); ?> vnđ</td>
                        <td><?php echo number_format($package->pay); ?> vnđ</td>
                        <td>
                        <?php 
                        $card_package_debit = get_course_member_debit($package->id);?>
                        <a href="member/debit/<?php echo $package->id; ?>" target="_blank">
                        <?php
                        if($package->debit > $card_package_debit){ ?>
                           <span class="badge bg-red"><?php echo number_format($package->debit-$card_package_debit); ?> vnđ</span>
                        <?php } else { ?>
                           <span class="badge bg-green">Thu đủ</span>
                        <?php } ?>
                        </a>
                        </td>
                        <td>
                           <?php echo get_user_fullname($package->import_id); ?><br>
                           <?php echo $package->created; ?>
                        </td>
                        <td>
                           <?php
                           foreach ($package->result as $key => $value) {
                              echo '<a href="'.base_url().'assets/uploads/member/'.$value->link.'">'.$value->link.'</a><br>';
                           } ?>
                           <form action="<?php echo base_url('admin/member/upload'); ?>" method="post" enctype="multipart/form-data" class="formUploadScore">
                              <input type="hidden" name="parent_id" value="<?php echo $id; ?>">
                              <input type="hidden" name="id" value="<?php echo $package->id; ?>">
                              <input type="file" name="avatar">
                           </form>
                        </td>
                        <?php if(is_admin()){ ?>
                        <td>
                           <?php if($package->status == 0){ ?>
                              <span class="label label-info">Đang học</span>
                           <?php } ?>
                           <?php if($package->status == 1){ ?>
                              <span class="label label-success">Đã tốt nghiệp</span>
                           <?php } ?>
                           <?php if($package->status == 2){ ?>
                              <span class="label label-warning">Bảo lưu</span>
                           <?php } ?>
                           <?php if($package->status == 3){ ?>
                              <span class="label label-danger">Nghỉ ngang</span>
                           <?php } ?>
                        </td>
                        <?php } ?>
                        <td class="text-center">
                           <?php if(!is_teacher()){ ?>
                           <button style="margin-bottom: 7px" class="btn btn-primary btn-xs btn-transfer-course" data-course-id="<?php echo $package->course_id; ?>" data-course-member-id="<?php echo $package->id; ?>" data-toggle="modal" data-target="#myModal">Chuyển khóa</button>
                           <br>
                           <a href="<?php echo site_url('admin/member/status/').$package->id; ?>" class="btn btn-primary btn-xs" data-toggle="tooltip" title="Trạng thái"><i class="fa fa-pencil"></i></a>
                           <a href="<?php echo site_url('admin/member/invoice/').$package->id; ?>" class="btn btn-warning btn-xs" data-toggle="tooltip" title="In"><i class="fa fa-print"></i></a>
                           <?php } ?>
                           <a href="<?php echo site_url('admin/member/delete/').$package->id; ?>" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Xóa"><i class="fa fa-remove"></i></a>
                        </td>
                     </tr>
                     <?php } ?>
                     <tr>
                        <td>
                           <form action="member/list_invoice/<?php echo $id;?>" method="get">
                              <input id="print" name="print" type="hidden">
                              <button class="btn btn-warning btn-xs"><i class="fa fa-print"></i></button>
                           </form>
                        </td>
                     </tr>
                  </tbody>
               </table>
            </div>
            <?php if($member_info){ ?>
            <form method="post" action="">
            <div id="myModalNorm">
               <table class="table table-responsive table-bordered form-service-content">
                  <thead>
                     <td>Tên khóa học</td>
                     <td>Giá</td>
                     <td>Cọc</td>
                     <td>Ghi nợ</td>
                     <td>Ghi chú</td>
                     <td>Xóa</td>
                  </thead>
                  <tbody>
                  </tbody>
               </table>
            </div>
            <div class="form-inline">
               <div class="form-group">
                  <select id="service-id" class="form-control" style="width:220px" >
                     <?php foreach($all_course as $service){ ?>
                     <option value="<?php echo $service->id; ?>"><?php echo $service->name;?></option>
                     <?php } ?>
                  </select>
               </div>
               <div class="form-group">
                  <input type="text" id="total" min="0" placeholder="Giá" class="form-control number" style="width:100px" value="">
               </div>
               <div class="form-group">
                  <input type="text" id="pay" min="0" placeholder="Cọc" class="form-control number" style="width:100px" value="">
               </div>
               <div class="form-group">
                  <input type="text" id="debit" min="0" placeholder="Ghi nợ" class="form-control number" style="width:100px" value="">
               </div>
               <div class="clearfix"></div>
               <textarea id="note" rows="3" class="form-control" style="width:100%; max-width: 490px" placeholder="Ghi chú"></textarea>
               <div class="form-group">
                  <button type="button" class="btn btn-primary add-member-course"><i class="fa fa-plus"></i> </button>
               </div>
               <p></p>
               <div class="clearfix"></div>
               <div class="form-group has-warning">
                  <input id="visa" type="text" class="form-control number" placeholder="Visa ...">
                  <label class="control-label"><i class="fa fa-bell-o"></i> Nếu thanh toán visa</label>
               </div>
            </div>
            <p></p>
            <div class="form-group">
                  <button type="submit" name="add-package" class="btn btn-success">Thêm khóa học</button>
               </div>
            </form>
            <?php } else{ ?>
            <div class="callout callout-danger">
               <h4>Cảnh báo !</h4>
               <p>Khóa học không tồn tại</p>
            </div>
            <?php } ?>
         </div>
      </div>
   </div>
</section>
<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Chuyển khóa học</h4>
         </div>
         <div class="modal-body">
            <form action="" method="post">
               <input type="text" name="course_member_id" value="">
               <!--input type="text" name="course_transfer_id" value=""-->
               <div class="form-group">
                  <select name="course_transfer_id" class="form-control">
                  </select>
               </div>
               <div class="form-group">
                  <input type="submit" class="btn btn-success" name="transfer" value="Chuyển">
               </div>
            </form>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
         </div>
      </div>
   </div>
</div>
<script type="text/javascript">
   $('.btn-transfer-course').click(function(){
      var course_id = $(this).data('course-id');
      var course_member_id = $(this).data('course-member-id');
      var list_course = '';
      <?php foreach($all_course as $service){ ?>
         if(course_id == <?php echo $service->id;?>){
            var status = 'selected';
         }else{
            var status = '';
         }
         list_course += '<option value="'+'<?php echo $service->id;?>'+'" '+status+'>'+'<?php echo $service->name;?>'+' -- '+'<?php echo get_teacher_name($service->user_id);?>'+'</option>';
      <?php } ?>
      $('input[name="course_member_id"]').val(course_member_id);
      $('select[name="course_transfer_id"]').html(list_course);
   });
</script>
<script type="text/javascript">
   jQuery(document).ready(function ($) {
      $('.multi-print').click(function(){
         updateTextArea();
      });
      $('.add-member-course').click(function(event){
            event.preventDefault();
            var service_id = $('#service-id').val();
            var url_ajax = base_url + "admin/course/course_name";
            var total = $('#total').val();
            var pay = $('#pay').val();
            var debit = $('#debit').val();
            var visa = $('#visa').val();
            var note = $('#note').val();
            //var discount = $('#discount').val();
            //var discount_type = $('#discount_type').val();
            //var discount_type_text = $("#discount_type option:selected").text();
            if(total == ''){ service_debit = 0;}
            $.ajax({
                url: url_ajax,
                data: {'id':service_id,},
                type: "POST",
                success: function(data){
                    service_name = data;
                    $('.form-service-content tbody').append('<tr><td><input type="hidden" name="service_id[]" value="'+service_id+'">'+service_name+'</td><td><input type="hidden" name="total[]" value="'+total+'">'+total+'</td><td><input type="hidden" name="pay[]" value="'+pay+'"><input type="hidden" name="visa[]" value="'+visa+'">'+pay+'<br>Visa: '+visa+'</td><td><input type="hidden" name="debit[]" value="'+debit+'">'+debit+'</td><td><input type="hidden" name="note[]" value="'+note+'">'+note+'</td><td><span class="label label-danger remove-service-package">Xóa</span></td></tr>');   
                }
            }); 
        });
   });
   function updateTextArea() {         
      var allVals = [];
      $('input[name="list_print"]:checked').each(function() {
         allVals.push($(this).val());
      });
      $('#print').val(allVals);
   }
</script>
