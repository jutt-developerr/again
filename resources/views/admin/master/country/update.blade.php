@extends('admin.layouts.app')
@section('title', 'Main page')

@section('content')
{{-- {{session()->get('errors')}} --}}

    <!-- Start Page content -->
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-sm-12">
                    <div class="box">

                        <div class="box-header with-border">
                            <a href="{{ url('country') }}">
                                <button class="btn btn-danger btn-sm pull-right" type="submit">
                                    <i class="mdi mdi-keyboard-backspace mr-2"></i>
                                    @lang('view_pages.back')
                                </button>
                            </a>
                        </div>

                        <div class="col-sm-12">

                            <form method="post" class="form-horizontal" action="{{ url('country/update',$item->id) }}">
                                @csrf

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="name">@lang('view_pages.name') <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" id="name" name="name"
                                                value="{{ old('name',$item->name) }}" required
                                                placeholder="@lang('view_pages.enter') @lang('view_pages.name')">
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="name">@lang('view_pages.dial_min_length') <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" id="dial_min_length" name="dial_min_length"
                                                value="{{ old('dial_min_length',$item->dial_min_length) }}" required
                                                placeholder="@lang('view_pages.enter') @lang('view_pages.dial_min_length')">
                                            <span class="text-danger">{{ $errors->first('dial_min_length') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="name">@lang('view_pages.dial_max_length') <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" id="dial_max_length" name="dial_max_length"
                                                value="{{ old('dial_max_length',$item->dial_max_length) }}" required
                                                placeholder="@lang('view_pages.enter') @lang('view_pages.dial_max_length')">
                                            <span class="text-danger">{{ $errors->first('dial_max_length') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="name">@lang('view_pages.currency_code') <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" id="currency_code" name="currency_code"
                                                value="{{ old('currency_code',$item->currency_code) }}" required
                                                placeholder="@lang('view_pages.enter') @lang('view_pages.currency_code')">
                                            <span class="text-danger">{{ $errors->first('currency_code') }}</span>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="name">@lang('view_pages.currency_symbol') <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" id="currency_symbol" name="currency_symbol"
                                                value="{{ old('currency_symbol',$item->currency_symbol) }}" required
                                                placeholder="@lang('view_pages.enter') @lang('view_pages.currency_symbol')">
                                            <span class="text-danger">{{ $errors->first('currency_symbol') }}</span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                    <div class="col-6">
                                        <label for="flag">@lang('view_pages.flag')</label><br>
                                        <img id="blah" src="{{ asset($item->flag) }}" alt=""><br>
                                        <input type="file" id="flag" onchange="readURL(this)" name="flag" style="display:none">
                                        <span data-toggle="tooltip" data-placement="right" title="upload image-size:30x20 px"><button class="btn btn-primary btn-sm" type="button" onclick="$('#flag').click()" id="upload" >@lang('view_pages.browse')</button></span>
                                        <button class="btn btn-danger btn-sm" type="button" id="remove_img" style="display: none;">@lang('view_pages.remove')</button><br>
                                        <span class="text-danger">{{ $errors->first('flag') }}</span>
                                </div>
                            </div>

                                                            </div>


                                <div class="form-group">
                                    <div class="col-12">
                                        <button class="btn btn-primary btn-sm pull-right m-5" type="submit">
                                            @lang('view_pages.update')
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
