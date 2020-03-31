@extends('layout')

@section('title')
<title>Export page</title>
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
  </style>
@endsection
@section('content')
  <main class="main">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="#">หน้าแรก</a>
      </li>
      <li class="breadcrumb-item active">Export file {{ $type }}</li>
    </ol>
   @if($message = Session::get('success'))
   <div class="alert alert-success alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>
           <strong>{{ $message }}</strong>
   </div>
   @endif
    <div class="panel-body">
      <div class="card-body">
       <h3 align="center">Export File {{ucfirst($type)}}</h3>
        <div class="form-group">
          <button class="btn btn-primary mb-1" type="button" data-toggle="modal" data-target="#myModal">Export</button>
          {{--<a class="btn btn-primary" href="{{url($type.'/excel/export')}}">Export</a>--}}
        </div>

       <div class="panel panel-default">
        <div class="panel-heading">
         <h3 class="panel-title">{{ ucfirst($type).' Data'}}</h3>
        </div>
        <table class="table table-responsive-sm table-bordered myTable">
          <thead>
            <th>วันที่</th>
            <th>เลขที่บิล</th>
            <th>หมายเลขผู้ใช้ไฟฟ้า</th>
            <th>จำนวนเงิน</th>
            <th>Costcenter</th>
            <th>GL</th>
            <th>Business Process</th>
            <th>Product</th>
            <th>Fuctonal Area</th>
            <th>Segment</th>
          </thead>
          <tbody>
         @foreach($data as $row)
           <tr>
            <td>{{ $row->date }}</td>
            <td>{{ $row->bill_id }}</td>
            <td>{{ $row->meter_id }}</td>
            <td align="right">{{ number_format($row->price,2) }}</td>
            <td align="center">{{ $row->costcenter }}</td>
            <td>{{ $row->gl }}</td>
            <td align="center">{{ $row->business_process }}</td>
            <td align="center">{{ $row->product }}</td>
            <td align="center">{{ $row->functional_area }}</td>
            <td align="center">{{ $row->segment }}</td>
           </tr>
         @endforeach
          </tbody>
        </table>
      </div>
     </div>
   </div>
 </main>

  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
         <h4 class="modal-title">เลือกวันที่ Export ข้อมูล</h4>
         <button class="close" type="button" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">×</span>
         </button>
        </div>
        <form action="{{ url($type.'/excel/export') }}" method="post">
          @csrf
          <div class="modal-body">
            <div class="row">
              <div class="form-group col-sm-6">
                <label>วันที่</label>
                <input class="form-control @error('start_date') is-invalid @enderror" type="text" name="date">
                @error('date')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>
              <div class="form-group col-sm-6">
                <label>เลขที่บิล</label>
                <input class="form-control @error('start_date') is-invalid @enderror" type="text" name="bill_id">
                @error('bill_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>
            </div>
            <div class="row">
              <div class="form-group col-sm-6">
                <label>Header Text</label>
                <input class="form-control @error('header') is-invalid @enderror" type="text" name="header">
                @error('date')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>
              <div class="form-group col-sm-6">
                <label>Text</label>
                <input class="form-control @error('text') is-invalid @enderror" type="text" name="text">
                @error('text')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  @endsection

  @section('js')
  <script src="{{ asset('admin/node_modules/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('admin/js/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('admin/node_modules/popper.js/dist/umd/popper.min.js') }}"></script>
  <script src="{{ asset('admin/node_modules/bootstrap/dist/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('admin/node_modules/pace-progress/pace.min.js') }}"></script>
  <script src="{{ asset('admin/node_modules/perfect-scrollbar/dist/perfect-scrollbar.min.js') }}"></script>
  <script src="{{ asset('admin/node_modules/@coreui/coreui/dist/js/coreui.min.js') }}"></script>
  <script type="text/javascript">
    $('.myTable').DataTable({
      select:true,
    });
  </script>
  <script>
   var msg = '{{Session::get('alert')}}';
   var exist = '{{Session::has('alert')}}';
   if(exist){
     alert(msg);
   }
 </script>
  @endsection
