@extends('layouts.superadmin')

@section('content.header')

    <div id="content-header">
        <h1>User List</h1>
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
                    <span class="icon">
                        <i class="fa fa-th"></i>
                    </span>
                    <h5>User List</h5>
                    <div class="report">
                        {{html_entity_decode(HTML::link('/admin/super/report/user/excel', '<i class="fa fa-file-excel-o fa-lg"></i>'))}}
                        {{html_entity_decode(HTML::link('/admin/super/report/user/pdf', '<i class="fa fa-file-pdf-o fa-lg"></i>'))}}
                    </div>
                </div>

                <div class="widget-content{{($users->count() > 0) ? ' nopadding':''}}">

                    @if( $users->count() > 0 )

                        <table class="table table-bordered table-striped table-hover">

                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>Status</th>
                                    <th>Group</th>
                                    <th>Last Login</th>
                                    <th>Full Name</th>
                                    <th>Ic Number</th>
                                    <th>Gender</th>
                                    <th>Contact Number</th>
                                    <th>Appointed Date</th>
                                    <th>Superadmin</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach($users as $user)

                                    <tr>
                                        <td>{{$user->username}}</td>
                                        <td>{{ucwords($user->status)}}</td>
                                        <td>{{ucwords(str_replace('_', ' ', $user->groups))}}</td>
                                        <td>{{($user->last_login) ? date_format(date_create($user->last_login), 'Y-m-d') : 'None'}}</td>
                                        <td>{{ucwords($user->full_name)}}</td>
                                        <td>{{$user->ic_num}}</td>
                                        <td>{{ucwords($user->gender)}}</td>
                                        <td>{{$user->contact_num}}</td>
                                        <td>{{date_format(date_create($user->appointed_date), 'Y-m-d')}}</td>
                                        <td>{{($user->super_admin_username) ? $user->super_admin_username : 'None'}}</td>
                                        <td>
                                            <a href="{{url('/admin/super/update', $user->id)}}">Edit</a>
                                            <a href="{{url('/admin/super/delete',$user->id)}}" onclick="return confirm('Are you sure? This will delete all admins under this admin, and all downlines under this admin too. Proceed?')">Delete</a>
                                        </td>
                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    @else

                        No users list

                    @endif

                </div>

            </div>

            {{$users->links()}}

        </div>

    </div>

@stop