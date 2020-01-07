@extends('layout')

@section('title')
<title>Import Original page</title>
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
  <link href="{{ asset('admin/css/jquery.dataTables.css') }}" rel="stylesheet">
  <script src="{{ asset('admin/js/jquery-1.12.0.js') }}"></script>
  <style>
    .word {
      color: #fff !important;
    }
    .bold{
      font-weight: bold;
    }
    div.dataTables_wrapper {
        width: 100%;
    }
  </style>
@endsection
@section('content')
<main class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="#">หน้าแรก</a>
    </li>
    <li class="breadcrumb-item active">Import file original</li>
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
   <form method="post" enctype="multipart/form-data" action="{{ url('source/import_excel/import') }}">
    {{ csrf_field() }}
    <div class="form-group row">
      <label class="col-md-2 col-form-label" for="date-input">Select File</label>
      <div class="col-md-4">
        <input id="file-input" type="file" name="select_file"><span class="text-muted">.xlsx</span>
      </div>
    </div>
    <div class="col-md-4">
      <input type="submit" name="upload" class="btn btn-primary" value="Submit">
    </div><br>
   </form>
   <div class="row">
     <table class="table table-responsive-sm table-bordered " id="myTable">
       <thead>
         <th>หมายเลขผู้ใช้ไฟฟ้า</th>
         <th>สาธารณูปโภค</th>
         <th>ประเภทสาธารณูปโภค</th>
         <th>รหัสหน่วยธุรกิจ</th>
         <th>ที่ตั้ง/โหนด1</th>
         <th>ที่ตั้ง/โหนด2</th>
         <th>Costcenter</th>
         <th>GL</th>
         <th>Business Process</th>
         <th>Product</th>
         <th>Fuctonal Area</th>
         <th>Segment</th>
         <th>Reference Key 1</th>
       </thead>
       <tbody>
      @foreach($data as $row)
        <tr>
         <td>{{ $row->meter_id }}</td>
         <td>{{ $row->utility }}</td>
         <td align="center">{{ $row->utility_type }}</td>
         <td align="center">{{ $row->business_id }}</td>
         <td>{{ $row->node1 }}</td>
         <td>{{ $row->node2 }}</td>
         <td align="center">{{ $row->costcenter }}</td>
         <td>{{ $row->gl }}</td>
         <td>{{ $row->business_process }}</td>
         <td>{{ $row->product }}</td>
         <td align="center">{{ $row->functional_area }}</td>
         <td>{{ $row->segment }}</td>
         <td>{{ $row->key1 }}</td>
        </tr>
      @endforeach
       </tbody>
     </table>

   </div>
</main>
@endsection

@section('js')
  <script src="{{ asset('admin/node_modules/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('admin/js/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('admin/node_modules/popper.js/dist/umd/popper.min.js') }}"></script>
  <script src="{{ asset('admin/node_modules/bootstrap/dist/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('admin/node_modules/pace-progress/pace.min.js') }}"></script>
  <script src="{{ asset('admin/node_modules/perfect-scrollbar/dist/perfect-scrollbar.min.js') }}"></script>
  <script src="{{ asset('admin/node_modules/@coreui/coreui/dist/js/coreui.min.js') }}"></script>
  <!-- <script type="text/javascript">
    $('.myTable').DataTable({
      select:true,
      scrollCollapse: true,
    });
  </script> -->
  <script>
  $(document).ready(function() {
    $('#myTable').DataTable({
      scrollX:true
    });
  });
</script>
@endsection
