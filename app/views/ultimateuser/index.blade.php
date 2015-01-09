@extends('layouts.ultimateuser')

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
                    <h5>Home</h5>
                </div>

                <div class="widget-content">

                    @if( $users->count() > 0 )

                        @foreach($users as $user )

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
                            <p>Heir Name:{{$user->heir_name}}</p>
                            <p>Heir Contact Number:{{$user->heir_contact_num}}</p>
                            <p>Bank Account:{{$user->bank_account}}</p>
                            <p>Account Number:{{$user->account_num}}</p>
                            <p>Upline Username:{{$user->upline_username}}</p>
                            <p>Upline Full Name:{{$user->upline_fullname}}</p>

                            <a href="{{url('/user/ultimate/update', $user->id)}}">Edit</a>
                            <a href="{{url('/user/ultimate/delete',$user->id)}}" onclick="return confirm('Are you sure? This will delete all downlines under this user. Proceed?')">Delete</a>

                            <hr/>

                        @endforeach

                        {{$users->links()}}

                    @else

                        No user list

                    @endif

                </div>

            </div>

        </div>

    </div>

@stop