@extends('layouts.superadmin')

@section('content.header')

    <div id="content-header">
        <h1>Edit User</h1>
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
                    <h5>Edit User</h5>
                </div>

                <div class="widget-content nopadding">

                    {{Form::open(['url'=>'/admin/super/update', 'class'=>'form-horizontal'])}}

                        <div class="form-group{{$errors->has('username') ? ' has-error' : ''}}">
                            {{Form::label('username','Username',['class'=>'col-sm-3 col-md-3 col-lg-2 control-label'])}}
                            <div class="col-sm-9 col-md-9 col-lg-10">
                                {{Form::text('username', $user[0]->username,['readonly'=>true, 'class'=>'form-control input-sm'])}}
                                {{ $errors->first('username', '<span class="help-inline">:message</span>') }}
                            </div>
                        </div>

                        <div class="form-group{{$errors->has('status') ? ' has-error' : ''}}">
                            {{Form::label('status','Status',['class'=>'col-sm-3 col-md-3 col-lg-2 control-label'])}}
                            <div class="col-sm-9 col-md-9 col-lg-10">
                                {{Form::select('status', [''=>'Please Select', 'active'=>'Active','inactive'=>'Inactive'], $user[0]->status,['class'=>'form-control input-sm'])}}
                                {{ $errors->first('status', '<span class="help-inline">:message</span>') }}
                            </div>
                        </div>

                        <div class="form-group{{$errors->has('groups') ? ' has-error' : ''}}">
                            {{Form::label('groups','Group',['class'=>'col-sm-3 col-md-3 col-lg-2 control-label'])}}
                            <div class="col-sm-9 col-md-9 col-lg-10">
                                {{Form::select('groups', [''=>'Please Select','regular_admin'=>'Regular Admin', 'super_admin'=>'Super Admin'], $user[0]->groups,['class'=>'form-control input-sm'])}}
                                {{ $errors->first('groups', '<span class="help-inline">:message</span>') }}
                            </div>
                        </div>

                        <div class="form-group{{$errors->has('full_name') ? ' has-error' : ''}}">
                            {{Form::label('full_name','Full Name',['class'=>'col-sm-3 col-md-3 col-lg-2 control-label'])}}
                            <div class="col-sm-9 col-md-9 col-lg-10">
                                {{Form::text('full_name', $user[0]->full_name,['class'=>'form-control input-sm'])}}
                                {{ $errors->first('full_name', '<span class="help-inline">:message</span>') }}
                            </div>
                        </div>

                        <div class="form-group{{$errors->has('ic_num') ? ' has-error' : ''}}">
                            {{Form::label('ic_num','Ic Number',['class'=>'col-sm-3 col-md-3 col-lg-2 control-label'])}}
                            <div class="col-sm-9 col-md-9 col-lg-10">
                                {{Form::text('ic_num', $user[0]->ic_num,['class'=>'form-control input-sm'])}}
                                {{ $errors->first('ic_num', '<span class="help-inline">:message</span>') }}
                            </div>
                        </div>

                        <div class="form-group{{$errors->has('gender') ? ' has-error' : ''}}">
                            {{Form::label('gender','Gender',['class'=>'col-sm-3 col-md-3 col-lg-2 control-label'])}}
                            <div class="col-sm-9 col-md-9 col-lg-10">
                                {{Form::select('gender', [''=>'Please Select', 'male'=>'Male', 'female'=>'Female'], $user[0]->gender,['class'=>'form-control input-sm'])}}
                                {{ $errors->first('gender', '<span class="help-inline">:message</span>') }}
                            </div>
                        </div>

                        <div class="form-group{{$errors->has('contact_num') ? ' has-error' : ''}}">
                            {{Form::label('contact_num','Contact Number',['class'=>'col-sm-3 col-md-3 col-lg-2 control-label'])}}
                            <div class="col-sm-9 col-md-9 col-lg-10">
                                {{Form::text('contact_num', $user[0]->contact_num,['class'=>'form-control input-sm'])}}
                                {{ $errors->first('contact_num', '<span class="help-inline">:message</span>') }}
                            </div>
                        </div>

                        {{Form::hidden('id', $id)}}

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