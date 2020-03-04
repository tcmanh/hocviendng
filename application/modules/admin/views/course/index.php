
<section class="content">
   <div class="row">
      <div class="box box-info">
         <div class="box-header">
            <form action="" method="GET" class="form-inline pull-left" role="form">
               <div class="form-group">
                  <input type="text" placeholder="Mã khóa học" name="code" class="form-control">
               </div>
               <div class="form-group">
                  <input type="text" placeholder="Tên khóa học" name="name" class="form-control">
               </div>
               <!--div class="form-group">
                  <select name="status" id="inputType" class="form-control">
                     <option value="">Tình trạng</option>
                     <option value="wait">Sắp khai giảng</option>
                     <option value="1">Đang học</option>
                     <option value="0">Đã tốt nghiệp</option>
                  </select>
               </div-->
               <div class="form-group">
                  <input type="hidden" name="filter" value="1">
                  <button type="submit" class="btn btn-primary">Tìm kiếm</button>
               </div>
            </form>
            <a href="<?php echo site_url('admin/course/add') ?>"><button class="btn btn-success pull-right">Thêm mới</button></a>

            <div class="clearfix form-group"></div>
            <ul class="nav nav-pills"> 
               <li <?php if($this->session->userdata('course_status') == 'all') echo 'class="active"';?>><a href="course?course_status=all">Tất cả</a></li>
               <li <?php if($this->session->userdata('course_status') == 'wait') echo 'class="active"';?>><a href="course?course_status=wait">Sắp khai giảng</a></li>
               <li <?php if($this->session->userdata('course_status') == 1) echo 'class="active"';?>><a href="course?course_status=1">Đang học</a></li>
               <li <?php if($this->session->userdata('course_status') == 'done') echo 'class="active"';?>><a href="course?course_status=done">Đã tốt nghiệp</a></li>
            </ul>
         </div>
         <div class="box-body">
            <div class="table-responsive table-condensed col-xs-12">
               <table class="table table-bordered tablelte-full row">
                  <thead>
                     <tr>
                        <th class="text-center">STT</th>
                        <th>Mã khóa</th>
                        <th>Tên khóa học</th>
                        <th>Giảng viên</th>
                        <th>Người tạo</th>
                        <th>Sỉ số</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php $count = 0; ?>
                     <?php foreach ($details as $package) { $count++; ?>
                     <tr style="vertical-align: middle;">
                        <td class="text-center" style="vertical-align: inherit">
                           <?php echo $count; ?><br>
                           <input type="checkbox" name="list_course" value="<?php echo $package->id; ?>">
                        </td>
                        <td><?php echo $package->code; ?></td>
                        <td><?php echo $package->name; ?><br><?php echo $package->date_added; ?> <i class="fa fa-long-arrow-right"></i> <?php echo $package->date_end; ?></td>
                        <td><?php echo get_user_fullname($package->user_id); ?></td>
                        <td><?php echo get_user_fullname($package->import_id); ?><br>|__ <?php echo $package->created; ?></td>
                        <td><?php echo count_member_of_course($package->id);?></td>
                        <td>
                           <label class="switch">
                              <input type="checkbox" name="status" <?php if($package->status == 1) echo 'checked="checked"';?> class="bd-change-status" data-table="course" value="<?php echo $package->id; ?>" >
                              <div class="slider round"></div>
                           </label>
                        </td>
                        <td>
                           <a href="<?php echo site_url('admin/course/views/').$package->id; ?>" class="btn btn-warning btn-xs"><i class="fa fa-eye"></i></a>
                           <a href="<?php echo site_url('admin/course/edit/').$package->id; ?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
                        </td>
                     </tr>
                     <?php } ?>
                  </tbody>
               </table>
               <form action="course/views" method="get">
                  <input id="t" name="course" type="hidden">
                  <button class="btn btn-success">Điểm danh</button>
               </form>
            </div>
         </div>
      </div>
   </div>
</section>


<script>

jQuery(document).ready(function ($) {
   $('.btn-success').click(function(){
      updateTextArea();
   });
});
function updateTextArea() {         
   var allVals = [];
   $('input[name="list_course"]:checked').each(function() {
      allVals.push($(this).val());
   });
   $('#t').val(allVals);
}

</script>
