<section class="content">
   <div class="row">
      <div class="box box-info">
         <div class="box-body">
            <div class="table-responsive">
               <table class="table table-bordered">
                  <thead>
                     <tr>
                        <th>STT</th>
                        <th>Người tạo</th>
                        <th>Thời gian</th>
                        <th>Thành tiền</th>
                        <th>Tác vụ</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php $count = $total = 0; ?>
                     <?php foreach ($info as $package) { 
                     $count++;
                     $total += $package->price;?>
                     <tr>
                        <td><?php echo $count; ?></td>
                        <td><?php echo get_user_fullname($package->import_id); ?></td>
                        <td><?php echo $package->created; ?></td>
                        <td>
                           <?php echo number_format($package->price);
                           if($package->visa > 0){
                              echo '<br>';
                              echo '<p class="btn btn-success btn-xs" style="margin:5px 0">Visa: '.number_format($package->visa).'</p>';
                           }
                           ?>
                        </td>
                        <td>
                           <a href="<?php echo site_url('admin/member/invoice_debit/').$package->id; ?>" class="btn btn-warning btn-xs" data-toggle="tooltip" title="In"><i class="fa fa-print"></i></a>
                           <?php if($package->created == date('Y-m-d') ){ ?>
                           <a href="<?php echo site_url('admin/member/delete_debit/').$package->id; ?>" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Xóa"><i class="fa fa-remove"></i></a>
                           <?php } ?>
                        </td>
                     </tr>
                     <?php } ?>
                     <tr>
                        <td class="text-right" colspan="3">Tổng tiền</td>
                        <td><?php echo number_format($total); ?> vnđ</td>
                     </tr>
                  </tbody>
               </table>
            </div>
            <?php if($debit > $total){ ?>
            <form method="post" action="">
               <div class="form-inline">
                  <input type="text" min="0" name="price" placeholder="Số tiền" class="form-control number" style="width:150px;margin-bottom: 10px;" value="0">
                  <textarea style="width: 100%; margin-bottom: 10px;" class="form-control" name="note"  placeholder="Ghi chú"></textarea>
                  <div class="clearfix"></div>
                  <div class="form-group has-warning">
                     <input id="visa" name="visa" type="text" class="form-control number" placeholder="Visa ...">
                     <label class="control-label"><i class="fa fa-bell-o"></i> Nếu thanh toán visa</label>
                  </div>
                  <div class="clearfix"></div>
                  <div class="form-group">
                     <button type="submit" name="add-debit" class="btn btn-success">Đồng ý</button>
                  </div>
               </div>
            </form>
            <?php } ?>
         </div>
      </div>
   </div>
</section>
