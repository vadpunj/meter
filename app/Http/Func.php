<?php
// Helpers files
use Illuminate\Support\Facades\Auth;
use App\User;

class Func{
  public static function get_date($value)
  {
    $m = date('m',strtotime($value));
    $month = ['','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

    $year = date('Y',strtotime($value));
    $day = date('d',strtotime($value));


    return $day.' '.$month[$m].' '.$year;

  }

  public static function get_name_month($value)
  {
    $month = ['','ม.ค.','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    return $month[$value];
  }

  public static function get_name_user($id)
  {
    $row = User::where('emp_id',$id)->first();
    if(!$row){
      return '';
    }else{
      return $row->name;
    }

  }
}

 ?>
