

<section class="content">

   <div class="row">

      <div class="box box-info">

         <div class="box-header">

            <form action="" method="GET" class="form-inline pull-left" role="form">

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

                  <button type="submit" class="btn btn-primary">Tìm kiếm</button>

               </div>

            </form>

            <a href="<?php echo site_url('admin/member/add') ?>"><button class="btn btn-success pull-right">Thêm mới</button></a>

            <div class="clearfix form-group"></div>

            <ul class="nav nav-pills"> 

               <li <?php if($this->session->userdata('member_status') == 'all') echo 'class="active"';?>><a href="member?member_status=all">Tất cả</a></li>

               <li <?php if($this->session->userdata('member_status') == 'debit') echo 'class="active"';?>><a href="member?member_status=debit">Còn nợ</a></li>

               <li <?php if($this->session->userdata('member_status') == 'done') echo 'class="active"';?>><a href="member?member_status=done">Nộp đủ</a></li>

               <li <?php if($this->session->userdata('member_status') == 'reserve') echo 'class="active"';?>><a href="member?member_status=reserve">Bảo lưu</a></li>

               <li <?php if($this->session->userdata('member_status') == 'off') echo 'class="active"';?>><a href="member?member_status=off">Nghỉ ngang</a></li>

            </ul>

         </div>

         <div class="box-body table-responsive">

            <table class="table table-bordered tablelte-full">

               <thead>

                  <tr>

                     <th>STT</th>

                     <th>Mã học viên</th>

                     <th>Họ tên</th>

                     <th>Hình ảnh</th>

                     <th>Ngày tạo</th>

                     <th>Đã thu</th>

                     <th>Nợ</th>

                     <th>Đang học</th>

                     <th>Thao tác</th>

                  </tr>

               </thead>

               <tbody>

                  <?php $count = 0; ?>

                  <?php foreach ($details as $package) { $count++; ?>

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

                        <?php

                        $payment = $debit = 0;

                        $CI = get_instance();

                        $course_member = $CI->course_member->get_many_by(array('member_id' => $package->id));

                        foreach ($course_member as $value) {

                           $payment += get_course_member_payment($value->id);

                        }

                        if($payment > 0)

                            echo '<span class="badge bg-green">'.number_format($payment).'<span>';

                        else echo 0;

                        ?>

                     </td>

                     <td>

                     <?php

                        foreach ($course_member as $value) {

                           $debit += $value->debit - get_course_member_debit($value->id);

                        }

                        if($debit > 0)

                           echo '<span class="badge bg-red">'.number_format($debit).'<span>';

                        else echo 0;

                        ?>

                     </td>

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

</section>



