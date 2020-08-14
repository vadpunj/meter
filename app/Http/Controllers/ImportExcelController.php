<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Excel;
// use Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Log_user;
use App\Electric;
use App\Original;
use App\Utility;
use App\Water;

class ImportExcelController extends Controller
{
    public function index_electric()
    {
      $end_day = date('Y-m-t');
      $first_day = date('Y-m-d', strtotime("first day of last month"));

      $data = Electric::groupBy(DB::raw('MONTH(date),YEAR(date),business_process,product,functional_area,segment'))
        ->selectRaw('MONTH(date) as month,YEAR(date) as year,sum(price) as price,business_process,product,functional_area,segment')
        ->whereBetween('date', [$first_day, $end_day])
        ->get()
        ->toArray();
        // dd($data);

      $data2 = Electric::groupBy(DB::raw('MONTH(date),YEAR(date)'))
        ->selectRaw('MONTH(date) as month,YEAR(date) as year,sum(price) as price')
        ->whereBetween('date', [$first_day, $end_day])
        ->get()
        ->toArray();
      // return view('import_excel', ['type' => 'electric','data' => $data]);

      return view('import_excel', ['type' => 'electric','data' => $data, 'data2' => $data2]);
    }

    public function import_electric(Request $request)
    {
      config(['excel.import.heading' => 'original' ]);
      set_time_limit(0);
      $this->validate($request, [
        'select_file'  => 'required|mimes:xlsx'
      ]);
      // delete ก่อน insert
      // $delete_data = Electric::where('TIME_KEY',$request->time_key)->delete();
      $path = $request->file('select_file')->getRealPath();
      $name = $request->file('select_file')->getClientOriginalName();
      $pathreal = Storage::disk('log')->getAdapter()->getPathPrefix();
      Storage::disk('log')->put($name, File::get($request->file('select_file')));
      $data = Excel::load($path)->get();
     // dd($data);

      $insert_log = new Log_user;
      $insert_log->user_id = Auth::user()->emp_id;
      $insert_log->path = $pathreal.$name;
      $insert_log->type_log = 'electric';
      $insert_log->save();

      // $key_name = ['bill_id','meter_id','date','price','costcenter','gl','business_process','product','functional_area','segment'];

      foreach($data->toArray() as $value){
        // dd($value);
         $insert = new Electric;
         $insert->bill_id = $value["bill_id"];
         $insert->meter_id = $value["meter_id"];
         $insert->date = $value["date"];
         $insert->price = round($value["money"],2);
         $insert->costcenter = $value["costcenter"];
         $insert->gl = $value["gl"];
         $insert->business_process = $value["business_process"];
         $insert->product = $value["product"];
         $insert->functional_area = $value["functional_area"];
         $insert->segment = $value["segment"];
         $insert->save();
      }

//       if($data->count() > 0){
//         $num = 0;
//         foreach($data->toArray() as $key => $value){
//           $i = 0;
//           foreach($value as $row){
//             $insert_data[$num][$key_name[$i]] = $row;
//             $num++;
//             $i++;
//           }
//         }
// // dd($insert_data);
//         if(!empty($insert_data)){
//           for($j = 0; $j < count($insert_data); $j++ ){
//             $insert = new Electric;
//             $insert->bill_id = $insert_data[$j++]['bill_id'];
//             $insert->meter_id = $insert_data[$j++]['meter_id'];
//             $insert->date = $insert_data[$j++]['date'];
//             $insert->price = round($insert_data[$j++]['price'],2);
//             $insert->costcenter = $insert_data[$j++]['costcenter'];
//             $insert->gl = $insert_data[$j++]['gl'];
//             $insert->business_process = $insert_data[$j++]['business_process'];
//             $insert->product = $insert_data[$j++]['product'];
//             $insert->functional_area = $insert_data[$j++]['functional_area'];
//             $insert->segment = $insert_data[$j]['segment'];
//             $insert->save();
//           }
//         }
//       }
     return back()->with('success', 'Excel Data Imported successfully.');
    }

    public function index_water()
    {
      $end_day = date('Y-m-t');
      $first_day = date('Y-m-d', strtotime("first day of last month"));

      $data = Water::groupBy(DB::raw('MONTH(date),YEAR(date),business_process,product,functional_area,segment'))
        ->selectRaw('MONTH(date) as month,YEAR(date) as year,sum(price) as price,business_process,product,functional_area,segment')
        ->whereBetween('date', [$first_day,$end_day])
        ->get()
        ->toArray();
// dd($data);
      $data2 = Water::groupBy(DB::raw('MONTH(date),YEAR(date)'))
        ->selectRaw('MONTH(date) as month,YEAR(date) as year,sum(price) as price')
        ->whereBetween('date', [ $first_day,$end_day])
        ->get()
        ->toArray();

      return view('import_excel', ['type' => 'water','data' => $data ,'data2' => $data2]);
    }

    public function import_water(Request $request)
    {
      config(['excel.import.heading' => 'original' ]);
      set_time_limit(0);
      $this->validate($request, [
        'select_file'  => 'required|mimes:xlsx'
      ]);
// dd('34242');
     // $delete_data = Water::where('TIME_KEY',$request->time_key)->delete();

     $path = $request->file('select_file')->getRealPath();
     $name = $request->file('select_file')->getClientOriginalName();
     $pathreal = Storage::disk('log')->getAdapter()->getPathPrefix();
     Storage::disk('log')->put($name, File::get($request->file('select_file')));
     $data = Excel::load($path)->get();
     // เก็บข้อมูลว่าใครเป็นคน insert file เข้าระบบ
     $insert_log = new Log_user;
     $insert_log->user_id = Auth::user()->emp_id;
     $insert_log->path = $pathreal.$name;
     $insert_log->type_log = 'water';
     $insert_log->save();
     // $key_name = ['bill_id','meter_id','date','price','costcenter','gl','business_process','product','functional_area','segment'];

     foreach($data->toArray() as $value){
       // dd($value);
        $insert = new Water;
        $insert->bill_id = $value["bill_id"];
        $insert->meter_id = $value["meter_id"];
        $insert->date = $value["date"];
        $insert->price = round($value["money"],2);
        $insert->costcenter = $value["costcenter"];
        $insert->gl = $value["gl"];
        $insert->business_process = $value["business_process"];
        $insert->product = $value["product"];
        $insert->functional_area = $value["functional_area"];
        $insert->segment = $value["segment"];
        $insert->save();
     }
     // if($data->count() > 0){
     //   $num = 0;
     //  foreach($data->toArray() as $key => $value)
     //  {
     //    $i = 0;
     //   foreach($value as $row)
     //   {
     //    $insert_data[$num][$key_name[$i]] = $row;
     //    $num++;
     //    $i++;
     //   }
     //  }
     //  if(!empty($insert_data))
     //  {
     //    for($j = 0; $j < count($insert_data); $j++ ){
     //      $insert = new Water;
     //      $insert->bill_id = $insert_data[$j++]['bill_id'];
     //      $insert->meter_id = $insert_data[$j++]['meter_id'];
     //      $insert->date = $insert_data[$j++]['date'];
     //      $insert->price = round($insert_data[$j++]['price'],2);
     //      $insert->costcenter = $insert_data[$j++]['costcenter'];
     //      $insert->gl = $insert_data[$j++]['gl'];
     //      $insert->business_process = $insert_data[$j++]['business_process'];
     //      $insert->product = $insert_data[$j++]['product'];
     //      $insert->functional_area = $insert_data[$j++]['functional_area'];
     //      $insert->segment = $insert_data[$j]['segment'];
     //      $insert->save();
     //    }
     //
     //  }
     // }
     if($insert){
       return back()->with('success', 'Excel Data Imported successfully.');
     }
    }
    public function index_original()
    {
      // dd(2323);
      $data = Original::get();
      return view('source_import',['data' => $data]);
    }

    public function import_original(Request $request)
    {
      config(['excel.import.heading' => 'original' ]);
      set_time_limit(0);
      $this->validate($request, [
        'select_file'  => 'required|mimes:xlsx'
      ]);

     // $delete_data = Water::where('TIME_KEY',$request->time_key)->delete();

      $path = $request->file('select_file')->getRealPath();
      $name = $request->file('select_file')->getClientOriginalName();
      $pathreal = Storage::disk('log')->getAdapter()->getPathPrefix();
      Storage::disk('log')->put($name, File::get($request->file('select_file')));
      $data = Excel::load($path)->get();

     // เก็บข้อมูลว่าใครเป็นคน insert file เข้าระบบ
      $insert_log = new Log_user;
      $insert_log->user_id = Auth::user()->emp_id;
      $insert_log->path = $pathreal.$name;
      $insert_log->type_log = 'original';
      $insert_log->save();

// dd($data->toArray());
      foreach($data->toArray() as $value){
        // dd($value);
        $insert = new Original;
        $insert->meter_id = $value["merter_id"];
        $insert->utility = $value["utility"];
        $insert->utility_type = $value['utility_id'];
        $insert->business_id = $value['business_id'];
        $insert->node1 = $value['node1'];
        $insert->node2 = $value['node2'];
        $insert->costcenter = $value['costcenter'];
        $insert->gl = $value['gl'];
        $insert->business_process = $value['business_process'];
        $insert->product = $value['product'];
        $insert->functional_area = $value['functional_area'];
        $insert->segment = $value['segment'];
        $insert->key1 = $value['reference_key_1'];
        $insert->save();
        // dd($value["merter_id"]);
      }

    // insert utility ที่มีในไฟล์ excel ลงตารางutility อัตโนมัติ
    $all = DB::table('originals')
          ->whereNotIn('utility_type', DB::table('utilities')->pluck('utility_type'))
          ->select('utility_type','utility')
          ->groupBy('utility_type','utility')
          ->get()->toArray();
          for($i = 0; $i < count($all); $i++){
            $insert = new Utility;
            $insert->utility = $all[$i]->utility;
            $insert->utility_type = $all[$i]->utility_type;
            $insert->save();
          }

     return back()->with('success', 'Excel Data Imported successfully.');
    }


}
