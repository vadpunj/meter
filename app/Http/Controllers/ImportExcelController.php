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
      $notin =  Electric::whereNotIn('meter_id', function($query){
          $query->select('meter_id')
          ->from(with(new Original)->getTable());
      })->get()->toArray();
      // dd($notin);

      return view('import_excel', ['type' => 'electric','data' => $data, 'data2' => $data2,'notin' => $notin]);
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
        if($value["bill_id"]){
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

      }


      if($insert){
        return back()->with('success', 'Excel Data Imported successfully.');

      }
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

      $notin =  Water::whereNotIn('meter_id', function($query){
          $query->select('meter_id')
          ->from(with(new Original)->getTable());
      })->get()->toArray();

      return view('import_excel', ['type' => 'water','data' => $data ,'data2' => $data2, 'notin' => $notin]);
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
       if($value["bill_id"]){
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

     }

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
      // dd($request->all());

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
      if($request->submit == "delete"){
        // Original::delete();
        DB::table('originals')->delete();
      }
      foreach($data->toArray() as $value){
        // dd($value);
        if($value["Merter_id"]){
          $insert = new Original;
          $insert->meter_id = $value["Merter_id"];
          $insert->utility = $value["Utility"];
          $insert->utility_type = $value['Utility_id'];
          $insert->business_id = $value['Business_id'];
          $insert->node1 = $value['Node1'];
          $insert->node2 = $value['Node2'];
          $insert->costcenter = $value['Costcenter'];
          $insert->gl = $value['GL'];
          $insert->business_process = $value['Business_Process'];
          $insert->product = $value['Product'];
          $insert->functional_area = $value['Functional_Area'];
          $insert->segment = $value['Segment'];
          $insert->key1 = $value['Reference_Key_1'];
          $insert->save();
        }

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

      if($insert){
        return back()->with('success', 'Excel Data Imported successfully.');
      }
    }


}
