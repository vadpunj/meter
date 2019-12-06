@extends('layout')

@section('title')
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Branch page</title>
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
  </style>
@endsection

@section('content')
  <main class="main">
    <!-- Breadcrumb-->
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="#">หน้าแรก</a>
      </li>
      <li class="breadcrumb-item active">สาขาหน่วยงาน</li>
    </ol>
    <!-- end breadcrumb -->
  <div class="container-fluid">
    <div class="animated fadeIn">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
          <div class="card-header word">
            @if (session()->has('notification'))
              <div class="notification">
                {!! session('notification') !!}
              </div>
            @endif
          <i class="fa fa-align-justify"></i> กรอกข้อมูลสาขา</div>
            <form class="form-horizontal" action="{{ route('insertbranch') }}" method="post">
              @csrf
              <div class="card-body">
                <div class="form-group row">
                  <label class="col-md-2 col-form-label">รหัสสาขา</label>
                  <div class="form-group col-sm-4">
                    <input class="form-control @error('branch_id') is-invalid @enderror" type="text" name="branch_id">
                    @error('branch_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  </div>
                  <label class="col-md-2 col-form-label">ชื่อสาขา</label>
                  <div class="form-group col-sm-4">
                    <input class="form-control @error('branch') is-invalid @enderror" type="text" name="branch">
                    @error('branch')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <p id="demo"></p>
                  </div>
                </div>
              </div>
              <div class="col-md-2 form-group form-actions">
                <button class="btn btn-primary" type="submit">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="container-fluid">
    <div class="animated fadeIn">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
          <div class="card-header word">
            @if (session()->has('notification'))
              <div class="notification">
                {!! session('notification') !!}
              </div>
            @endif
          <i class="fa fa-align-justify"></i> list data branch</div>
          <table class="table table-responsive-sm table-bordered myTable">
            <thead>
              <tr>
                <th>No.</th>
                <th>Branch ID</th>
                <th>Branch Name</th>
                <th>Created By</th>
                <th>Created At</th>
                <th>Action</th>
              <tr>
            </thead>
            <tbody>
            @if(!empty($list))
              @foreach($list as $row => $value)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $value['branch_id'] }}</td>
                <td>{{ $value['branch_name'] }}</td>
                <td>{{ Func::get_name_user($value['user_id']) }}</td>
                <td>{{ $value['created_at'] }}</td>
                <td><button class="btn btn-warning mb-1" type="button" data-toggle="modal" data-target="#editmodal{{$value['id']}}"><i class="nav-icon icon-pencil"></i></button> <button class="btn btn-danger mb-1" type="button" data-toggle="modal" data-target="#delmodal{{$value['id']}}"><i class="nav-icon icon-trash"></i></button> </td>
              </tr>
              @endforeach
            @else
              <tr>
                <td colspan="6" align="center">{{ 'ไม่มีข้อมูล' }}</td>
              </tr>
            @endif
            </tbody>
          </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  </main>
@foreach($list as $row => $value)

  <div class="modal fade" id="editmodal{{$value['id']}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-warning" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit branch</h4>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        </div>
        <form class="" action="{{route('editbranch')}}" method="post">
          @csrf
          <div class="modal-body">
            <div class="row">
              <div class="form-group col-sm-6">
                <label for="city">รหัสสาขา</label>
                <input class="form-control" type="text" name="branch_id" value="{{ $value['branch_id'] }}">
              </div>
              <div class="form-group col-sm-6">
                <label for="postal-code">ชื่อสาขา</label>
                <input class="form-control" type="text" name="branch_name" value="{{ $value['branch_name'] }}">
              </div>
              <input type="hidden" value="{{$value['id']}}" name="id">
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-warning" type="submit">Save changes</button>
          </div>
        </form>
      </div>
    </div>
   <!-- /.modal-dialog-->
  </div>
  <div class="modal fade" id="delmodal{{$value['id']}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-danger" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit branch</h4>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        </div>
        <form action="{{route('delbranch')}}" method="post">
          @csrf
          <div class="modal-body">
            <p>คุณต้องการลบข้อมูลบรรทัดนี้ใช่หรือไม่ ?</p>
            <input type="hidden" value="{{$value['id']}}" name="id">
            <input type="hidden" name="branch_id" value="{{ $value['branch_id'] }}">
            <input type="hidden" name="branch_name" value="{{ $value['branch_name'] }}">
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
  <script src="{{ asset('admin/node_modules/popper.js/dist/umd/popper.min.js') }}"></script>
  <script src="{{ asset('admin/node_modules/bootstrap/dist/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('admin/node_modules/pace-progress/pace.min.js') }}"></script>
  <script src="{{ asset('admin/node_modules/perfect-scrollbar/dist/perfect-scrollbar.min.js') }}"></script>
  <script src="{{ asset('admin/node_modules/@coreui/coreui/dist/js/coreui.min.js') }}"></script>
@endsection
