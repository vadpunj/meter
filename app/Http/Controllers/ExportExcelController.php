<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Excel;
use App\Log_user;
use App\Electric;
use Response;

class ExportExcelController extends Controller
{
    public function index_electric()
    {
      $data = DB::table('electrics')->get();
      return view('export_excel', ['data' => $data,'type' => 'electric']);
    }

    public function export_electric(Request $request)
    {
      $start = $request->start_date;
      $end = $request->end_date;
      
      $data = DB::table('electrics')
            ->select(DB::raw('sum(price) as price,business_process,product,functional_area,segment'))
            ->whereBetween('date', [$start, $end])
            ->groupBy('business_process','product','functional_area','segment')
            ->get()
            ->toArray();

      $content = "";
      foreach($data as $value => $key){
        $content .= $key->price."\t";
        $content .= $key->business_process."\t";
        $content .= $key->product."\t";
        $content .= $key->functional_area."\t";
        $content .= $key->segment."\r\n";
      }
      // dd($content);
      $fileName = "elect_logs-".$start.".txt";

      $headers = [
        'Content-type' => 'text/plain',
        'Content-Disposition' => sprintf('attachment; filename="%s"', $fileName)
        // 'Content-Length' => sizeof($content)
      ];
      //
      return Response::make($content, 200, $headers);
    }

    public function index_water()
    {
      $data = DB::table('waters')->get();
      return view('export_excel', ['data' => $data,'type' => 'water']);
    }

    public function export_water(Request $request)
    {
      $start = $request->start_date;
      $end = $request->end_date;

      $data = DB::table('waters')
            ->select(DB::raw('sum(price) as price,business_process,product,functional_area,segment'))
            ->whereBetween('date', [$start, $end])
            ->groupBy('business_process','product','functional_area','segment')
            ->get()
            ->toArray();
      // dd($data);

      $content = "";
      foreach($data as $value => $key){
        $content .= $key->price."\t";
        $content .= $key->business_process."\t";
        $content .= $key->product."\t";
        $content .= $key->functional_area."\t";
        $content .= $key->segment."\r\n";
      }
      $fileName = "water_logs-".$start.".txt";

      $headers = [
        'Content-type' => 'text/plain',
        'Content-Disposition' => sprintf('attachment; filename="%s"', $fileName)
        // 'Content-Length' => sizeof($content)
      ];
      //
      return Response::make($content, 200, $headers);
    }
}
