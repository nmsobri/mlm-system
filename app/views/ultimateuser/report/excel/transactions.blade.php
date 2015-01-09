 @foreach($transactions as $transaction)

    <br/>
    Amount:{{$transaction->amount}}
    Status:{{$transaction->status}}
    Request Date:{{$transaction->created}}

    @if( is_null( $transaction->processor_fullname ) )

        Process By: Waiting to be process
        Process Date: Waiting to be process

    @else

        Process By: {{$transaction->processor_fullname}}
        Process Date: {{$transaction->processed}}

    @endif


    @if( in_array( $transaction->status, ['rejected', 'approved'] ) )

        Process this request

    @else

        <a href="{{url('/admin/super/transaction/process', $transaction->id)}}">Process this request</a>

    @endif

    <br/>

@endforeach