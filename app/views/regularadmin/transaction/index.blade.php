@extends('layouts.regularadmin')

@section('content.header')

    <div id="content-header">
        <h1>Transaction</h1>
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
                    <h5>Transaction</h5>

                    @if( $transactions->count() > 0 )

                        <div class="report">
                            {{html_entity_decode(HTML::link('/admin/regular/report/transaction/excel', '<i class="fa fa-file-excel-o fa-lg"></i>'))}}
                            {{html_entity_decode(HTML::link('/admin/regular/report/transaction/pdf', '<i class="fa fa-file-pdf-o fa-lg"></i>'))}}
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
                                <th>Request Date</th>
                                <th>Process by</th>
                                <th>Process Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>

                            @foreach($transactions as $transaction)

                                <tr>
                                    <td>{{$transaction->amount}}</td>
                                    <td>{{ucwords($transaction->status)}}</td>
                                    <td>{{date_format(date_create($transaction->created), 'Y-m-d')}}</td>
                                    <td> @if( is_null( $transaction->processor_fullname ) )Waiting to be process @else{{$transaction->processor_fullname}} @endif</td>
                                    <td> @if( is_null( $transaction->processor_fullname ) )Waiting to be process @else{{date_format(date_create($transaction->processed), 'Y-m-d')}} @endif</td>
                                    <td> @if( in_array( $transaction->status, ['rejected', 'approved'] ) )Process this request @else<a href="{{url('/admin/regular/transaction/process', $transaction->id)}}">Process this request</a> @endif</td>
                                </tr>

                            @endforeach

                            </tbody>

                        </table>

                    @else

                        No transaction list

                    @endif

                </div>

            </div>

            {{$transactions->links()}}

        </div>

    </div>

@stop