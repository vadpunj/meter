@extends('layout')

@section('title')
<title>Import page</title>
@endsection

@section('css')
  <!-- <link href="{{ asset('admin/node_modules/@coreui/icons/css/coreui-icons.min.css') }}" rel="stylesheet"> -->
  <link href="{{ asset('admin/node_modules/flag-icon-css/css/flag-icon.min.css') }}" rel="stylesheet">
  <link href="{{ asset('admin/node_modules/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
  <link href="{{ asset('admin/node_modules/simple-line-icons/css/simple-line-icons.css') }}" rel="stylesheet">
  <!-- Main styles for this application-->
  <link href="{{ asset('admin/css/style.css') }}" rel="stylesheet">
  <link href="{{ asset('admin/vendors/pace-progress/css/pace.min.css') }}" rel="stylesheet">
  <!-- Global site tag (gtag.js) - Google Analytics-->
  <script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-118965717-3"></script>
  <style>
    .word {
      color: #fff !important;
    }
    .bold{
      font-weight: bold;
    }
  </style>
@endsection
@section('content')
<main class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="#">หน้าแรก</a>
    </li>
    <li class="breadcrumb-item active">Import file {{ $type }}</li>
  </ol>
   <h3 align="center">Import Excel File</h3>

   @if(count($errors) > 0)
    <div class="alert alert-danger">
     Upload Validation Error<br><br>
     <ul>
      @foreach($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
     </ul>
    </div>
   @endif

   @if($message = Session::get('success'))
   <div class="alert alert-success alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>
           <strong>{{ $message }}</strong>
   </div>
   @endif
   <div class="card-body">
   <form method="post" enctype="multipart/form-data" action="{{ url($type.'/import_excel/import') }}">
    {{ csrf_field() }}
    {{--<div class="form-group row">
      <label class="col-md-2 col-form-label" for="date-input">Time Key</label>
      <div class="col-md-4">
        <input class="form-control" name="time_key" type="text" required>

      </div>
    </div>--}}
    <div class="form-group row">
      <label class="col-md-2 col-form-label" for="date-input">Select File</label>
      <div class="col-md-4">
        <input id="file-input" type="file" name="select_file"><span class="text-muted">.xlsx</span>
        @error('select_file')
          <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
        @enderror
      </div>
    </div>
    <div class="col-md-4">
      <input type="submit" name="upload" class="btn btn-primary" value="Submit">
    </div><br>
   </form>
   <div class="row">
     <!-- แสดงข้อมูลที่เอาเข้าระบบไปในเดือนนั้นๆ -->
   <table class="table table-responsive-sm table-bordered" style="width: 70%;overflow-x: auto;margin-right: 27px;">
     <thead>
       <tr>
         <th width="15%">เดือน-ปี</th>
         <th>Price</th>
         <th>Business Process</th>
         <th>Product</th>
         <th>Functional Area</th>
         <th>Segment</th>
       </tr>
     </thead>
     @if(!empty($data))
     <tbody>
       <?php $sum_price = 0; ?>
       @foreach($data as $datas)
       <?php $sum_price += $datas['price']; ?>
       <tr>
         <td>{{ Func::get_name_month($datas['month'])." ".$datas['year']}}</td>
         <td align="center">{{ $datas['business_process'] }}</td>
         <td align="center">{{ $datas['product'] }}</td>
         <td align="center">{{ $datas['functional_area'] }}</td>
         <td align="center">{{ $datas['segment'] }}</td>
         <td align="right">{{ number_format($datas['price'],2) }}</td>
       </tr>
       @endforeach
       <tr>
         <td class="bold" align="center" colspan="5">Sum</td>
         <td class="bold" align="right">{{ number_format($sum_price,2) }}</td>
       </tr>
     </tbody>
     @else
     <tbody>
       <tr>
         <td colspan="6" align="center">{{ 'ไม่มีข้อมูล' }}</td>
       </tr>
     </tbody>
     @endif
   </table>
   <table class="table table-responsive-sm table-bordered" style="width: 24%;overflow-x: auto">
     <thead>
       <tr>
         <th>เดือน-ปี</th>
         <th>Price</th>
       </tr>
     </thead>
     @if(!empty($data2))
     <tbody>
       <?php $sum_price = 0; ?>
       @foreach($data2 as $datas2)
      <?php $sum_price += $datas2['price']; ?>
       <tr>
         <td>{{ Func::get_name_month($datas2['month'])." ".$datas2['year']}}</td>
         <td align="right">{{ number_format($datas2['price'],2) }}</td>
       </tr>
       @endforeach
       <tr>
         <td class="bold" align="center">Sum</td>
         <td class="bold" align="right">{{ number_format($sum_price,2) }}</td>
       </tr>
     </tbody>
     @else
     <tbody>
       <tr>
         <td colspan="4" align="center">{{ 'ไม่มีข้อมูล' }}</td>
       </tr>
     </tbody>
     @endif
   </table>
 </div>
</main>
@endsection

@section('js')
  <script src="{{ asset('admin/node_modules/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('admin/node_modules/popper.js/dist/umd/popper.min.js') }}"></script>
  <script src="{{ asset('admin/node_modules/bootstrap/dist/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('admin/node_modules/pace-progress/pace.min.js') }}"></script>
  <script src="{{ asset('admin/node_modules/perfect-scrollbar/dist/perfect-scrollbar.min.js') }}"></script>
  <script src="{{ asset('admin/node_modules/@coreui/coreui/dist/js/coreui.min.js') }}"></script>
@endsection
