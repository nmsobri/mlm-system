@extends('layouts.regularuser')

@section('content.header')

    <div id="content-header">
        <h1>Grid Layout</h1>
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
                    <h5>Create Regular User</h5>
                </div>

                <div class="widget-content nopadding">

                    {{Form::open(['url'=>'/user/regular/create', 'class'=>'form-horizontal'])}}

                        <div class="form-group{{$errors->has('username') ? ' has-error' : ''}}">
                            {{Form::label('username','Username',['class'=>'col-sm-3 col-md-3 col-lg-2 control-label'])}}
                            <div class="col-sm-9 col-md-9 col-lg-10">
                                {{Form::text('username', null,['class'=>'form-control input-sm'])}}
                                {{ $errors->first('username', '<span class="help-inline">:message</span>') }}
                            </div>
                        </div>

                        <div class="form-group{{$errors->has('password') ? ' has-error' : ''}}">
                            {{Form::label('password','Password',['class'=>'col-sm-3 col-md-3 col-lg-2 control-label'])}}
                            <div class="col-sm-9 col-md-9 col-lg-10">
                                {{Form::password('password', ['class'=>'form-control input-sm'])}}
                                {{ $errors->first('password', '<span class="help-inline">:message</span>') }}
                            </div>
                        </div>

                        <div class="form-group{{$errors->has('password_confirm') ? ' has-error' : ''}}">
                            {{Form::label('password_confirm','Password Confirm',['class'=>'col-sm-3 col-md-3 col-lg-2 control-label'])}}
                            <div class="col-sm-9 col-md-9 col-lg-10">
                                {{Form::password('password_confirm', ['class'=>'form-control input-sm'])}}
                                {{ $errors->first('password_confirm', '<span class="help-inline">:message</span>') }}
                            </div>
                        </div>

                        <div class="form-group{{$errors->has('status') ? ' has-error' : ''}}">
                            {{Form::label('status','Status',['class'=>'col-sm-3 col-md-3 col-lg-2 control-label'])}}
                            <div class="col-sm-9 col-md-9 col-lg-10">
                                {{Form::select('status', [''=>'Please Select', 'active'=>'Active','inactive'=>'Inactive'],null,['class'=>'form-control input-sm'])}}
                                {{ $errors->first('status', '<span class="help-inline">:message</span>') }}
                            </div>
                        </div>

                        <div class="form-group{{$errors->has('full_name') ? ' has-error' : ''}}">
                            {{Form::label('full_name','Full Name',['class'=>'col-sm-3 col-md-3 col-lg-2 control-label'])}}
                            <div class="col-sm-9 col-md-9 col-lg-10">
                                {{Form::text('full_name', null,['class'=>'form-control input-sm'])}}
                                {{ $errors->first('full_name', '<span class="help-inline">:message</span>') }}
                            </div>
                        </div>

                        <div class="form-group{{$errors->has('email') ? ' has-error' : ''}}">
                            {{Form::label('email','Email',['class'=>'col-sm-3 col-md-3 col-lg-2 control-label'])}}
                            <div class="col-sm-9 col-md-9 col-lg-10">
                                {{Form::text('email', null,['class'=>'form-control input-sm'])}}
                                {{ $errors->first('email', '<span class="help-inline">:message</span>') }}
                            </div>
                        </div>

                        <div class="form-group{{$errors->has('ic_num') ? ' has-error' : ''}}">
                            {{Form::label('ic_num','Ic Number',['class'=>'col-sm-3 col-md-3 col-lg-2 control-label'])}}
                            <div class="col-sm-9 col-md-9 col-lg-10">
                                {{Form::text('ic_num', null,['class'=>'form-control input-sm'])}}
                                {{ $errors->first('ic_num', '<span class="help-inline">:message</span>') }}
                            </div>
                        </div>

                        <div class="form-group{{$errors->has('gender') ? ' has-error' : ''}}">
                            {{Form::label('gender','Gender',['class'=>'col-sm-3 col-md-3 col-lg-2 control-label'])}}
                            <div class="col-sm-9 col-md-9 col-lg-10">
                                {{Form::select('gender', [''=>'Please Select', 'male'=>'Male', 'female'=>'Female'],null,['class'=>'form-control input-sm'])}}
                                {{ $errors->first('gender', '<span class="help-inline">:message</span>') }}
                            </div>
                        </div>

                        <div class="form-group{{$errors->has('contact_num') ? ' has-error' : ''}}">
                            {{Form::label('contact_num','Contact Number',['class'=>'col-sm-3 col-md-3 col-lg-2 control-label'])}}
                            <div class="col-sm-9 col-md-9 col-lg-10">
                                {{Form::text('contact_num', null,['class'=>'form-control input-sm'])}}
                                {{ $errors->first('contact_num', '<span class="help-inline">:message</span>') }}
                            </div>
                        </div>

                        <div class="form-group{{$errors->has('heir_name') ? ' has-error' : ''}}">
                            {{Form::label('heir_name','Heir Name',['class'=>'col-sm-3 col-md-3 col-lg-2 control-label'])}}
                            <div class="col-sm-9 col-md-9 col-lg-10">
                                {{Form::text('heir_name', null,['class'=>'form-control input-sm'])}}
                                {{ $errors->first('heir_name', '<span class="help-inline">:message</span>') }}
                            </div>
                        </div>

                        <div class="form-group{{$errors->has('heir_contact_num') ? ' has-error' : ''}}">
                            {{Form::label('heir_contact_num','Heir Contact Number',['class'=>'col-sm-3 col-md-3 col-lg-2 control-label'])}}
                            <div class="col-sm-9 col-md-9 col-lg-10">
                                {{Form::text('heir_contact_num', null,['class'=>'form-control input-sm'])}}
                                {{ $errors->first('heir_contact_num', '<span class="help-inline">:message</span>') }}
                            </div>
                        </div>

                        <div class="form-group{{$errors->has('bank_account') ? ' has-error' : ''}}">
                            {{Form::label('bank_account','Bank Account',['class'=>'col-sm-3 col-md-3 col-lg-2 control-label'])}}
                            <div class="col-sm-9 col-md-9 col-lg-10">
                                {{Form::select('bank_account',[ '' => 'Please Select', 'myb' => 'Malayan Banking Berhad','cim' => 'Cimb Bank Berhad', 'pbb' => 'Public Bank berhad', 'hlb' => 'Hong Leong Bank Berhad','amb' => 'AmBank Berhad', 'rhb' => 'RHB Bank', 'alb' => 'Alliance Bank', 'afb' => 'Affin Bank Berhad'],null,['class'=>'form-control input-sm'])}}
                                {{ $errors->first('bank_account', '<span class="help-inline">:message</span>') }}
                            </div>
                        </div>

                        <div class="form-group{{$errors->has('account_num') ? ' has-error' : ''}}">
                            {{Form::label('account_num','Account Number',['class'=>'col-sm-3 col-md-3 col-lg-2 control-label'])}}
                            <div class="col-sm-9 col-md-9 col-lg-10">
                                {{Form::text('account_num', null,['class'=>'form-control input-sm'])}}
                                {{ $errors->first('account_num', '<span class="help-inline">:message</span>') }}
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