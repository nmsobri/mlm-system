@extends('layouts.regularadmin')

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
                        {{html_entity_decode(HTML::link('/admin/regular/report/user/excel', '<i class="fa fa-file-excel-o fa-lg"></i>'))}}
                        {{html_entity_decode(HTML::link('/admin/regular/report/user/pdf', '<i class="fa fa-file-pdf-o fa-lg"></i>'))}}
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
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>

                            @foreach($users as $key =>$user)

                                <tr>
                                    <td>{{$user->username}}</td>
                                    <td>{{ucwords($user->status)}}</td>
                                    <td>{{ucwords(str_replace('_', ' ', $user->groups))}}</td>
                                    <td>{{($user->last_login) ? $user->last_login : 'None'}}</td>
                                    <td>{{ucwords($user->full_name)}}</td>
                                    <td>{{$user->ic_num}}</td>
                                    <td>{{ucwords($user->gender)}}</td>
                                    <td>{{$user->contact_num}}</td>
                                    <td>{{date_format(date_create($user->appointed_date), 'Y-m-d')}}</td>
                                    <td>
                                        <a href="#user-modal" data-toggle="modal" data-user-id="{{$key}}">Detail</a>
                                        <a href="{{url('/admin/regular/update', $user->id)}}">Edit</a>
                                        <a href="{{url('/admin/regular/delete',$user->id)}}" onclick="return confirm('Are you sure? This will delete all admins under this admin, and all downlines under this admin too. Proceed?')">Delete</a>
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


@section('modal')

    @if($users->count()> 0)

        <div id="user-modal" class="modal fade" aria-hidden="true" data-users='{{$users->toJson()}}'>

            <div class="modal-dialog">

                <div class="modal-content">

                    <div class="modal-header">
                        <button data-dismiss="modal" class="close" type="button">×</button>
                        <h3>User Detail</h3>
                    </div>

                    <div class="modal-body">
                        <p>Username:<span id="user-username">{{$user->username}}</span></p>
                        <p>Status:<span id="user-status">{{$user->status}}</span></p>
                        <p>Group:<span id="user-group">{{$user->groups}}</span></p>
                        <p>Last Login:<span id="user-last-login">{{$user->last_login}}</span></p>
                        <p>Full Name:<span id="user-full-name">{{$user->full_name}}</span></p>
                        <p>Ic Number:<span id="user-ic-num">{{$user->ic_num}}</span></p>
                        <p>Gender:<span id="user-gender">{{$user->gender}}</span></p>
                        <p>Contact Number:<span id="user-contact-num">{{$user->contact_num}}</span></p>
                        <p>Picture:<span id="user-picture">{{$user->picture}}</span></p>
                        <p>Appointed Date:<span id="user-appointed-date">{{$user->contact_num}}</span></p>
                        <p>Heir Name:<span id="user-heir-name">{{$user->heir_name}}</span></p>
                        <p>Heir Contact Number:<span id="user-heir-contact-num">{{$user->heir_contact_num}}</span></p>
                        <p>Bank Account:<span id="user-bank-account">{{$user->bank_account}}</span></p>
                        <p>Account Number:<span id="user-account-num">{{$user->account_num}}</span></p>
                        <p>Upline Username:<span id="user-upline-username">{{$user->upline_username}}</span></p>
                        <p>Upline Full Name:<span id="user-upline-user-fullname">{{$user->upline_fullname}}</span></p>
                    </div>

                    <div class="modal-footer">
                        <a data-dismiss="modal" class="btn btn-primary btn-small" href="#">Ok</a>
                    </div>

                </div>

            </div>

        </div>

    @endif

@stop


@section('js')
    @parent
    <script type="text/javascript">

        $(function(){

            $('body').on('hidden.bs.modal', '.modal', function () {
                $(this).removeData('bs.modal');
            });

            $('#user-modal').on('show.bs.modal', function(e) {
                var user_id = $(e.relatedTarget).data('user-id');
                var user_data = $(this).data('users')['data'];
                var user = user_data[user_id];

                $('#user-username').html(user_data[user_id]['username']);
                $('#user-status').html(user_data[user_id]['status']);
                $('#user-group').html(user_data[user_id]['groups']);
                $('#user-last-login').html(user_data[user_id]['last_login']);
                $('#user-full-name').html(user_data[user_id]['full_name']);
                $('#user-ic-num').html(user_data[user_id]['ic_num']);
                $('#user-gender').html(user_data[user_id]['gender']);
                $('#user-contact-num').html(user_data[user_id]['contact_num']);
                $('#user-picture').html(user_data[user_id]['picture']);
                $('#user-appointed-date').html(user_data[user_id]['contact_num']);
                $('#user-heir-name').html(user_data[user_id]['heir_name']);
                $('#user-heir-contact-num').html(user_data[user_id]['heir_contact_num']);
                $('#user-bank-account').html(user_data[user_id]['bank_account']);
                $('#user-account-num').html(user_data[user_id]['account_num']);
                $('#user-upline-username').html(user_data[user_id]['upline_username']);
                $('#user-upline-user-fullname').html(user_data[user_id]['upline_fullname']);
            });
        });

    </script>
@stop