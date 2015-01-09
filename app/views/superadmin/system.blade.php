@extends('layouts.superadmin')

@section('content.header')

    <div id="content-header">
        <h1>System Account</h1>
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
                    <h5>Create System Account For Point System</h5>
                </div>

                <div class="widget-content nopadding">

                    {{Form::open(['url'=>'/admin/super/create/system', 'class'=>'form-horizontal'])}}

                        <div class="form-group{{$errors->has('system_name') ? ' has-error' : ''}}">
                            {{Form::label('system_name','System Name',['class'=>'col-sm-3 col-md-3 col-lg-2 control-label'])}}
                            <div class="col-sm-9 col-md-9 col-lg-10">
                                {{Form::text('system_name',null,['class'=>'form-control input-sm'])}}
                                {{ $errors->first('system_name', '<span class="help-inline">:message</span>') }}
                            </div>
                        </div>

                        <div class="form-group{{$errors->has('system_contact_num') ? ' has-error' : ''}}">
                            {{Form::label('system_contact_num','System Contact Number',['class'=>'col-sm-3 col-md-3 col-lg-2 control-label'])}}
                            <div class="col-sm-9 col-md-9 col-lg-10">
                                {{Form::text('system_contact_num', null,['class'=>'form-control input-sm'])}}
                                {{ $errors->first('system_contact_num', '<span class="help-inline">:message</span>') }}
                            </div>
                        </div>

                        <div class="form-group{{$errors->has('system_bank_account') ? ' has-error' : ''}}">
                            {{Form::label('system_bank_account','System Bank Account',['class'=>'col-sm-3 col-md-3 col-lg-2 control-label'])}}
                            <div class="col-sm-9 col-md-9 col-lg-10">
                                {{Form::select('system_bank_account',[ '' => 'Please Select', 'myb' => 'Malayan Banking Berhad','cim' => 'Cimb Bank Berhad', 'pbb' => 'Public Bank berhad', 'hlb' => 'Hong Leong Bank Berhad','amb' => 'AmBank Berhad', 'rhb' => 'RHB Bank', 'alb' => 'Alliance Bank', 'afb' => 'Affin Bank Berhad'],null,['class'=>'form-control input-sm'])}}
                                {{ $errors->first('system_bank_account', '<span class="help-inline">:message</span>') }}
                            </div>
                        </div>

                        <div class="form-group{{$errors->has('system_account_num') ? ' has-error' : ''}}">
                            {{Form::label('system_account_num','System Bank Account Number',['class'=>'col-sm-3 col-md-3 col-lg-2 control-label'])}}
                            <div class="col-sm-9 col-md-9 col-lg-10">
                                {{Form::text('system_account_num', null,['class'=>'form-control input-sm'])}}
                                {{ $errors->first('system_account_num', '<span class="help-inline">:message</span>') }}
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