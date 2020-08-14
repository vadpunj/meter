@extends('layout')

@section('title')
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>View page</title>
@endsection

@section('css')
  <!-- <link href="{{ asset('admin/node_modules/@coreui/icons/css/coreui-icons.min.css') }}" rel="stylesheet"> -->
  <link href="{{ asset('admin/node_modules/flag-icon-css/css/flag-icon.min.css') }}" rel="stylesheet">
  <link href="{{ asset('admin/node_modules/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
  <link href="{{ asset('admin/node_modules/simple-line-icons/css/simple-line-icons.css') }}" rel="stylesheet">
  <!-- Main styles for this application-->
  <link href="{{ asset('admin/css/style.css') }}" rel="stylesheet">
  <link href="{{ asset('admin/css/datepicker.css') }}" rel="stylesheet">
  <link href="{{ asset('admin/vendors/pace-progress/css/pace.min.css') }}" rel="stylesheet">
  <!-- Global site tag (gtag.js) - Google Analytics-->
  <script src="{{ asset('admin/node_modules/jquery/dist/jquery.min.js') }}"></script>
  <script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-118965717-3"></script>
  <script type="text/javascript" src="{{ asset('js/bootstrap-datepicker.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/bootstrap-datepicker-thai.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/bootstrap-datepicker.th.js') }}"></script>

  <script>
  $(document).ready(function(){
    $(".datepicker").datepicker();
  });
  </script>
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
      <li class="breadcrumb-item active">ดูข้อมูลรายได้</li>
    </ol>
    <!-- end breadcrumb -->
    <div class="container-fluid">
      <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
              <form action="{{ route('post_view_source') }}" method="post">
                  @csrf
              <div class="form-group row">
                <label class="col-md-2 col-form-label" for="text-input">ศูนย์ต้นทุน</label>
                  <div class="col-md-4">
                    <input class="form-control"  type="text" name="center_money" >

                  </div>
              </div>
              <div class="form-group row">
                <label class="col-md-2 col-form-label" for="text-input">ประเภทสาธารณูปโภค</label>
                <div class="col-md-4">
                  <select class="form-control" id="select1" name="utility_type">
                    <option value="0">------- Please select --------</option>
                    @foreach($data as $value)
                      <option value="{{ $value->utility_type }}">{{ $value->utility }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-2 col-form-label">วันที่</label>
                <div class="form-group col-sm-3">
                  <div class="input-group">
                    <input class="datepicker form-control @error('start_date') is-invalid @enderror" type='text' data-provide="datepicker" name="start_date" autocomplete="off"/>
                    @error('start_date')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                    <div class="input-group-append">
                      <button type="button" class="btn btn-outline-secondary docs-datepicker-trigger " disabled="">
                        <i class="fa fa-calendar" aria-hidden="true"></i>
                      </button>
                    </div>
                  </div>
                </div>
                <label class="col-md-1 col-form-label">ถึง</label>
                  <div class="form-group col-sm-3">
                    <div class="input-group">
                      <input class="datepicker form-control @error('end_date') is-invalid @enderror" name="end_date" type='text' data-provide="datepicker" autocomplete="off"/>
                      @error('end_date')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                      <div class="input-group-append">
                        <button type="button" class="btn btn-outline-secondary docs-datepicker-trigger " disabled="">
                          <i class="fa fa-calendar" aria-hidden="true"></i>
                        </button>
                      </div>
                    </div>
                  </div>
              </div>
                <button class="btn btn-primary" type="submit">Submit</button>
              </form>
            </div>
        </div>
      </div>
    </div>
      <br>

      <div class="card-body">
        @if(!empty($request))
        <div>
          <h4 class="card-title mb-0">{{"ศูนย์ต้นทุน : ".$request['center_money']." ประเภท : ".Func::get_utility($request['utility_type'])}}</h4>
          <div class="small text-muted">{{"วันที่ ".$request['start_date']." ถึง ".$request['end_date']}}</div>
        </div>
        <br>
        @endif
        <table class="table table-responsive-sm table-bordered" style="width:60%;overflow-x: scroll">
          <thead>
            <tr>
              <th>รหัสหมายเลขผู้ใช้ไฟฟ้า</th>
              <th>ที่ตั้ง/โหนด 1</th>
              <th>ที่ตั้ง/โหนด 2</th>
              <th>จำนวนเงิน</th>
            </tr>
          </thead>
          @if(!empty($list))
          <tbody>
            @php
              $sum_prices = 0;
            @endphp
            @foreach($list as $key => $lists)
            <tr>
              <td align="center">{{ $lists->meter_id }}</td>
              <td>{{ $lists->node1 }}</td>
              <td>{{ $lists->node2 }}</td>
              <td align="right">{{ number_format($lists->price,2) }}</td>
            </tr>
            @php
              $sum_prices += $lists->price;
            @endphp
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <td align="right" colspan="3"><b>Sum</b></td>
              <td align="right"><b>{{ number_format(round($sum_prices,2),2) }}</b></td>
            </tr>
          </tfoot>
          @else
          <tbody>
            <tr>
              <td align="center" colspan="4">ไม่มีข้อมูล</td>
            </tr>
          </tbody>
        </table>
      </div>
      @endif


  </main>
@endsection

@section('js')
  <script src="{{ asset('admin/node_modules/popper.js/dist/umd/popper.min.js') }}"></script>
  <script src="{{ asset('admin/node_modules/bootstrap/dist/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('admin/node_modules/pace-progress/pace.min.js') }}"></script>
  <script src="{{ asset('admin/node_modules/perfect-scrollbar/dist/perfect-scrollbar.min.js') }}"></script>
  <script src="{{ asset('admin/node_modules/@coreui/coreui/dist/js/coreui.min.js') }}"></script>
@endsection
