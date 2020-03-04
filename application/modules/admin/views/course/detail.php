
<section class="content">
   <div class="row">
      <div class="box box-primary">
         <div class="box-body no-padding">
            <div id="calendar"></div>
         </div>
      </div>
   </div>
</section>
<?php //$this->start('scripts_foot') ?>
<style>
   span.fc-time{
      display: none !important;
   }
   span.fc-title{
      margin-top: 4px;
   }
   .fc-day-grid-event .fc-content{
      white-space: normal; 
   }
</style>
<script>
   $(function () {
      function init_events(ele) {
         ele.each(function () {
            var eventObject = {
               title: $.trim($(this).text())
            }
            $(this).data('eventObject', eventObject)
            $(this).draggable({
               zIndex        : 1070,
               revert        : true,
               revertDuration: 0
            })
         })
      }
      init_events($('#external-events div.external-event'))
      var date = new Date()
      var d    = date.getDate()
      var m    = date.getMonth()
      var y    = date.getFullYear()
      $('#calendar').fullCalendar({
         lang: 'vi',
         defaultDate: moment('<?php echo $defaultDate;?>'),
         header    : {
            left  : 'prev,next today',
            center: 'title',
            right : 'month,agendaWeek,agendaDay'
         },
         buttonText: {
            today: 'Hôm nay',
            month: 'tháng',
            week : 'tuần',
            day  : 'ngày'
         },
         events    : [
            <?php if(isset($list_checkin)){ foreach ($list_checkin as $value){ ?>
            {
               title          : '<?php echo $value->title;?>',
               start          : new Date(y, m, d <?php echo $value->date;?> ),
               end            : new Date(y, m, d <?php echo $value->date;?> ),
               backgroundColor: '<?php echo $value->color;?>',
               borderColor    : '<?php echo $value->color;?>'
            },
            <?php }} ?>
         ],     
      })
      var currColor = '#3c8dbc'
      var colorChooser = $('#color-chooser-btn')
      $('#color-chooser > li > a').click(function (e) {
         e.preventDefault()
         currColor = $(this).css('color')
         $('#add-new-event').css({ 'background-color': currColor, 'border-color': currColor })
      })
      $('#add-new-event').click(function (e) {
         e.preventDefault()
         var val = $('#new-event').val()
         if (val.length == 0) {
            return
         }
         var event = $('<div />')
         event.css({
            'background-color': currColor,
            'border-color'    : currColor,
            'color'           : '#fff'
         }).addClass('external-event')
         event.html(val)
         $('#external-events').prepend(event)
         init_events(event)
         $('#new-event').val('')
      })
   })
</script>
<?php //$this->stop() ?>
