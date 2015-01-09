@extends('layouts.superadmin')

@section('content.header')

    <div id="content-header">
        <h1>Home</h1>
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
                    <h5>User List</h5>
                </div>

                <div class="widget-content">

                    @if( $users->count() > 0 )

                        {{HTML::link('/admin/super/report/user/excel', 'Export to excel')}}
                        {{HTML::link('/admin/super/report/user/pdf', 'Export to pdf')}}

                        @foreach( $users as $user )

                            <p>Username:{{$user->username}}</p>
                            <p>Status:{{$user->status}}</p>
                            <p>Group:{{$user->groups}}</p>
                            <p>Last Login:{{$user->last_login}}</p>
                            <p>Full Name:{{$user->full_name}}</p>
                            <p>Ic Number:{{$user->ic_num}}</p>
                            <p>Gender:{{$user->gender}}</p>
                            <p>Contact Number:{{$user->contact_num}}</p>
                            <p>Picture:{{$user->picture}}</p>
                            <p>Appointed Date:{{$user->contact_num}}</p>
                            <p>Superadmin Username:{{$user->super_admin_username}}</p>
                            <p>Superadmin Full Name:{{$user->super_admin_fullname}}</p>

                            <a href="{{url('/admin/super/update', $user->id)}}">Edit</a>
                            <a href="{{url('/admin/super/delete',$user->id)}}" onclick="return confirm('Are you sure? This will delete all admins under this admin, and all downlines under this admin too. Proceed?')">Delete</a>

                            <hr/>

                        @endforeach

                        {{$users->links()}}

                    @else

                        No users

                    @endif

                </div>

            </div>

        </div>

    </div>

@stop