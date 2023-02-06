<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>
    <meta charset="utf-8" />
    <title>@lang('view_pages.admin_login')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <!-- <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}"> -->
    <link rel="shortcut icon" href="{{ fav_icon() ?? asset('assets/images/favicon.ico') }}">

    <!-- Bootstrap 4.0-->
    <link rel="stylesheet" href="{{ url('assets/vendor_components/bootstrap/dist/css/bootstrap.min.css') }}">

    <!-- Bootstrap extend-->
    <link rel="stylesheet" href="{{ url('assets/css/bootstrap-extend.css') }}">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url('assets/css/master_style.css') }}">

    <!-- Fab Admin skins -->
    <link rel="stylesheet" href="{{ url('assets/css/skins/_all-skins.css') }}">
    <style>
        .error-style {
            list-style: none;
            color: red;
            text-align: center;
            margin-top: 15%;
            padding: 0;
        }

    

    </style>
</head>

<body>

<section class="vh-100 " style="background-color: white;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card shadow-2-strong" style="border-radius: 1rem; margin-top:100px;">
          <div class="card-body p-10 text-center" style="background:#E5E4E2;">
          <form method="post" action="{{ url('reset-password') }}" enctype="multipart/form-data">
             @csrf
            <h3 class="mb-5">Reset Your Password Here</h3><br>
            <div class="form-group">
            <input type="hidden" name="oldtoken" value="{{$token}}">
              <input type="Password" placeholder="Password" name ="password" id="password" class="form-control form-control-lg" />
              <span class="text-danger">{{ $errors->first('password') }}</span>
            </div>

            <div class="form-group">
              <input type="password" placeholder="Re Enter Password"  name ="password_confirmation" id="typePasswordX-2" class="form-control form-control-lg" />
              <span class="text-danger">{{ $errors->first('password') }}</span>
            </div>      

            <button class="btn btn-primary btn-lg btn-block" type="submit">Submit</button>

            <hr class="my-4">

            <!-- <button class="btn btn-lg btn-block btn-primary" style="background-color: #dd4b39;"
              type="submit"><i class="fab fa-google me-2"></i> Sign in with google</button>
            <button class="btn btn-lg btn-block btn-primary mb-2" style="background-color: #3b5998;"
              type="submit"><i class="fab fa-facebook-f me-2"></i>Sign in with facebook</button> -->

          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</body>
</html>
