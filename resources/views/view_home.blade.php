@extends('layout')

@section('title')
<title>View page</title>
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
      <li class="breadcrumb-item active">ข้อมูลศูนย์ต้นทุน</li>
    </ol>

    <div class="panel-body">
      <div class="card-body">
       <h3 align="center">ข้อมูลศูนย์ต้นทุน</h3>
       <table class="table table-responsive-sm table-bordered myTable">
         <thead>
            <th>No.</th>
            <th>Source</th>
            <th>Branch ID</th>
            <th>Branch Name</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>User</th>
            <th>Action</th>
         </thead>
         <tbody>
         @foreach($list as $row)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $row->source }}</td>
            <td>{{ $row->branch_id }}</td>
            <td>{{ $row->branch_name }}</td>
            <td>{{ $row->start_date }}</td>
            <td>{{ $row->end_date }}</td>
            <td>{{ $row->user_id }}</td>
            <td><a href="{{ url('home/edit/'.$row->id) }}" class="btn btn-warning mb-1"><i class="nav-icon icon-pencil"></i></a> <button class="btn btn-danger mb-1" type="button" data-toggle="modal" data-target="#delmodal{{$row->id}}"><i class="nav-icon icon-trash"></i></button></td>
          </tr>
         @endforeach
       </tbody>
       </table>
     </div>
   </div>
 </main>
@foreach($list as $row)
 <div class="modal fade" id="delmodal{{$row->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-danger" role="document">
     <div class="modal-content">
       <div class="modal-header">
         <h4 class="modal-title">Delete</h4>
         <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
       </div>
       <form action="{{route('delsource')}}" method="post">
         @csrf
         <div class="modal-body">
           <p>คุณต้องการลบข้อมูลบรรทัดนี้ใช่หรือไม่ ?</p>
           <input type="hidden" name="id" value="{{ $row->id }}">
           <input type="hidden" name="branch_id" value="{{ $row->branch_id }}">
           <input type="hidden" name="source" value="{{ $row->source }}">
         </div>
         <div class="modal-footer">
           <button class="btn btn-danger" type="submit">Delete It</button>
         </div>
       </form>
     </div>
   </div>
  <!-- /.modal-dialog-->
 </div>
 @endforeach

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
  @endsection
