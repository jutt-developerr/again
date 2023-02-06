@extends('admin.layouts.app')
@section('title', 'Main page')

@section('content')

    <!-- Start Page content -->
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-sm-12">
                    <div class="box">
<h2>@lang('view_pages.envato_verify_purchase')</h2>
                        <div class="box-header with-border">
                            <a href="{{ url('dashboard') }}">
                                <button class="btn btn-danger btn-sm pull-right" type="submit">
                                    <i class="mdi mdi-keyboard-backspace mr-2"></i>
                                    @lang('view_pages.back')
                                </button>
                            </a>
                        </div>

                        <div class="col-sm-12">

                            <form method="post" class="form-horizontal" action="{{ url('purchasecode/verification') }}"
                                enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <span class="text-danger">{{ $errors->first('please_contact_your_admin') }}</span>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="envato_user_name">@lang('view_pages.envato_user_name') <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" id="envato_user_name" name="envato_user_name"
                                                value="{{ old('envato_user_name') }}" required=""
                                                placeholder="@lang('view_pages.enter_envato_user_name')">
                                            <span class="text-danger">{{ $errors->first('envato_user_name') }}</span>

                                        </div>
                                    </div>
                                  </div>
                             <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="envato_purchase_code">@lang('view_pages.envato_purchase_code') <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" id="envato_purchase_code" name="envato_purchase_code"
                                                value="{{ old('envato_purchase_code') }}" required=""
                                                placeholder="@lang('view_pages.enter_envato_purchase_code')">
                                            <span class="text-danger">{{ $errors->first('envato_purchase_code') }}</span> <br>
                                            <u><a href="#" onClick="window.open('https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code', '_blank')">@lang('view_pages.where_is_my_purchase_code')</a></u>

                                        </div>
                                    </div>
                                  </div>
                                
                                <div class="form-group">
                                    <div class="col-1">
                                        <button class="btn btn-primary btn-sm pull-right m-5" type="submit">
                                            @lang('view_pages.verify_here')
                                        </button>
                                    </div>
                                </div>

                            </form>

                        </div>
                    </div>


                </div>
            </div>
        </div>

    </div>
    <!-- container -->

    </div>
    <!-- content -->

@endsection
