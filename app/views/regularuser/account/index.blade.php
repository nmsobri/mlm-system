@extends('layouts.regularuser')

@section('content.header')

    <div id="content-header">
        <h1>Account</h1>
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
                    <h5>User Account</h5>
                </div>

                <div class="widget-content">

                    <p>Your Account Balance Is : {{$point}}</p>

                    <p><a href="{{url('user/regular/account/payment')}}">Request Payout</a></p>

                </div>

            </div>

        </div>

    </div>

    <div class="row">

        <div class="col-xs-12">

            <div class="widget-box">

                <div class="widget-title">
                    <span class="icon"><i class="fa fa-th-list"></i></span>
                    <h5>User Transaction</h5>

                    @if( $transactions->count() > 0 )

                            <div class="report">
                                {{html_entity_decode(HTML::link('/user/regular/report/transaction/excel', '<i class="fa fa-file-excel-o fa-lg"></i>'))}}
                                {{html_entity_decode(HTML::link('/user/regular/report/transaction/pdf', '<i class="fa fa-file-pdf-o fa-lg"></i>'))}}
                            </div>

                        @endif

                </div>

                <div class="widget-content{{($transactions->count() > 0) ? ' nopadding':''}}">

                    @if( $transactions->count() > 0 )

                        <table class="table table-bordered table-striped table-hover">

                            <thead>
                            <tr>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                            </thead>

                            <tbody>

                            @foreach($transactions as $transaction)

                                <tr>
                                    <td>{{$transaction->amount}}</td>
                                    <td>{{ucwords($transaction->status)}}</td>
                                    <td>{{date_format(date_create($transaction->created), 'Y-m-d')}}</td>
                                </tr>

                            @endforeach

                            </tbody>

                        </table>


                    @else

                        You have no transaction

                    @endif

                </div>

            </div>

            {{$transactions->links()}}

        </div>

    </div>

@stop