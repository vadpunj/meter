<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Excel;
use App\Log_user;
use App\Electric;
use Response;
use App\Water;

class ExportExcelController extends Controller
{
    public function index_electric()
    {
      $data = Electric::orderBy('created_at','DESC')->limit(100)->get();
      return view('export_excel', ['data' => $data,'type' => 'electric']);
    }

    public function excel_electric(Request $request)
    {
      // dd(4233);
      $date = $request->date;
      $bill_id = $request->bill_id;
      $header = $request->header;
      $text = $request->text;
      // dd(is_numeric($date));
      if(!is_numeric($date)){
        return redirect()->back() ->with('alert', 'กรุณาใส่วันที่เป็นตัวเลขเท่านั้น');
      }

      $data = DB::table('electrics')
            ->select(DB::raw('sum(price) as price,business_process,product,functional_area,segment'))
            ->where('bill_id', $bill_id)
            ->groupBy('business_process','product','functional_area','segment')
            ->get()
            ->toArray();
            // dd($data);
      $array = array();
      $i =1;
      foreach($data as $list_data){
        $array[] = array(
          'DocNo' => '1',
          'LineItem' => $i++,
          'ComCode' => '1000',
          'Year' => date('Y'),
          'DocType' => 'KR',
          'DocDate' => $date,
          'PostDate' => $date,
          'Reference' => $bill_id,
          'Header Text' => $header,
          'Curr' => 'THB',
          'Rate' => '',
          'Branch' => '0000',
          'TransDate' => '',
          'PostKey' => '40',
          'AccountType' => 'S',
          'Account' => '51661102',
          'Alternative' => '',
          'TaxCode' => 'D7',
          'AmountTrans' => $list_data->price,
          'AmountLocal' => $list_data->price,
          'TaxTrans' => '',
          'TaxLocal' => '',
          'BA' => '',
          'Cctr' => '',
          'FuncArea' => $list_data->functional_area,
          'WBS' => '',
          'Activity' => '',
          'TradPart' => '',
          'ValueDate' => '',
          'Baseline' => '',
          'PaymentTerm' => '',
          'PartnerBank' => '',
          'Product' => '',
          'SubProduct' => '',
          'RevenueType' => '',
          'Customer' => '',
          'Material' => '',
          'Plant' => '',
          'Business Process' => $list_data->business_process,
          'Segment' => $list_data->segment,
          'Assignment' => '',
          'Text' => $text
        );
      }
      // dd($array);
      Excel::create('electric_sap_'.$bill_id,function($excel) use ($array){
        $excel->setTitle('electrics');
        $excel->sheet('electrics',function($sheet) use ($array){
          $sheet->fromArray($array,null,'A1',false,false);
        });
      })->download('xlsx');

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
      $data = Water::orderBy('created_at','DESC')->limit(100)->get();
      return view('export_excel', ['data' => $data,'type' => 'water']);
    }

    public function excel_water(Request $request)
    {
      // dd(4233);
      // $this->validate($request,[
      //    'date' => 'required|numeric',
      //    'bill_id' => 'required',
      //    'header' => 'required',
      //    'text' => 'required'
      // ]);

      $date = $request->date;
      $bill_id = $request->bill_id;
      $header = $request->header;
      $text = $request->text;
      // dd(is_numeric($date));
      if(!is_numeric($date)){
        return redirect()->back() ->with('alert', 'กรุณาใส่วันที่เป็นตัวเลขเท่านั้น');
      }

      $data = DB::table('waters')
            ->select(DB::raw('sum(price) as price,business_process,product,functional_area,segment'))
            ->where('bill_id', $bill_id)
            ->groupBy('business_process','product','functional_area','segment')
            ->get()
            ->toArray();
            // dd($data);
      $array = array();
      $i =1;
      foreach($data as $list_data){
        $array[] = array(
          'DocNo' => '1',
          'LineItem' => $i++,
          'ComCode' => '1000',
          'Year' => date('Y'),
          'DocType' => 'KR',
          'DocDate' => $date,
          'PostDate' => $date,
          'Reference' => $bill_id,
          'Header Text' => $header,
          'Curr' => 'THB',
          'Rate' => '',
          'Branch' => '0000',
          'TransDate' => '',
          'PostKey' => '40',
          'AccountType' => 'S',
          'Account' => '51661102',// เปลี่ยนเลขบัญชีก่อนเอาขึ้นprd
          'Alternative' => '',
          'TaxCode' => 'D7',
          'AmountTrans' => $list_data->price,
          'AmountLocal' => $list_data->price,
          'TaxTrans' => '',
          'TaxLocal' => '',
          'BA' => '',
          'Cctr' => '',
          'FuncArea' => $list_data->functional_area,
          'WBS' => '',
          'Activity' => '',
          'TradPart' => '',
          'ValueDate' => '',
          'Baseline' => '',
          'PaymentTerm' => '',
          'PartnerBank' => '',
          'Product' => '',
          'SubProduct' => '',
          'RevenueType' => '',
          'Customer' => '',
          'Material' => '',
          'Plant' => '',
          'Business Process' => $list_data->business_process,
          'Segment' => $list_data->segment,
          'Assignment' => '',
          'Text' => $text
        );
      }
      // dd($array);
      Excel::create('waters_sap_'.$bill_id,function($excel) use ($array){
        $excel->setTitle('waters');
        $excel->sheet('waters',function($sheet) use ($array){
          $sheet->fromArray($array,null,'A1',false,false);
        });
      })->download('xlsx');

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
