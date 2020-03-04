jQuery(document).ready(function($){
	if($('.select2').length){
		$(".select2").select2();
	}
   if($('.tablelte-full').length){
      $('.tablelte-full').DataTable({ 
         "iDisplayLength": 50,
         "paging": true,
         "language": {
            "search": "Tìm kiếm",
            "lengthMenu": "Hiển thị _MENU_",
            "zeroRecords": "Không tìm thấy dữ liệu",
            "fo": "Đang hiển thị trang _PAGE_ ",
            "infoEmpty": "Không tìm thấy kết quả",
            "infoFiltered": "(Tìm kiếm trong tổng _MAX_ kết quả)",
            
            "paginate": {
               "first": "Đầu",
               "last": "Cuối",
               "next": "Sau",
               "previous": "Trước",
            }
         } 
         
      });
   }
   if($('#reportrange').length){
      $('#reportrange').daterangepicker({
         ranges: {
            'Hôm nay': [moment(), moment()],
            'Hôm qua': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            '7 ngày trước': [moment().subtract(6, 'days'), moment()],
            '30 ngày trước': [moment().subtract(29, 'days'), moment()],
            'Tháng này': [moment().startOf('month'), moment().endOf('month')],
            'Tháng trước': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
         }
      });
   }
   if($('.datepicker').length){
      $(".datepicker").datepicker({
         dateFormat: "yy-mm-dd"
      });
   }
});

