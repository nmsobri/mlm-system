@extends('layouts.master')

@section('user.nav')

    <div id="user-nav">
        <ul class="btn-group">
            <li class="btn" ><a title="" href="#"><i class="fa fa-user"></i> <span class="text">Profile</span></a></li>
            <li class="btn dropdown" id="menu-messages"><a href="#" data-toggle="dropdown" data-target="#menu-messages" class="dropdown-toggle"><i class="fa fa-envelope"></i> <span class="text">Messages</span> <span class="label label-danger">5</span> <b class="caret"></b></a></li>
            <li class="btn"><a title="" href="#"><i class="fa fa-cog"></i> <span class="text">Settings</span></a></li>
            <li class="btn"><a title="" href="{{url('user/ultimate/logout')}}"><i class="fa fa-power-off"></i> <span class="text">Logout</span></a></li>
        </ul>
    </div>

@stop

@section('sidebar.nav')

    <div id="sidebar">
        <div id="search">
            <input type="text" placeholder="Search here..."/><button type="submit" class="tip-right" title="Search"><i class="fa fa-search icon-white"></i></button>
        </div>
        <ul>
            <li><a href="{{url('user/ultimate/')}}"><i class="fa fa-home"></i> <span>Home</span></a></li>
            <li class="submenu">
                <a href="#"><i class="fa fa-users"></i> <span>User</span> <i class="arrow fa fa-chevron-right"></i></a>
                <ul style="display: none;">
                    <li><a href="{{url('user/ultimate/lists')}}">List User</a></li>
                    <li><a href="{{url('user/ultimate/create')}}">Create User</a></li>
                </ul>
            </li>
            <li><a href="{{url('user/ultimate/profile')}}"><i class="fa fa-user"></i> <span>Profile</span></a></li>
            <li><a href="{{url('user/ultimate/account')}}"><i class="fa fa-briefcase"></i> <span>Account</span></a></li>
        </ul>

    </div>

@stop