<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Transaction;
use App\Branch;
use App\Log_user;
use App\Original;
use App\Utility;
use App\Water;
use App\Electric;
use DB;
use Excel;
use Func;

class InputController extends Controller
{
    public function home_page()
    {
      return view('dashboard');
    }
    public function get_home()
    {

      return view('home');

    }

    public function get_home_view()
    {
      // $list = Transaction::all()->toArray();
      $list = DB::table('transactions')
            ->join('branches', 'branches.branch_id', '=', 'transactions.branch_id')
            ->select('branches.branch_name','transactions.*')
            ->get();
      return view('view_home',['list' => $list]);
    }

    public function get_home_edit($id)
    {
      $data = Transaction::find($id)->first();
      return view('home_edit',['data' => $data]);
    }

    public function get_branch()
    {
      $branch_list = Branch::all()->toArray();
      return view('branch',['list' => $branch_list]);

    }

    public function post_home(Request $request)
    {

      $start_date = $request->start_date;
      $end_date = $request->end_date;
      $source = $request->source;
      $branch = $request->branch;

      $this->validate($request,[
         'start_date'=>'required|date',
         'end_date'=>'required|date',
         'source' => 'required',
         'branch' => 'required|numeric'
      ]);


      $people = new Transaction;
      $people->branch_id = $branch;
      $people->source = $source;
      $people->start_date = $start_date;
      $people->end_date = $end_date;
      $people->user_id = Auth::user()->emp_id;
      $save = $people->save();

      return view('home');
    }

    public function post_home_edit(Request $request)
    {
      $start_date = $request->start_date;
      $end_date = $request->end_date;
      $source = $request->source;
      $branch_id = $request->branch;
      $id = $request->id;

      $this->validate($request,[
         'start_date'=>'required|date',
         'end_date'=>'required|date',
         'source' => 'required',
         'branch' => 'required|numeric'
      ]);

      $people = Transaction::find($id);
      $people->branch_id = $branch_id;
      $people->source = $source;
      $people->start_date = $start_date;
      $people->end_date = $end_date;
      $people->user_id = Auth::user()->emp_id;
      $save = $people->save();

      $list = DB::table('transactions')
            ->join('branches', 'branches.branch_id', '=', 'transactions.branch_id')
            ->select('branches.branch_name','transactions.*')
            ->get();
      return view('view_home',['list' => $list]);

    }

    public function post_branch(Request $request)
    {
// dd($request->branch_id);
      $branch_id = $request->branch_id;
      $branch = $request->branch;

      $this->validate($request,[
         'branch_id' => 'required|numeric',
         'branch' => 'required'
      ]);


      $people = new Branch;
      $people->branch_id = $branch_id;
      $people->branch_name = $branch;
      $people->user_id = Auth::user()->emp_id;
      $save = $people->save();

      $branch_list = Branch::all()->toArray();
      return view('branch',['list' => $branch_list]);
    }

    public function edit_branch(Request $request)
    {
      $branch_id = $request->branch_id;
      $branch_name = $request->branch_name;
      $id = $request->id;

      $this->validate($request,[
         'branch_id' => 'required|numeric',
         'branch_name' => 'required'
      ]);

      $people = Branch::find($id);
      $people->branch_id = $branch_id;
      $people->branch_name = $branch_name;
      $people->user_id = Auth::user()->emp_id;
      $save = $people->save();

      $branch_list = Branch::all()->toArray();
      return view('branch',['list' => $branch_list]);
    }

    public function delete_branch(Request $request)
    {
      $id = $request->id;
      $branch_id = $request->branch_id;
      $branch_name = $request->branch_name;

      $people = Branch::find($id);
      $people->delete();

      // $user = new Delete;
      // $user->user_id = Auth::user()->emp_id;
      // $user->detail = 'id:'.$branch_id." name:".$branch_name;
      // $user->save();

      $branch_list = Branch::all()->toArray();
      return view('branch',['list' => $branch_list]);
    }

    public function delete_source(Request $request)
    {
      $id = $request->id;
      $source = $request->source;

      $people = Transaction::find($id);
      $people->delete();

      // $user = new Delete;
      // $user->user_id = Auth::user()->emp_id;
      // $user->detail = 'id'.$id.' branch_id:'.$id." source:".$source;
      // $user->save();

      $list = DB::table('transactions')
            ->join('branches', 'branches.branch_id', '=', 'transactions.branch_id')
            ->select('branches.branch_name','transactions.*')
            ->get();
      return view('view_home',['list' => $list]);
    }

    public function ajax_data()
    {
      $branch = $_POST['data'];
      $data = Branch::where('branch_id',$branch)->first();
      if(!empty($data)){
        return response()->json(['success' => $data->branch_name]);
      }else{
        return response()->json(['success' => 'ไม่มีสาขาที่กรอก']);
      }

    }

    public function view_source()
    {
      $data = Utility::get();
      return view('source_view',['data' => $data]);
    }
    public function post_view_source(Request $request)
    {
      $this->validate($request,[
         'center_money' => 'required',
         'utility_type' => 'required',
         'start_date' => 'required',
         'end_date' => 'required'
      ]);

      $center_money = $request->center_money;
      $utility_type = $request->utility_type;
      $start_date = date('Y-m-d',strtotime($request->start_date));
      $end_date = date('Y-m-d',strtotime($request->end_date));

      // check string
      $str = Func::get_utility($utility_type);
      $pattern = "/ไฟฟ้า/i";
      // dd($str);


      if(preg_match($pattern, $str) == "0"){
        $list = DB::table('waters')
          ->join('originals', 'originals.meter_id', '=', 'waters.meter_id')
          ->select('waters.meter_id', 'originals.node1','originals.node2', DB::raw('SUM(price) as price'))
          ->where('waters.costcenter',$center_money)
          ->where('originals.utility_type',$utility_type)
          ->whereBetween('waters.date', [$start_date, $end_date])
          ->groupBy('waters.meter_id','originals.node1','originals.node2')
          ->get()->toArray();
      }else{
        $list = DB::table('electrics')
          ->join('originals', 'originals.meter_id', '=', 'electrics.meter_id')
          ->select('electrics.meter_id', 'originals.node1','originals.node2', DB::raw('SUM(price) as price'))
          ->where('electrics.costcenter',$center_money)
          ->where('originals.utility_type',$utility_type)
          ->whereBetween('electrics.date', [$start_date, $end_date])
          ->groupBy('electrics.meter_id','originals.node1','originals.node2')
          ->get()->toArray();
      }

            // dd($list);
      $data = Utility::get();
      return view('source_view',['data' => $data ,'list' => $list ,'request' => $request->all()]);
    }

    public function add_source()
    {
      $data = Utility::get();
      return view('source_add',['data' => $data]);
    }

    public function post_source(Request $request)
    {
      $meter_id = $request->meter_id;
      $arr_uti = explode(",",$request->utility);

      $utility = $arr_uti[1];
      $utility_type = $arr_uti[0];
      $business_id = $request->business_id;
      $node1 = $request->node1;
      $node2 = $request->node2;
      $costcenter = $request->costcenter;
      $gl = $request->gl;
      $business_process = $request->business_process;
      $product = $request->product;
      $functional_area = $request->functional_area;
      $segment = $request->segment;
      $key1 = $request->key1;

      $insert = new Original;
      $insert->meter_id = $meter_id;
      $insert->utility = $utility;
      $insert->utility_type = $utility_type;
      $insert->business_id = $business_id;
      $insert->node1 = $node1;
      $insert->node2 = $node2;
      $insert->costcenter = $costcenter;
      $insert->gl = $gl;
      $insert->business_process = $business_process;
      $insert->product = $product;
      $insert->functional_area = $functional_area;
      $insert->segment = $segment;
      $insert->key1 = $key1;
      $insert->save();

      $insert_log = new Log_user;
      $insert_log->user_id = Auth::user()->emp_id;
      // $insert_log->user_name = 'phats';
      $insert_log->path = "";
      $insert_log->type_log = 'original';
      $insert_log->save();

      if($insert){
        return back()->with('success', 'บันทึกข้อมูลแล้ว');
      }
      // return redirect()->route('add_source');
    }

    public function post_utility(Request $request)
    {

      $utility = $request->utility;
      $utility_type = $request->utility_type;

      $this->validate($request,[
         'utility' => 'required',
         'utility_type' => 'required|numeric'
      ]);

      $insert = new Utility;
      $insert->utility = $utility;
      $insert->utility_type = $utility_type;
      $insert->save();

      $insert_log = new Log_user;
      $insert_log->user_id = Auth::user()->emp_id;
      // $insert_log->user_name = 'phats';
      $insert_log->path = "";
      $insert_log->type_log = 'utility';
      $insert_log->save();

      if($insert){
        return back()->with('success', 'บันทึกข้อมูลแล้ว');
      }
      // return redirect()->route('add_source');
    }

    public function download($filename = '')
   {
       // Check if file exists in app/storage/file folder
       $file_path = storage_path() . "/file/" . $filename;
       // dd($file_path);
       $headers = array(
           'Content-Type: application/vnd.ms-excel',
           'Content-Disposition: attachment; filename='.$filename,
       );
       // dd($headers);
       if ( file_exists( $file_path ) ) {
           // Send Download
           return \Response::download( $file_path, $filename, $headers );
       } else {
           // Error
           exit( 'Requested file does not exist on our server!' );
       }
   }
   public function save_edit(Request $request)
   {
     // dd($request->all());
     if($request->type == 'water'){
       $update = Water::find($request->id);
       $update->meter_id = $request->meter_id;
       $update->price = $request->price;
       $update->update();
     }else{
       $update = Electric::find($request->id);
       $update->meter_id = $request->meter_id;
       $update->price = $request->price;
       $update->update();
     }
     if($update){
       return back()->with('success', 'บันทึกข้อมูลแล้ว');
     }
   }

   public function find_source()
   {
     return view('source_find');
   }

   public function post_find_source(Request $request)
   {
     // dd($request->all());
     $find = Original::where('meter_id','like','%'.$request->meter_id.'%')->get();
     return view('source_find',['find' => $find]);
   }
}
