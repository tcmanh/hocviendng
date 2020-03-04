<link rel="stylesheet" href="../../assets/plugins/bootstrap/bootstrap.min.css">

<!-- jQuery library -->
<script src="./../assets/plugins/bootstrap/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="./../assets/plugins/bootstrap/bootstrap.min.js"></script>

<img src="../../assets/img/header.png" width="100%" style="margin-top: .4cm; margin-bottom: .6cm">
<div class="row invoice-info" style="margin-bottom: .3cm !important">
   <div class="col-xs-6" style="margin-top: 38px">
      <p>Học viên: <?php echo (isset($_POST['member'])) ? $_POST['member'] : ''; ?></p>
      <p>Mã học viên: <?php echo (isset($_POST['code'])) ? $_POST['code'] : ''; ?></p>
   </div>
   <div class="col-xs-6">
      <h3 style="margin-top: 0">PHIẾU THU</h3>
      <p>Ngày: <?php echo (isset($_POST['date'])) ? $_POST['date'] : ''; ?></p>
      <p>Nhân viên: <?php echo (isset($_POST['import_id'])) ? $_POST['import_id'] : ''; ?></p>
   </div>
</div>
<div class="row" style="-webkit-print-color-adjust: exact; margin-top: .3cm">
   <div class="col-xs-12 table-responsive">
      <table class="table" style="margin-bottom: .5cm !important">
         <thead>
            <tr>
               <th>Khóa học</th>
               <th>Nội dung</th>
               <th>Thành tiền</th>
            </tr>
         </thead>
         <?php if(isset($_POST['name'])){ ?>
         <tbody>
            <?php 
            $total = 0;
            for ($i=0; $i < count($_POST['name']); $i++) {
            $total += $_POST['price'][$i];?>
            <tr>
               <td><?php echo (isset($_POST['name'][$i])) ? $_POST['name'][$i] : ''; ?></td>
               <td><?php echo (isset($_POST['content'][$i])) ? $_POST['content'][$i] : ''; ?></td>
               <td><?php echo number_format($_POST['price'][$i]); ?> VNĐ</td>
            </tr>
            <?php } ?>
         </tbody>
         <?php } ?>
         <?php if($total > 0){ ?>
         <tfoot>
            <tr>
               <td colspan="2">
                  Số tiền bằng chữ:<br> <span><?php echo convert_number_to_words($total) ?> việt nam đồng</span>
               </td>
               <td class="total_count" style="font-size: 14px"><span><?php echo number_format($total) ?> VNĐ</span></td>
            </tr>
         </tfoot>
         <?php } ?>
      </table>
      <div style="overflow: hidden: margin: 20px 0">
         <div style="width: 50%; float: left; text-align: center; font-weight: 600">
            Người nhận tiền
         </div>
         <div style="width: 50%; float: left; text-align: center; font-weight: 600">
            Người nộp tiền
         </div>
      </div>
   </div>
</div>
<img src="../../assets/img/footer.png" width="100%" style="position: fixed;bottom:.4cm;left:0;right:0">
<script type="text/javascript">
   window.onload = function() { window.print(); }
</script>
<style type="text/css"  media="print">
   tbody{
      font-size: 13px;
   }
   @page {
      size: auto; 
      margin: 0 40px;
   }
   @media print {
      a[href]:after {
         content: none !important;
      }
   }
</style>

