
<div class="row">
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>
            <div class="info-box-content">
                <a href="course">
            	<span class="info-box-text">Sắp khai giảng</span>
            	<span class="info-box-number"><?php echo $course_wait;?></span>
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-google-plus"></i></span>
            <div class="info-box-content">
                <a href="course">
            	<span class="info-box-text">Khóa đang học</span>
            	<span class="info-box-number"><?php echo $course_study;?></span>
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
      	<div class="info-box">
            <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>
            <div class="info-box-content">
                <a href="revenue">
            	<span class="info-box-text">Doanh số ngày</span>
            	<span class="info-box-number"><?php echo number_format($revenue_today);?></span>
                </a>
            </div>
        </div>
    </div>
   	<div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>
            <div class="info-box-content">
                <a href="revenue">
            	<span class="info-box-text">Doanh số tháng</span>
            	<span class="info-box-number"><?php echo number_format($revenue_month);?></span>
                </a>
            </div>
        </div>
    </div>
</div>

