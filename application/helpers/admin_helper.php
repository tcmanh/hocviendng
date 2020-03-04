<?php

function plugins_url($path){
   return base_url('assets/plugins/'.$path);
}

function all_course(){
   $CI = get_instance();
   $CI->load->model('course_model', 'course');
   $all_course  = $CI->course->get_many_by(array('status' => 1 ));
   return $all_course;
}

function get_user($id = NULL){
   $CI = get_instance();
   $CI->load->model('ion_auth_model');
   $user = $CI->ion_auth_model->user($id)->row();
   if($user){
      $fullname = $user->first_name . ' ' . $user->last_name;
      $user->display_name = $fullname;
      $user->user_email = $user->email;
      $user->ID = $user->id;
      $user->avatar_url = (isset($user->avatar_url) && !empty($user->avatar_url) && file_exists(AVATAR_PATH.'/'.$user->avatar_url)) ? base_url().AVATAR_PATH.'/'.$user->avatar_url : base_url().AVATAR_PATH.'/default.png';
      return $user;
   }else{
      return false;
   }
}

function call_curl($url){
   $user = json_decode(  
      file_get_contents($url)
   );  
   return $user; 
}

function is_admin(){
   $current_users = get_current_users();
   //echo '<pre>$current_users';print_r($current_users);echo '</pre>';die();
   foreach ($current_users->users_groups as $key => $value) {
      if($value->description == 'admin') return TRUE;
   }
   return FALSE;
}


function is_teacher(){
   $current_users = get_current_users();
   $admin_array = array('admin', 'manager', 'accountant');
   $user_array = array();
   foreach ($current_users->users_groups as $key => $value) {
      if (in_array($value->description, $admin_array)) {
         return FALSE;
      }else{
         $user_array[] = $value->description;
      }
   }
   if (in_array('teacher', $user_array)) {
      return TRUE;
   }
   return FALSE;
}

function get_current_users(){
   $CI = get_instance();
   $CI->load->model('user_model', 'user');
   $CI->load->model('users_group_model', 'users_group');
   $current_user_id = $CI->session->userdata('user_id');

   $result = new stdClass();
   $result = $CI->user->get($current_user_id);
   $groups = $CI->users_group->get_many_by(array('user_id' => $current_user_id));
   
   $duong_groups = array();
   foreach ($groups as $key => $value) {
      $duong_groups[] = $value->group_id;
   }

   if( ($current_user_id != 1) && !in_array(2,  $duong_groups) && !in_array(8,  $duong_groups)){
      echo '<pre>';print_r('Tài khoản này không thể quản trị học viên');echo '</pre>';die();
   }
   //die();
   //echo $CI->db->last_query();
   //die;
   $result->users_groups = $groups;
   return $result;
}

function get_current_user_groups(){
   $CI = get_instance();
   $CI->load->model('users_group_model', 'users_group');
   $current_user_id = $CI->session->userdata('user_id');
   $groups = $CI->users_group->get_many_by(array('user_id' => $current_user_id));
   return $groups;
}

function get_current_user_id(){
   $CI = get_instance();
   $current_user_id = $CI->session->userdata('user_id');
   return $current_user_id;
}

function get_current_fullname(){
   $get_current_user_id = get_current_user_id();
   return get_user_fullname($get_current_user_id);
}

function get_user_fullname($id = NULL){ 
   $CI = get_instance();
   $CI->load->model('user_model', 'user');
   $current_user_id = $CI->session->userdata('user_id');
   $result = $CI->user->get($id);
   if($result){
      return $result->first_name.' '.$result->last_name;
   }else{
      return 'Uknow';
   }
}

function get_teacher_name($id = NULL){
   if(empty($id))
      return 'Uknow';
   $CI = get_instance();
   $member = $CI->db->query("SELECT * FROM teachers WHERE id = ".$id." ")->row();
   return (isset($member)) ? $member->first_name.' '.$member->last_name: 'Unknow';
}

function get_member_name($id = NULL){
   if(empty($id))
      return 'Uknow';
   $CI = get_instance();
   $member = $CI->db->query("SELECT name FROM member WHERE id = ".$id." ")->row();
   return (isset($member)) ? $member->name: 'Unknow';
}

function get_course_member_debit($card_package_id){
   $CI = get_instance();
   $CI->db->select("SUM(price) as total");
   $CI->db->from('course_member_debit');
   $CI->db->where('course_member_id', $card_package_id);
   $CI->db->group_by('course_member_id');
   $card_package_debit = $CI->db->get()->row();
   if($card_package_debit){
      return $card_package_debit->total;
   }
   else{
      return 0;
   }
}

function get_course_member_payment($course_member_id){
   $CI = get_instance();
   $course_member = $CI->db->query("SELECT SUM(pay) as pay FROM course_member WHERE id = ".$course_member_id." ")->row();
   $course_member_debit = $CI->db->query("SELECT SUM(price) as price FROM course_member_debit WHERE course_member_id = ".$course_member_id." GROUP BY course_member_id ")->row();
   if(empty($course_member_debit)){
      return $course_member->pay;
   }else{
      return $course_member->pay + $course_member_debit->price;
   }
}

function check_checkin($course_member_id){
   $CI = get_instance();
   $CI->load->model('course_member_checkin_model', 'course_member_checkin');
   $check = $CI->course_member_checkin->get_by(array('date' => date('Y-m-d'), 'course_member_id' => $course_member_id, 'status' => 1 ));
   if($check){
      return '<input class="green" data-action="checkin" data-course_member_id="'.$course_member_id.'" type="radio" value="true" checked name="'.$course_member_id.'" >';
   }
   else{
      return '<input  class="default" data-action="checkin" data-course_member_id="'.$course_member_id.'" type="radio" name="'.$course_member_id.'" >';
   }
}

function check_checklate($course_member_id){
   $CI = get_instance();
   $CI->load->model('course_member_checkin_model', 'course_member_checkin');
   $check = $CI->course_member_checkin->get_by(array('date' => date('Y-m-d'), 'course_member_id' => $course_member_id, 'status' => 4 ));
   if($check){
      return '<input class="blue" data-action="checklate" data-course_member_id="'.$course_member_id.'" type="radio" value="true" checked name="'.$course_member_id.'" >';
   }
   else{
      return '<input  class="default" data-action="checklate" data-course_member_id="'.$course_member_id.'" type="radio" name="'.$course_member_id.'" >';
   }
}

function check_checkout($course_member_id){
   $CI = get_instance();
   $CI->load->model('course_member_checkin_model', 'course_member_checkin');
   $check = $CI->course_member_checkin->get_by(array('date' => date('Y-m-d'), 'course_member_id' => $course_member_id, 'status >' => 1, 'status <' => 4 ));
   if($check){ 
      if($check->status == 2){
         $class='orange';
      }
      if($check->status == 3){
         $class='red';
      }
      return '<input class="'.$class.'" data-action="checkout" data-course_member_id="'.$course_member_id.'" type="radio" value="true" checked name="'.$course_member_id.'" >';
   }
   else{
      return '<input class="default" data-action="checkout" data-course_member_id="'.$course_member_id.'" type="radio" name="'.$course_member_id.'" >';
   }
}

function get_course_member_debit_visa($card_package_id){
   $CI = get_instance();
   $CI->db->select("SUM(visa) as total");
   $CI->db->from('course_member_debit');
   $CI->db->where('course_member_id', $card_package_id);
   $CI->db->group_by('course_member_id');
   $card_package_debit = $CI->db->get()->row();
   if($card_package_debit){
      return $card_package_debit->total;
   }
   else{
      return 0;
   }
}

function get_course_name($id){
   $CI = get_instance();
   $query = $CI->db->query("SELECT * FROM course WHERE id = '$id' ");
   return $query->row()->name;
}

function get_class_name($id){
   if($id == 0) return 'Chưa chọn';
   $CI = get_instance();
   $query = $CI->db->query("SELECT * FROM class WHERE id = '$id' ")->row();
   if($query) return $query->name;
   return 'Uknow';
}

function get_teachers(){
   $CI = get_instance();
   $query = $CI->db->query("SELECT * FROM teachers ")->result();
   return $query;
}

function get_teachers_by_course($course_id){
   $CI = get_instance();
   $query = $CI->db->query("SELECT * FROM course WHERE id = '$course_id' ")->row();
   return get_user_fullname($query->user_id);
}

function update_revenue($date){
   //$date = date('Y-m-d');
   //$date = '2018-03-02'; 

   $CI = get_instance();
   $CI->load->model('revenue_model', 'revenue');

   $revenue = array(
      'revenue' => 0,
      'debit' => 0,
      'amount' => 0,
      'visa' => 0
   );

   $course_member = $CI->db->query("SELECT SUM(pay) as total_pay, SUM(debit) as total_debit, SUM(amount) as total_amount, SUM(visa) as total_visa FROM course_member WHERE created = '".$date."' GROUP BY created ")->row();
   if(!empty($course_member)){
      $revenue['revenue'] += $course_member->total_pay;
      $revenue['debit'] += $course_member->total_debit;
      $revenue['amount'] += $course_member->total_amount;
      $revenue['visa'] += $course_member->total_visa;      
   }

   $course_member_debit = $CI->db->query("SELECT SUM(price) as total_price, SUM(amount) as total_amount, SUM(visa) as total_visa FROM course_member_debit WHERE created = '".$date."' GROUP BY created ")->row();

   if(!empty($course_member_debit)){
      $revenue['revenue'] += $course_member_debit->total_price;
      $revenue['amount'] += $course_member_debit->total_amount;
      $revenue['visa'] += $course_member_debit->total_visa;
   }
   $check_revenue = $CI->revenue->get_by(array('date' => $date));
   if($check_revenue){
      //update
      $CI->revenue->update($check_revenue->id, $revenue);
   }else{
      //insert
      $revenue['date'] = $date;
      $CI->revenue->insert($revenue);
   }
}

function count_member_of_course($course_id){
   $CI = get_instance();
   $query = $CI->db->query("SELECT COUNT(id) as total FROM course_member WHERE course_id = '$course_id' AND status < 2 ")->row();
   if($query){
      return $query->total;
   }else{
      return 0;
   }
}

function count_member_of_class($course_id){
   $CI = get_instance();
   $query = $CI->db->query("SELECT COUNT(id) as total FROM course_member WHERE class_id = '$course_id' AND status < 2 ")->row();
   if($query){
      return $query->total;
   }else{
      return 0;
   }
}

function convert_number_to_words( $number )
{
   $hyphen = ' ';
   $conjunction = '  ';
   $separator = ' ';
   $negative = 'âm ';
   $decimal = ' phẩy ';
   $dictionary = array(
      0 => 'Không',
      1 => 'Một',
      2 => 'Hai',
      3 => 'Ba',
      4 => 'Bốn',
      5 => 'Năm',
      6 => 'Sáu',
      7 => 'Bảy',
      8 => 'Tám',
      9 => 'Chín',
      10 => 'Mười',
      11 => 'Mười một',
      12 => 'Mười hai',
      13 => 'Mười ba',
      14 => 'Mười bốn',
      15 => 'Mười năm',
      16 => 'Mười sáu',
      17 => 'Mười bảy',
      18 => 'Mười tám',
      19 => 'Mười chín',
      20 => 'Hai mươi',
      30 => 'Ba mươi',
      40 => 'Bốn mươi',
      50 => 'Năm mươi',
      60 => 'Sáu mươi',
      70 => 'Bảy mươi',
      80 => 'Tám mươi',
      90 => 'Chín mươi',
      100 => 'trăm',
      1000 => 'ngàn',
      1000000 => 'triệu',
      1000000000 => 'tỷ',
      1000000000000 => 'nghìn tỷ',
      1000000000000000 => 'ngàn triệu triệu',
      1000000000000000000 => 'tỷ tỷ'
   );
   if( !is_numeric( $number ) )
   {
      return false;
   }
   if( ($number >= 0 && (int)$number < 0) || (int)$number < 0 - PHP_INT_MAX )
   {
      // overflow
      trigger_error( 'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX, E_USER_WARNING );
      return false;
   }
   if( $number < 0 )
   {
      return $negative . convert_number_to_words( abs( $number ) );
   }
   $string = $fraction = null;
   if( strpos( $number, '.' ) !== false )
   {
      list( $number, $fraction ) = explode( '.', $number );
   }
   switch (true)
   {
      case $number < 21:
         $string = $dictionary[$number];
         break;
      case $number < 100:
         $tens = ((int)($number / 10)) * 10;
         $units = $number % 10;
         $string = $dictionary[$tens];
         if( $units )
         {
            $string .= $hyphen . $dictionary[$units];
         }
         break;
      case $number < 1000:
         $hundreds = $number / 100;
         $remainder = $number % 100;
         $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
         if( $remainder )
         {
            $string .= $conjunction . convert_number_to_words( $remainder );
         }
         break;
      default:
         $baseUnit = pow( 1000, floor( log( $number, 1000 ) ) );
         $numBaseUnits = (int)($number / $baseUnit);
         $remainder = $number % $baseUnit;
         $string = convert_number_to_words( $numBaseUnits ) . ' ' . $dictionary[$baseUnit];
         if( $remainder )
         {
            $string .= $remainder < 100 ? $conjunction : $separator;
            $string .= convert_number_to_words( $remainder );
         }
         break;
   }
   if( null !== $fraction && is_numeric( $fraction ) )
   {
      $string .= $decimal;
      $words = array( );
      foreach( str_split((string) $fraction) as $number )
      {
         $words[] = $dictionary[$number];
      }
      $string .= implode( ' ', $words );
   }
   return $string;
}


function call_api($method = 'POST', $url, $data = array()){
   $data_string = json_encode($data); //print_r($data); die;
   $curl = curl_init($url);
   curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
   curl_setopt($curl, CURLOPT_HTTPHEADER, array(
      'Content-Type: application/json',
      'Content-Length: ' . strlen($data_string))
   );
   curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // Make it so the data coming back is put into a string
   curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);  // Insert the data
   // Send the request
   $result = curl_exec($curl);
   return json_decode($result);
}

function get_option($name){
   $CI = get_instance();
   $CI->load->model('option_model', 'option');
   $option = $CI->option->get_by(array('name' => $name));
   if($option) return $option->value;
   return '';
}