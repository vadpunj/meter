@extends('layout')

@section('title')
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Dashboard page</title>
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
    </ol>
    <!-- end breadcrumb -->
    <div class="container-fluid">
      <div class="animated fadeIn">
        @if($message = Session::get('success'))
        <div class="alert alert-success alert-block">
         <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
        </div>
        @endif
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
            <div class="card-header word">
              @if (session()->has('notification'))
                <div class="notification">
                  {!! session('notification') !!}
                </div>
              @endif
            <i class="fa fa-align-justify"></i> ค้นหาข้อมูลมิเตอร์</div>
              <form class="form-horizontal" action="{{ route('post_homepage') }}" method="post">
                @csrf
                <div class="card-body">
                  <div class="form-group row">
                    <label class="col-md-2 col-form-label">เลขมิเตอร์</label>
                    <div class="form-group col-sm-4">
                      <div class="input-group">
                        <input class="form-control @error('meter_id') is-invalid @enderror" type="text" name="meter_id">
                        @error('meter_id')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                      </div>
                    </div>
                    <div class="col-md-2 form-group form-actions">
                      <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
            @if(isset($find))
            <div style="overflow-x: scroll;width:100%">
              <table class="table table-responsive-sm table-bordered">
                <thead>
                  <tr>
                    <th>หมายเลขผู้ใช้ไฟฟ้า</th>
                    <th>สาธารณูปโภค</th>
                    <th>ประเภทสาธารณูปโภค</th>
                    <th>รหัสหน่วยธุรกิจ</th>
                    <th>ที่ตั้ง/โหนด1</th>
                    <th>ที่ตั้ง/โหนด2</th>
                    <th>ศูนย์ต้นทุน</th>
                    <th>GL</th>
                    <th>Business Process</th>
                    <th>ผลิตภัณฑ์</th>
                    <th>Functional Area</th>
                    <th>Segment</th>
                    <th>Reference Key1</th>
                  </tr>
                </thead>
                <tbody>
                @foreach($find as $data)
                  <tr>
                    <td>{{ $data->meter_id }}</td>
                    <td>{{ $data->utility }}</td>
                    <td align="center">{{ $data->utility_type }}</td>
                    <td align="center">{{ $data->business_id }}</td>
                    <td>{{ $data->node1 }}</td>
                    <td>{{ $data->node2 }}</td>
                    <td align="center">{{ $data->costcenter }}</td>
                    <td>{{ $data->gl }}</td>
                    <td>{{ $data->business_process }}</td>
                    <td>{{ $data->product }}</td>
                    <td align="center">{{ $data->functional_area }}</td>
                    <td align="center">{{ $data->segment }}</td>
                    <td align="center">{{ $data->key1 }}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            @endif
          </div>
        </div>
      </div>
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
