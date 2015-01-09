@extends('layouts.ultimateuser')

@section('content.header')

    <div id="content-header">
        <h1>Request Payout</h1>
        <div class="btn-group">
            <a class="btn btn-large" title="Manage Files"><i class="fa fa-file"></i></a>
            <a class="btn btn-large" title="Manage Users"><i class="fa fa-user"></i></a>
            <a class="btn btn-large" title="Manage Comments"><i class="fa fa-comment"></i><span class="label label-danger">5</span></a>
            <a class="btn btn-large" title="Manage Orders"><i class="fa fa-shopping-cart"></i></a>
        </div>
    </div>

@stop

@section('breadcrumb')

    <div id="breadcrumb">
        <a href="#" title="Go to Home" class="tip-bottom"><i class="fa fa-home"></i> SuperAdmin Home</a>
    </div>

@stop

@section('content')

    <div class="row">

        <div class="col-xs-12">

            <div class="widget-box">

                <div class="widget-title">
                    <span class="icon"><i class="fa fa-th-list"></i></span>
                    <h5>Request Payout</h5>
                </div>

                <div class="widget-content nopadding">

                    {{Form::open(['url'=>'/user/ultimate/account/payment', 'class'=>'form-horizontal'])}}

                        <div class="form-group{{$errors->has('amount') ? ' has-error' : ''}}">
                            {{Form::label('amount','Amount',['class'=>'col-sm-3 col-md-3 col-lg-2 control-label'])}}
                            <div class="col-sm-9 col-md-9 col-lg-10">
                                {{Form::text('amount', null,['class'=>'form-control input-sm'])}}
                                {{ $errors->first('amount', '<span class="help-inline">:message</span>') }}
                            </div>
                        </div>

                        <div class="form-group form-actions">
                            <span class="col-sm-3 col-md-3 col-lg-2 control-label"></span>
                            <div class="col-sm-9 col-md-9 col-lg-10">
                                {{Form::submit('Submit',['class'=>'btn btn-primary btn-sm'])}}
                            </div>
                        </div>

                    {{Form::close()}}

                </div>

            </div>

        </div>

    </div>

@stop