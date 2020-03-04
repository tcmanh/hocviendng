<div class="row">
   <div class="col-md-12">
      <div class="box box-info">
         <div class="box-header with-border">
            <div class="box-title">
               <form action="" method="GET" class="form-inline" role="form">
                  <div class="form-group">
                       <div class="input-group">
                         <div class="input-group-addon">
                           <i class="fa fa-calendar"></i>
                         </div>
                         <input id="reportrange" name="date_filter" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%" value="">
                       </div>
                  </div>
                  <div class="form-group">
                     <select name="course_id[]" class="form-control select2" multiple>
                        <?php foreach ($all_course as $value) { ?>
                        <option value="<?php echo $value->id;?>"><?php echo $value->name.' --- '.get_user_fullname($value->user_id);?></option>
                        <?php } ?>
                     </select>
                  </div>
                  <div class="form-group">
                     <input type="hidden" name="filter" value="1">
                     <button type="submit" class="form-control btn-primary">Tìm kiếm</button>
                  </div>
               </form>
            </div>
         </div>
         <div class="box-body">
            <div class="table-responsive">
               <table class="table table-bordered">
                  <thead>
                     <tr>
                        <td>STT</td>
                        <td>Ngày đăng ký</td>
                        <td>Học viên</td>
                        <td>Khóa học</td>
                        <td>Cọc</td>
                        <td>Thanh toán lần sau</td>
                        <td>Nợ</td>
                        <td>Giảng viên</td>
                        <td>NV thu</td>
                        <td>Ghi chú</td>
                     </tr>
                  </thead>
                  <?php 
                  $i = $total = $total_debit = $total_pay_debit = $total_pay_visa = $total_visa = 0;
                  $total_pay_visa_after = 0;
                  if($statistical){ ?>
                  <tbody>
                     <?php 
                     foreach($statistical as $value){ 

                     if(!isset($staff[$value->import_id])){
                        $staff[$value->import_id] = new stdClass();
                        $staff[$value->import_id]->pay = $staff[$value->import_id]->amount = $staff[$value->import_id]->visa = $staff[$value->import_id]->debit_pay = $staff[$value->import_id]->debit_amount = $staff[$value->import_id]->debit_visa = 0;
                     }
                     $staff[$value->import_id]->pay += $value->pay;
                     $staff[$value->import_id]->amount += $value->amount;
                     $staff[$value->import_id]->visa += $value->visa;

                     $i++;
                     $total_pay_debit += get_course_member_debit($value->id);
                     $total_visa += get_course_member_debit_visa($value->id);
                     $total_pay_visa += $value->visa;
                     $total += $value->pay; ?>
                     <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $value->created; ?></td>
                        <td><?php echo get_member_name($value->member_id); ?></td>
                        <td><?php echo get_course_name($value->course_id); ?><br><?php echo number_format($value->total);?> vnđ</td>
                        <td>
                           <?php echo number_format($value->pay);
                           $total_visa += $value->visa;
                           if($value->visa > 0){
                              echo '<br>';
                              echo '<p class="btn btn-success btn-xs" style="margin:5px 0">Visa: '.number_format($value->visa).'</p>';
                           } ?>
                        </td>  
                        <td>
                        	lần sau
                           <?php echo number_format(get_course_member_debit($value->id));
                           if(get_course_member_debit_visa($value->id) > 0){
                           	$total_pay_visa_after += get_course_member_debit_visa($value->id);
                              echo '<br>';
                              echo '<p class="btn btn-success btn-xs" style="margin:5px 0">Visa: '.number_format(get_course_member_debit_visa($value->id)).'</p>';
                           } ?>
                        </td> 
                        <td>
                           <?php $debit = $value->total - $value->pay - get_course_member_debit($value->id);
                           $total_debit += $debit;
                           if($debit > 0){ ?>
                              <a href="member/debit/<?php echo $value->id; ?>" target="_blank"><span class="badge bg-red"><?php echo number_format($debit); ?></span></a>
                           <?php } else { ?>
                              <span class="badge bg-green">Thu đủ</span>
                           <?php } ?>
                        </td>
                        <td><?php echo get_teachers_by_course($value->course_id);?></td>
                        <td><?php echo get_user_fullname($value->import_id);?></td>
                        <td><?php echo $value->note; ?></td>
                     </tr>
                     <?php } ?>
                     <tr>
                        <td colspan="4" class="text-right">Tổng tiền</td>
                        <td>
                           <?php echo 'Tổng: '.number_format($total);?><br>
                           <?php if($total_pay_visa > 0){ ?>
                           <?php echo '<p class="btn btn-success btn-xs" style="margin:5px 0">Visa: '.number_format($total_pay_visa).'</p>'; ?><br>
                           <?php } ?>
                           <?php echo 'Tiền mặt: '.number_format($total-$total_pay_visa);?>
                        </td>
                        <td>
                           <?php echo 'Tổng: '.number_format($total_pay_debit);?><br>
                           <?php if($total_pay_visa_after > 0){ ?>
                           <?php echo '<p class="btn btn-success btn-xs" style="margin:5px 0">Visa: '.number_format($total_pay_visa_after).'</p>'; ?><br>
                           <?php } ?>
                           <?php echo 'Tiền mặt: '.number_format($total_pay_debit-$total_pay_visa_after);?>
                        </td>
                        <td colspan="3"><?php echo number_format($total_debit);?></td>
                     </tr>
                  </tbody>
                  <?php } ?>
               </table>
            </div>
         </div>
      </div>


      <div class="box box-info">
         <div class="box-header with-border">
           <h3 class="box-title">Thu nợ</h3>
         </div>
         <div class="box-header with-border">
            <div class="box-body">
            <div class="table-responsive">
               <table class="table table-bordered">
                  <thead>
                     <tr>
                        <td>STT</td>
                        <td>Học viên</td>
                        <td>Khóa học</td>
                        <td>Số tiền</td>
                        <td>Thời gian</td>
                        <td>NV thu</td>
                        <td>Ghi chú</td>
                     </tr>
                  </thead>
                  <?php 
                  $i = $debt_total = $debt_visa = 0;
                  if($debt_collection){ ?>
                  <tbody>
                     <?php 
                     foreach($debt_collection as $val){ 
                     if(!isset($staff[$val->import_id])){
                        $staff[$val->import_id] = new stdClass();
                        $staff[$val->import_id]->debit_pay = $staff[$val->import_id]->debit_amount = $staff[$val->import_id]->debit_visa = $staff[$val->import_id]->pay = $staff[$val->import_id]->amount = $staff[$val->import_id]->visa = 0;
                     }
                     $staff[$val->import_id]->debit_pay += $val->price;
                     $staff[$val->import_id]->debit_amount += $val->amount;
                     $staff[$val->import_id]->debit_visa += $val->visa;

                     $i++;
                     $debt_total += $val->price;
                     $debt_visa += $val->visa; ?>
                     <tr>
                        <td><?php echo $i;?></td>
                        <td><?php echo get_member_name($val->member_id); ?></td>
                        <td><?php echo get_course_name($val->course_id); ?></td>
                        <td>
                           <?php echo number_format($val->price); 
                           if($val->visa > 0){
                           ?>
                           <br>
                           <p class="btn btn-success btn-xs" style="margin:5px 0">Visa: <?php echo number_format($val->visa);?></p>
                           <?php } ?>
                        </td>
                        <td><?php echo $val->created; ?></td>
                        <td><?php echo get_user_fullname($val->import_id);?></td>
                        <td><?php echo $val->note; ?></td>
                     </tr>
                     <?php } ?>
                     <tr>
                        <td colspan="3" class="text-right">Tổng tiền</td>
                        <td>
                           <?php echo 'Tổng: '.number_format($debt_total);
                           if($debt_visa > 0){ ?>
                           <br>
                           <p class="btn btn-success btn-xs" style="margin:5px 0">Visa: <?php echo number_format($debt_visa);?></p>
                           <?php } ?>
                           <br>
                            <?php echo 'Tiền mặt: '.number_format($debt_total - $debt_visa); ?>
                        </td>
                     </tr>
                  </tbody>

                  <?php } ?>
               </table>
            </div>

         </div>
      </div>


      <div class="box box-danger">
         <div class="box-header with-border">
            <h3 class="box-title">Doanh số (vnđ)</h3>
         </div>
         <div class="box-body no-padding">
            <div class="row">
               <div class="col-sm-3 col-xs-6">
                  <div class="description-block border-right">
                     <h5 class="description-header"><?php echo number_format($total);?></h5>
                     <p class="btn btn-success btn-xs" style="margin: 7px">
                        Visa: <?php echo number_format($total_visa);?></p><br>
                     <a href="revenue/product"><span class="description-text">Đăng ký mới</span></a>
                  </div>
               </div>
               <div class="col-sm-3 col-xs-6">
                  <div class="description-block border-right">
                     <h5 class="description-header"><?php echo number_format($total_debit);?></h5>
                     <a href="revenue/product"><span class="description-text">Nợ</span></a>
                  </div>
               </div>
               <div class="col-sm-3 col-xs-6">
                  <div class="description-block border-right">
                     <h5 class="description-header"><?php echo number_format($debt_total);?></h5>
                     <p class="btn btn-success btn-xs" style="margin: 7px">
                        Visa: <?php echo number_format($debt_visa);?></p><br>
                     <a href="revenue/product"><span class="description-text">Thu nợ</span></a>
                  </div>
               </div>
               <div class="col-sm-3 col-xs-6">
                  <div class="description-block border-right">
                     <h5 class="description-header"><?php echo number_format($total + $debt_total);?></h5>
                     <p class="btn btn-success btn-xs" style="margin: 7px">
                        Visa: <?php echo number_format($total_visa + $debt_visa);?></p><br>
                     <a href="revenue/product"><span class="description-text">Tổng</span></a>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <?php if(isset($staff)){ ?>
      <div class="box box-danger">
         <div class="box-header with-border">
            <h3 class="box-title">Doanh số Nhân viên</h3>
         </div>
         <div class="box-body">
            <div class="table-responsive">
               <table class="table table-bordered">
                  <thead>
                     <tr>
                        <td>STT</td>
                        <td>Nhân viên</td>
                        <td>Đăng ký mới</td>
                        <td>Thu nợ</td>
                        <td>Tổng</td>
                     </tr>
                  </thead>
                  <tbody>
                     <?php 
                     $k = 0;
                     foreach ($staff as $key => $value) {
                     $k++; ?>
                     <tr>
                        <td><?php echo $k;?></td>
                        <td><?php echo get_user_fullname($key);?></td>
                        <td>  
                           Tiền mặt: <?php echo number_format($value->amount);?><br>
                           <span class="badge bg-green">Visa: <?php echo number_format($value->visa);?></span>
                        </td>
                        <td>
                           Tiền mặt: <?php echo number_format($value->debit_amount);?><br>
                           <span class="badge bg-green">Visa: <?php echo number_format($value->debit_visa);?></span>
                        </td>
                        <td>
                           <?php echo number_format($value->pay + $value->debit_pay);?>
                        </td>
                     </tr>
                     <?php } ?>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
      <?php } ?>

   </div>
</div>
