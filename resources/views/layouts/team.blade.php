<!DOCTYPE html>
<html>
    <head>
        <title>Survival Fury</title>
        <link href="/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="/assets/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css"/>
        <link href="/assets/css/public.css" rel="stylesheet" type="text/css"/>
        <link rel="shortcut icon" href="/assets/images/favicon.png">
    </head>
    <body>
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Remnant Console v15.0.5</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                    @if ( isset($user) )
                        <li><a href="#">Dashboard</a></li>
                        <li><a href="#" data-toggle="modal" data-target="#messages-list-modal">Messages <span class="badge ">{{ count($user->receivedMessages->where('read', 0)) }}</span></a></li>
                        <li><a href="#" data-toggle="modal" data-target="#user-help-modal">Help</a></li>
                        <li><a href="/auth/logout">Logout</a></li>
                    @else
                        <li><a href="/auth/login">Login</a></li>
                    @endif
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container">
            @yield('content')

            @yield('modals')
        </div>

         <!-- Bootstrap core JavaScript
         ================================================== -->
         <!-- Placed at the end of the document so the pages load faster -->
         <script src="/assets/js/jquery.min.js"></script>
         <script src="/assets/js/bootstrap.min.js"></script>
         <script src="/assets/js/alertify.js"></script>
         <script src="/assets/js/datatables.min.js"></script>
        @yield('scripts')
    </body>
</html>
