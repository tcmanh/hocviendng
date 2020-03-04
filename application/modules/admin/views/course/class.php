<section class="content">
   <div class="row">
      <div class="box box-info">
         <div class="box-header">
            <a href="<?php echo site_url('admin/course/add_class') ?>"><button class="btn btn-success pull-right">Thêm mới</button></a>
         </div>
         <div class="box-body">
            <div class="table-responsive table-condensed col-xs-12">
               <table class="table table-bordered tablelte-full row">
                  <thead>
                     <tr>
                        <th class="text-center">STT</th>
                        <th>Khóa học</th>
                        <th>Lớp học</th>
                        <th>Giảng viên</th>
                        <th>Người tạo</th>
                        <th>Sỉ số</th>
                        <th class="text-center">Thao tác</th>
                     </tr>
                  </thead>
                  <?php if($results){ ?>
                  <tbody>
                     <?php foreach ($results as $key => $value) { ?>
                     <tr>
                        <td class="text-center"><?php echo $key+1;?></td>
                        <td><?php echo get_course_name($value->course_id);?></td>
                        <td><?php echo $value->name;?></td>
                        <td><?php echo get_user_fullname($value->user_id);?></td>
                        <td><?php echo get_user_fullname($value->import_id);?><br>|__ <?php echo $value->created;?></td>
                        <td>
                           <?php echo count_member_of_class($value->id);?>
                        </td>
                        <td class="text-center">
                           <a href="<?php echo site_url('admin/course/member_class/').$value->id; ?>" class="btn btn-warning btn-xs"><i class="fa fa-eye"></i></a>
                           <a href="<?php echo site_url('admin/course/edit_class/').$value->id; ?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
                           <a href="<?php echo site_url('admin/course/delete_class/').$value->id; ?>" class="btn btn-danger btn-xs"><i class="fa fa-remove"></i></a>
                        </td>
                     </tr>
                     <?php } ?>
                  </tbody>
                  <?php } ?>
               </table>
            </div>
         </div>
      </div>
   </div>
</section>

