<!DOCTYPE html>
<html>

<head lang="en">

    @section('meta')
        <meta charset="UTF-8">
        <meta name="description" content="Mlm">
        <meta name="keywords" content="Mlm">
        <meta name="author" content="slier">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @show

    <title>@yield('title', 'Dasyat')</title>

    @section('css')
        {{HTML::style('css/bootstrap.css');}}
        {{HTML::style('css/font.awesome.css');}}
        {{HTML::style('css/unicorn.css');}}
    @show

    @section('ie')
        <!--[if lt IE 9]>
            {{ HTML::script('js/respond.js') }}
        <![endif]-->
    @show

</head>

<body data-color="grey" class="flat">

    <div id="wrapper">

        <div id="header">
            <h1><a href="./index.html">Unicorn Admin</a></h1>
            <a id="menu-trigger" href="#"><i class="fa fa-bars"></i></a>
        </div>

        @yield('user.nav')

        @yield('sidebar.nav')

        <div id="content">

            @yield('content.header')

            @yield('breadcrumb')

            @include('partials.notification')

            @yield('content')

        </div>

        <div class="row">
            <div id="footer" class="col-xs-12">
                2014 - {{date('Y')}} &copy; <a href="javascript:;">Dasyat</a>
            </div>
        </div>

    </div>

    @yield('modal')

    @section('js')
        {{ HTML::script('js/jquery.js') }}
        {{ HTML::script('js/jquery.ui.custom.js') }}
        {{ HTML::script('js/bootstrap.js') }}
        {{ HTML::script('js/jquery.nicescroll.js') }}
        {{ HTML::script('js/unicorn.js') }}
    @show

</body>

</html>