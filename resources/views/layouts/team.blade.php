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
                        <li><a href="#" onclick="window.location.reload()">Refresh</a></li>
                        <li><a href="#" data-toggle="modal" data-target="#messages-list-modal">Messages <span class="badge ">{{ count($user->receivedMessages->where('read', 0)) }}</span></a></li>
                        <li><a href="#" data-toggle="modal" data-target="#user-help-modal">Help</a></li>
                        <li><a href="/auth/logout">Logout</a></li>
                    @else
                        <li><a href="#" data-toggle="modal" data-target="#user-help-modal">Help</a></li>
                        <li><a href="/auth/login">Login</a></li>
                    @endif
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container">
            @yield('content')

            @yield('modals')
            <div class="modal fade" id="user-help-modal">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Help module</h4>
                  </div>
                  <div class="modal-body">
                    <h1>Need help? Select a topic</h1>
                    <div class="row">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#training" data-toggle="tab" aria-expanded="true">Training</a></li>
                            <li class=""><a href="#roles" data-toggle="tab" aria-expanded="false">Roles</a></li>
                        </ul>
                        <div id="myTabContent" class="tab-content">
                            <div class="tab-pane fade active in" id="training">
                                <p>Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica. Reprehenderit butcher retro keffiyeh dreamcatcher synth. Cosby sweater eu banh mi, qui irure terry richardson ex squid. Aliquip placeat salvia cillum iphone. Seitan aliquip quis cardigan american apparel, butcher voluptate nisi qui.</p>
                            </div>

                            <div class="tab-pane fade " id="roles">
                                <div class="panel">
                                    <div class="panel-heading">VANGUARD</div>
                                    <div class="panel-body">
                                        <p>The Vanguard is the public leader of the team. When it comes to keeping morale up and team spirit high, this is your person.</p>
                                    </div>
                                </div>

                                <div class="panel">
                                    <div class="panel-heading">GAMEMASTER</div>
                                    <div class="panel-body">
                                        <p>The Gamemaster will lead the recruits into battle. This position requires one who can be decisive and commit to those decisions made.</p>
                                    </div>
                                </div>

                                <div class="panel">
                                    <div class="panel-heading">CULINARIAN</div>
                                    <div class="panel-body">
                                        <p>Training the body and the mind requires fuel. The Culinarian will make sure that all recruits are well fed and ready to give their best.</p>
                                    </div>
                                </div>

                                <div class="panel">
                                    <div class="panel-heading">TECHNOLOGIST</div>
                                    <div class="panel-body">
                                        <p>During the course of the training, the Technologist will become well acquainted with the team's terminal, and will handle communication and puzzle-solving.</p>
                                    </div>
                                </div>

                                <div class="panel">
                                    <div class="panel-heading">ENGINEER</div>
                                    <div class="panel-body">
                                        <p>The Engineer's skillset is the optimal blend of creativity and problem-solving. This recruit will be instrumental in gaining crucial points for their team.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="user-help-submit">OK</button>
                  </div>
                </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
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
