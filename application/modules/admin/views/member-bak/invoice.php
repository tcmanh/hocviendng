
<section class="content">
   <div class="row">
      <div class="box box-info">
         <div class="box-body">
            <form action="<?php echo base_url('admin/member/invoice_print') ?>" method="POST" class="form-horizontal" role="form">
               <input type="text" name="member" value="<?php echo $member;?>">
               <input type="text" name="code" value="<?php echo $code;?>">
               <input type="text" name="import_id" value="<?php echo $import_id;?>">
               <input type="text" name="date" value="<?php echo $date;?>">
               <?php foreach ($result as $value) { ?>
               <input type="text" name="name[]" value="<?php echo $value->name;?>">
               <input type="text" name="price[]" value="<?php echo $value->price;?>">
               <input type="text" name="content[]" value="<?php echo $value->content;?>">
               <?php } ?>
               <button type="submit" class="btn btn-primary">In hóa đơn</button>
            </form>
         </div>
      </div>
   </div>
</section>
<script type="text/javascript">
   window.onload = function() { 
      $('button.btn-primary').trigger('click');
   }
</script>


