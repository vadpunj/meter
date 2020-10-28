@extends('layout')

@section('title')
<title>List User</title>
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
    <li class="breadcrumb-item active">List User</li>
  </ol>
   <h3 align="center">List User</h3>

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


  <div class="card-body">
   <div class="container-fluid">
     @if($message = Session::get('success'))
     <div class="alert alert-success alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>
             <strong>{{ $message }}</strong>
     </div>
     @endif
     <table class="table table-responsive-sm table-bordered " id="myTable">
       <thead>
         <th>No.</th>
         <th>รหัสพนักงาน</th>
         <th>ชื่อ-นามสกุล</th>
         <th>สิทธิ</th>
         <th>รหัสศูนย์ต้นทุน</th>
         <th>ดูข้อมูล</th>
         <th>แก้ไข</th>
         <th>ลบ</th>
       </thead>
       <tbody>
      @foreach($user as $row)
        <tr>
         <td align="center">{{ $loop->iteration }}</td>
         <td align="center">{{ $row->emp_id }}</td>
         <td>{{ ucwords($row->name) }}</td>
         @if($row->type == '1')
         <td align="center">{{ 'Admin' }}</td>
         @else
         <td align="center">{{ 'User' }}</td>
         @endif
         <td align="center">{{ $row->center_money }}</td>
         <td align="center">
          <button type="button" class="btn btn-info" data-toggle="modal" data-target="{{'#myView'.$row->id}}">
            <i class="nav-icon icon-eye"></i> View
          </button>
         </td>
         <td align="center">
          <button type="button" class="btn btn-warning" data-toggle="modal" data-target="{{'#myEdit'.$row->id}}">
            <i class="nav-icon icon-pencil"></i> Edit
          </button>
         </td>
         <td align="center">
          <button type="button" class="btn btn-danger" data-toggle="modal" data-target="{{'#myDelete'.$row->id}}">
            <i class="nav-icon icon-trash"></i> Delete
          </button>
         </td>
        </tr>
      @endforeach
       </tbody>
     </table>
    </div>
  </div>
</main>
@foreach($user as $row)
 <div class="modal fade" id="{{'myEdit'.$row->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-warning" role="document">
     <div class="modal-content">
       <form action="{{ route('edit_user') }}" method="POST">
         @csrf
       <div class="modal-header">
         <h5 class="modal-title" id="exampleModalLabel">แก้ไขข้อมูลผู้ใช้</h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
         </button>
       </div>
        <div class="modal-body">
          <div class="row">
            <div class="form-group col-sm-6">
              <label for="city">ชื่อ</label>
              <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{$row->name}}">
              @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
            <div class="form-group col-sm-6">
              <label for="postal-code">รหัสพนักงาน</label>
              <input class="form-control" type="text" name="emp_id" value="{{$row->emp_id}}" readonly>
              <input class="form-control" type="hidden" name="id" value="{{$row->id}}">
              @error('emp_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
          </div>
          <div class="row">
            <div class="form-group col-sm-6">
              <label for="postal-code">ศูนย์ต้นทุน</label>
              <input class="form-control @error('center_money') is-invalid @enderror" type="text" name="center_money" value="{{$row->center_money}}">
              @error('center_money')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
            <div class="form-group col-sm-6">
              <label for="postal-code">สิทธิ์</label>
              <select class="form-control" name="type">
                <option value="{{ '1' }}" @if($row->type == "1") selected @else '' @endif>Admin</option>
                <option value="{{ '0' }}" @if($row->type == "0") selected @else '' @endif>User</option>
              </select>
              @error('type')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
        </form>
      </div>

    </div>
  </div>
  <div class="modal fade" id="{{'myView'.$row->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-info" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">ข้อมูลผู้ใช้</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
         <div class="modal-body">
           <div class="row">
             <div class="form-group col-sm-6">
               <label for="city">ชื่อ</label>
               <input class="form-control" type="text" name="name" value="{{$row->name}}" readonly>
             </div>
             <div class="form-group col-sm-6">
               <label for="postal-code">รหัสพนักงาน</label>
               <input class="form-control" type="text" name="emp_id" value="{{$row->emp_id}}" readonly>
             </div>
           </div>
           <div class="row">
             <div class="form-group col-sm-6">
               <label for="postal-code">ศูนย์เงินทุน</label>
               <input class="form-control" type="text" name="center_money" value="{{$row->center_money}}"readonly>
             </div>
             <div class="form-group col-sm-6">
               <label for="postal-code">สิทธิ์</label>
               @if($row->type == '1')
               <input class="form-control" type="text" name="type" value="{{'Admin'}}"readonly>
               @else
               <input class="form-control" type="text" name="type" value="{{'User'}}"readonly>
               @endif
             </div>
           </div>
         </div>
       </div>

     </div>
   </div>
  <div class="modal fade" id="{{'myDelete'.$row->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-danger" role="document">
      <div class="modal-content">
        <form action="{{ route('delete_user') }}" method="POST">
          @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">ลบข้อมูลผู้ใช้งาน</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
         <div class="modal-body">
           <p>ต้องการลบข้อมูลผู้ใช้หรือไม่?</p>
           <input type="hidden" name="id" value="{{ $row->id }}">
         </div>
         <div class="modal-footer">
           <button class="btn btn-danger" type="submit">Delete</button>
         </div>
         </form>
       </div>

     </div>
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
