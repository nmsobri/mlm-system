@if(Session::has('success'))
    <div class="row">
        <div class="col-xs-12">
            <div class="alert alert-success">
                <button class="close" data-dismiss="alert">×</button>
                {{Session::get('success')}}
            </div>
        </div>
    </div>
@endif

@if(Session::has('notice'))
    <div class="row">
        <div class="col-xs-12">
            <div class="alert alert-warning">
                <button class="close" data-dismiss="alert">×</button>
                {{Session::get('notice')}}
            </div>
        </div>
    </div>
@endif

@if(Session::has('error'))
    <div class="row">
        <div class="col-xs-12">
            <div class="alert alert-danger">
                <button class="close" data-dismiss="alert">×</button>
                {{Session::get('error')}}
            </div>
        </div>
    </div>
@endif


