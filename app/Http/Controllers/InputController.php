<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\FileImport;
use App\Exports\FileExport;
use Illuminate\Support\Facades\Auth;
use App\Transaction;
use App\Branch;
use App\Delete;
use DB;
use Excel;
use Func;

class InputController extends Controller
{
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

      $user = new Delete;
      $user->user_id = Auth::user()->emp_id;
      $user->detail = 'id:'.$branch_id." name:".$branch_name;
      $user->save();

      $branch_list = Branch::all()->toArray();
      return view('branch',['list' => $branch_list]);
    }

    public function delete_source(Request $request)
    {
      $id = $request->id;
      $source = $request->source;

      $people = Transaction::find($id);
      $people->delete();

      $user = new Delete;
      $user->user_id = Auth::user()->emp_id;
      $user->detail = 'id'.$id.' branch_id:'.$id." source:".$source;
      $user->save();

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
}
