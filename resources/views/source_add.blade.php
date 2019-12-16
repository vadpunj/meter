@extends('layout')

@section('title')
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Add page</title>
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
      <li class="breadcrumb-item active">ศูนย์ต้นทุน</li>
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
          <i class="fa fa-align-justify"></i> กรอกศูนย์ต้นทุน</div>
            <form class="form-horizontal" action="{{ route('post_source') }}" method="post">
              @csrf
              <div class="card-body">
                <div class="form-group row">
                  <label class="col-md-2 col-form-label">หมายเลขผู้ใช้ไฟฟ้า</label>
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
                  <label class="col-md-2 col-form-label">สาธารณูปโภค</label>
                  <div class="form-group col-sm-4">
                    <div class="input-group">
                      <input class="form-control @error('utility') is-invalid @enderror" type="text" name="utility">
                      @error('utility')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-md-2 col-form-label">ประเภทสาธารณูปโภค</label>
                  <div class="form-group col-sm-4">
                    <input class="form-control @error('utility_type') is-invalid @enderror" type="text" name="utility_type">
                    @error('utility_type')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                  <label class="col-md-2 col-form-label">รหัสหน่วยธุรกิจ</label>
                  <div class="form-group col-sm-4">
                    <input class="form-control @error('business_id') is-invalid @enderror" type="text" name="business_id">
                    @error('business_id')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-md-2 col-form-label">ที่ตั้ง/โหนด1</label>
                  <div class="form-group col-sm-4">
                    <input class="form-control @error('node1') is-invalid @enderror" type="text" name="node1">
                    @error('node1')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                  <label class="col-md-2 col-form-label">ที่ตั้ง/โหนด2</label>
                  <div class="form-group col-sm-4">
                    <input class="form-control @error('node2') is-invalid @enderror" type="text" name="node2" onchange="myfunc()">
                    @error('node2')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-md-2 col-form-label">Costcenter</label>
                  <div class="form-group col-sm-4">
                    <input class="form-control @error('costcenter') is-invalid @enderror" type="text" name="costcenter">
                    @error('costcenter')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                  <label class="col-md-2 col-form-label">GL</label>
                  <div class="form-group col-sm-4">
                    <input class="form-control @error('gl') is-invalid @enderror" type="text" name="gl">
                    @error('gl')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-md-2 col-form-label">Business Process</label>
                  <div class="form-group col-sm-4">
                    <input class="form-control @error('business_process') is-invalid @enderror" type="text" name="business_process">
                    @error('business_process')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                  <label class="col-md-2 col-form-label">Product</label>
                  <div class="form-group col-sm-4">
                    <input class="form-control @error('product') is-invalid @enderror" type="text" name="product">
                    @error('product')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-md-2 col-form-label">Function Area</label>
                  <div class="form-group col-sm-4">
                    <input class="form-control @error('functional_area') is-invalid @enderror" type="text" name="functional_area">
                    @error('functional_area')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                  <label class="col-md-2 col-form-label">Segment</label>
                  <div class="form-group col-sm-4">
                    <input class="form-control @error('segment') is-invalid @enderror" type="text" name="segment">
                    @error('segment')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-md-2 col-form-label">Reference Key 1</label>
                  <div class="form-group col-sm-4">
                    <input class="form-control @error('key1') is-invalid @enderror" type="text" name="key1">
                    @error('key1')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
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
