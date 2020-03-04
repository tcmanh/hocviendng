<div class="row">
	<div class="col-md-12">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title">Thêm học viên</h3>
			</div>
			<div class="box-body">
				<form role="form" method="post" action="" class="form-horizontal" enctype="multipart/form-data">
	               	<div class="form-group">
	                  	<label class="col-sm-3 text-right">Mã học viên</label>
						<div class="col-sm-9">
	                  		<input type="text" name="code" class="form-control" />
	                  	</div>
	               	</div>
	               	<div class="form-group">
	                  	<label class="col-sm-3 text-right">Tên học viên</label>
	                  	<div class="col-sm-9">
	                  		<input type="text" name="name" class="form-control" />
	                  	</div>
	               	</div>
	               	<div class="form-group dv-blah" style="display: none">
		                <label class="col-xs-3 col-form-label"></label>
		                <div class="col-xs-9">
		                    <img id="blah" src="../assets/uploads/member/default.png" style="max-width: 400px" >
		                </div>
		            </div>
		            <div class="form-group">
	                  	<label class="col-sm-3 text-right">Avatar</label>
	                  	<div class="col-sm-9">
	                  		<input type="file" name="avatar" id="imgInp" class="form-control" value="" />
	                  	</div>
	               	</div>
	               	<div class="form-group">
	                  	<label class="col-sm-3 text-right">Số điện thoại</label>
	                  	<div class="col-sm-9">
	                  		<input type="text" class="form-control" name="phone" />
	                  	</div>
	               	</div>
	               	<div class="form-group">
	                  	<label class="col-sm-3 text-right">Ngày sinh</label>
	                  	<div class="col-sm-9">
	                  		<input name="birthday" type="text" value="" maxlength="10" class="datepicker form-control">
	                  	</div>
	               	</div>
	               	<div class="form-group">
                        <label for="" class="col-sm-3 control-label">Giới tính
                        	<span class='required'>*</span>                             
                        </label>
                        <div class="col-sm-9">
                            <div>
                            	<label>
                            		<input type="radio" name="gender" value="1" required /> Nữ
                            	</label> 
                            	<label>
                            		<input type="radio" name="gender" value="0" required  /> Nam
                            	</label>
                            </div>                            
                        </div>
                    </div>
	               	<div class="form-group">
	                  	<label class="col-sm-3 text-right">Mail</label>
	                  	<div class="col-sm-9">
	                  		<input type="text" class="form-control" name="mail" />
	                  	</div>
	               	</div>
	               	<div class="form-group">
	                  	<label class="col-sm-3 text-right">Địa chỉ</label>
	                  	<div class="col-sm-9">
	                  		<input type="text" class="form-control" name="address" />
	                  	</div>
	               	</div>
	               	<div class="form-group">
	                  	<label class="col-sm-3 text-right">Mô tả</label>
	                  	<div class="col-sm-9">
	                  		<textarea name="describe" class="form-control" rows="5" ></textarea>
	                  	</div>
	               	</div>
	               	<div class="form-group">
	                  	<label class="col-sm-3 text-right">Ghi chú</label>
	                  	<div class="col-sm-9">
	                  		<textarea name="note" class="form-control" rows="4" /></textarea>
	                  	</div>
	               	</div>
	               	<!--div class="form-group">
	               		<div class="col-sm-9 col-sm-offset-3">
		               		<table class="table table-reponsive table-bordered">
		               			<thead>
		               				<th>Tên khóa học</th>
		               				<th>Giá</th>
		               				<th>Cọc</th>
		               				<th>Ghi nợ</th>
		               				<th>Visa</th>
		               			</thead>
		               			<tbody>
		               				<tr>
		               					<td>
		               						<select class="form-control" name="service_id">
		               							<option value="">Chọn khóa học</option>
		               							<?php foreach($all_course as $service){ ?>
							                    <option value="<?php echo $service->id; ?>"><?php echo $service->name;?></option>
							                	<?php } ?>
		               						</select>
		               					</td>
		               					<td>
		               						<input type="text" name="total" min="0" class="form-control number" value="">
		               					</td>
		               					<td>
		               						<input type="text" name="pay" min="0" class="form-control number" value="">
		               					</td>
		               					<td>
		               						<input type="text" name="debit" min="0" class="form-control number" value="">
		               					</td>
		               					<td>
		               						<input type="text" name="visa" min="0" class="form-control number" value="">
		               					</td>
		               				</tr>
		               			</tbody>
		               		</table>
	               		</div>
	               		<div class="form-group">
		                  	<label class="col-sm-3 text-right">Ghi chú khóa học</label>
		                  	<div class="col-sm-9">
		                  		<textarea name="note_course" class="form-control" rows="4" /></textarea>
		                  	</div>
		               	</div>
	               	</div-->
	               	<div class="col-sm-9 col-sm-offset-3">
	               		<button type="submit" name="add-member" class="btn btn-success">Lưu</button>
	               	</div>
	            </form>
			</div>
		</div>
	</div>
</div>