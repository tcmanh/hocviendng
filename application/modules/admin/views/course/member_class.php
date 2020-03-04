<section class="content">
   <div class="row">
      <div class="box box-info">
         <div class="box-body">
            <div class="table-responsive table-condensed col-xs-12">
               <table class="table table-bordered row">
                  <thead>
                     <tr>
                        <th class="text-center">STT</th>
                        <th>Học viên</th>
                        <th>Lớp</th>
                        <th class="text-center">Chọn</th>
                     </tr>
                  </thead>
                  <?php if($course_member){ ?>
                  <form action="" method="post">
                  <tbody>
                     <?php foreach ($course_member as $key => $value) { ?>
                     <tr>
                        <td class="text-center"><?php echo $key+1;?></td>
                        <td><?php echo get_member_name($value->member_id);?></td>
                        <td><?php echo get_class_name($value->class_id);?></td>
                        <td class="text-center">
                           <div class="checkbox">
                              <label><input type="checkbox" name="member_id[]" value="<?php echo $value->id;?>"></label>
                           </div>
                        </td>
                     </tr>
                     <?php } ?>
                     <tr>
                        <td colspan="2"></td>
                        <td>
                           <select class="form-control" name="class_id">
                              <?php foreach ($list_class as $cl) { ?>
                              <option value="<?php echo $cl->id;?>"><?php echo $cl->name;?></option>
                              <?php } ?>
                           </select>
                        </td>
                        <td class="text-center">
                           <button type="submit" name="class_transfer" class="btn btn-success">Chuyển lớp</button>
                        </td>
                     </tr>
                  </tbody>
                  </form>
                  <?php } ?>
               </table>
            </div>
         </div>
      </div>
   </div>
</section>
<style type="text/css">
   input[type="checkbox"]{
      width: 20px;
      height: 20px;
   }
</style>

