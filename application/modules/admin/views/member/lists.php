<div class="box box-info">
   <div class="box-header">
      <a href="<?php echo site_url('admin/member/add') ?>"><button class="btn btn-success pull-right">Thêm mới</button></a>
   </div>
   <div class="box-body row">
      <div class="table-responsive col-xs-12">
      <table class="table table-bordered tablelte-full">
         <thead>
            <tr>
               <th>STT</th>
               <th>Mã học viên</th>
               <th>Họ tên</th>
               <th>Hình ảnh</th>
               <th>Ngày tạo</th>
               <th>Đang học</th>
               <th>Thao tác</th>
            </tr>
         </thead>
         <tbody>
            <?php $count = 0; ?>
            <?php foreach ($member as $package) { 
               $count++; ?>
            <tr style="vertical-align: middle;">
               <td style="vertical-align: inherit"><?php echo $count; ?></td>
               <td><?php echo $package->code; ?></td>
               <td><?php echo $package->name.'<br>'.$package->phone; ?></td>
               <td>
                  <img src="../assets/uploads/member_thumbs/<?php if(empty($package->avatar)) echo 'default.png'; else echo $package->avatar; ?>" width="50px" style="cursor: pointer" data-toggle="modal" data-target="#modalAvatar-<?php echo $count;?>">
                  <!-- Modal -->
                  <div id="modalAvatar-<?php echo $count;?>" class="modal fade" role="dialog">
                     <div class="modal-dialog">
                        <div class="modal-content">
                           <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                           </div>
                           <div class="modal-body text-center">
                              <img src="../assets/uploads/member_thumbs/<?php if(empty($package->avatar)) echo 'default.png'; else echo $package->avatar; ?>" width="100%" data-toggle="modal" data-target="#modalAvatar-<?php echo $count;?>">
                           </div>
                           <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                           </div>
                        </div>
                     </div>
                  </div>
               </td>
               <td><?php echo $package->created; ?></td>
               <td>
                  <label class="switch">
                     <input type="checkbox" name="status" <?php if($package->status == 1) echo 'checked="checked"';?> class="bd-change-status" data-table="member" value="<?php echo $package->id; ?>" >
                     <div class="slider round"></div>
                  </label>
               </td>
               <td>
                  <a href="<?php echo site_url('admin/member/views/').$package->id; ?>" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Chi tiết"><i class="fa fa-eye"></i></a>
                  <a href="<?php echo site_url('admin/member/edit/').$package->id; ?>" class="btn btn-primary btn-xs" data-toggle="tooltip" title="Sửa"><i class="fa fa-pencil"></i></a>
               </td>
            </tr>
            <?php } ?>
         </tbody>
      </table>
      </div>
   </div>
</div>

