@extends('layouts.admin')

@section('content')
<div class="col-lg-7">
    <div class="row menu-row">
        <div class="col-lg-12">
            <h1>Point functions</h1>
            <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#add-points-modal">Add points</a>
        </div>
    </div>

    <div class="row menu-row">
        <div class="col-lg-12">
            <h1>Scavenger hunt </h1>
            {{--<a href="#" class="btn btn-info" data-toggle="modal" data-target="#challenge-add-modal">Show questions</a>--}}
            <a href="#" class="btn btn-info" data-toggle="modal" data-target="#challenge-add-modal">Add question</a>
        </div>
    </div>
</div>

<div class="col-lg-5">
    <div class="row menu-row">
        <h1>Team Standings <span class="pull-right"><a href="#" class="btn btn-primary" data-toggle="modal" data-target="#team-create-modal">Add team</a></span></h1>
        @if (count($teams) > 0)
        <table class="table" id="team-standings-table">
            <thead>
                <th>Name</th>
                <th>Points</th>
                <th>&nbsp;</th>
            </thead>
            <tbody>
                @foreach ($teams as $team)
                <tr style="border-left: solid 10px {{ $team->color }}">
                    <td>{{ $team->name }} [{{count($team->users)}}]</td>
                    <td>{{ $team->points->sum('amount')}}</td>
                    <td>
                        <a href="#" data-id="{{$team->id}}" class="btn btn-sm team-edit-btn">EDIT TEAM</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
            <em>No teams at the moment.</em>
        @endif
    </div>

    <div class="row menu-row">
        <h1>Player Standings <span class="pull-right"><a href="#" class="btn btn-primary" data-toggle="modal" data-target="#user-create-modal">Add player</a></span></h1>
        @if (count($users) > 0)
        <table class="table" id="user-standings-table">
            <thead>
                <th>Name</th>
                <th>Points</th>
                <th>&nbsp;</th>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr style="border-left: solid 10px {{ $user->team->color }}">
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->points->sum('amount')}}</td>
                    <td>
                        <a href="#" data-id="{{$user->id}}" class="btn btn-sm user-edit-btn">EDIT PLAYER</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
            <em>No players at the moment.</em>
        @endif
    </div>
</div>

{{ csrf_field() }}

@endsection

@section('modals')
<div class="modal fade" id="team-create-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add a team</h4>
      </div>
      <div class="modal-body">
        <form class="form">
            <div class="form-group">
                <label class="control-label" for="name">Name</label>
                <input type="text" name="name" id="team-create-name" class="form-control"/>
            </div>

            <div class="form-group">
                <label class="control-label" for="name">Color</label>
                <input type="text" name="color" id="team-create-color" class="form-control"/>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="team-create-submit">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="team-edit-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit team</h4>
      </div>
      <div class="modal-body">
        <form class="form">
            <div class="form-group">
                <label class="control-label" for="name">Name</label>
                <input type="text" name="name" id="team-edit-name" class="form-control"/>
            </div>

            <div class="form-group">
                <label class="control-label" for="name">Color</label>
                <input type="text" name="color" id="team-edit-color" class="form-control"/>
                <input type="hidden" name="id" id="team-edit-id"/>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="team-edit-submit">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="user-create-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add a player</h4>
      </div>
      <div class="modal-body">
        <form class="form">
            <div class="form-group">
                <label class="control-label" for="name">Name</label>
                <input type="text" name="name" id="user-create-name" class="form-control"/>
            </div>

            <div class="form-group">
                <label class="control-label" for="password">Password</label>
                <input type="text" name="password" id="user-create-password" class="form-control"/>
            </div>

            <div class="form-group">
                <label class="control-label" for="role">Role</label>
                <select name="team" class="form-control" id="user-create-role">
                        <option>Select a role</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="control-label" for="name">Team</label>
                <select name="team" class="form-control" id="user-create-team">
                        <option>Select a team</option>
                    @foreach ($teams as $team)
                        <option value="{{ $team->id }}">{{ $team->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="control-label" for="points">Starting points</label>
                <input type="number" name="points" id="user-create-points" class="form-control"/>
            </div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="user-create-submit">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="user-edit-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit user</h4>
      </div>
      <div class="modal-body">
        <form class="form">
            <div class="form-group">
                <label class="control-label" for="name">Name</label>
                <input type="text" name="name" id="user-edit-name" class="form-control"/>
            </div>

            <div class="form-group">
                <label class="control-label" for="password">Password</label>
                <input type="text" name="password" id="user-edit-password" class="form-control"/>
            </div>

            <div class="form-group">
                <label class="control-label" for="role">Role</label>
                <select name="team" class="form-control" id="user-edit-role">
                        <option>Select a role</option>
                    @foreach ($roles as $role)
                        <option id="user-edit-role-{{$role->id}}" value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="control-label" for="team">Team</label>
                <select name="team" class="form-control" id="user-edit-team">
                        <option>Select a team</option>
                    @foreach ($teams as $team)
                        <option id="user-edit-team-{{$team->id}}" value="{{ $team->id }}">{{ $team->name }}</option>
                    @endforeach
                </select>
            </div>


            <input type="hidden" name="id" id="user-edit-id" />

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="user-edit-submit">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" id="add-points-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add points to player</h4>
      </div>
      <div class="modal-body">
        <form class="form">
            <div class="form-group">
                <label class="control-label" for="user">Player</label>
                <select name="user" id="add-points-user" class="form-control">
                    <option>Select player</option>
                    @foreach ($users as $user):
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="control-label" for="amount">Number of points <small>can be positive or negative</small></label>
                <input type="number" class="form-control" name="amount" id="add-points-amount" />
            </div>

            <div class="form-group">
                <label class="control-label" for="note">Note</label>
                <input type="text" class="form-control" name="note" id="add-points-note" />
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="points-add-submit">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="messages-list-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Inbox module</h4>
      </div>
      <div class="modal-body">
        <div class="row">
            <h1>Received messages</h1>
            @if (count($adminUser->receivedMessages) > 0)
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    @foreach ($adminUser->receivedMessages->sortByDesc('created_at')->take(20) as $key => $message)
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="heading-{{$key}}">
                              <h4 class="panel-title">
                                <a role="button" class="message-read-btn" data-id="{{ $message->id }}" data-toggle="collapse" data-parent="#accordion" href="#collapse-{{$key}}" aria-expanded="true" aria-controls="collapse-{{$key}}">
                                  <h1>Message from {{ $message->sender->name }} - {{$message->created_at}}</h1>
                                </a>
                              </h4>
                            </div>
                            <div id="collapse-{{$key}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-{{$key}}">
                              <div class="panel-body">
                               {{ $message->content }}
                              </div>
                            </div>
                          </div>
                    @endforeach
                </div>
            @else
                <h5 class="text-info">No messages received.</h5>
            @endif
        </div>

        <div class="row">
            <h1>Send a message</h1>
            <form class="form" id="create-message-form">
                <div class="form-group">
                    <label class="control-label" for="recipient">Recipient</label>
                    <select name="recipient" id="create-message-recipient" class="form-control" required>
                        <option>Select someone to receive message</option>
                        @foreach ($users->sortBy('name') as $user)
                            @if ($adminUser->id != $user->id)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="control-label" for="content">Message</label>
                    <textarea class="form-control" id="create-message-content" required></textarea>
                </div>

                <div class="form-group text-center">
                    <a href="#" class="btn btn-info" id="create-message-submit">Send message!</a>
                </div>
            </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="challenge-add-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add challenge</h4>
      </div>
      <div class="modal-body">
        <form class="form">
            <div class="form-group">
                <label class="control-label" for="prompt">Question prompt</label>
                <input type="text" class="form-control" name="prompt" id="challenge-add-prompt" />
            </div>

            <div class="form-group">
                <label class="control-label" for="answer">Answer</label>
                <input type="text" class="form-control" name="answer" id="challenge-add-answer" />
            </div>

            <div class="form-group">
                <label class="control-label" for="value">Points value</label>
                <input type="number" class="form-control" name="value" id="challenge-add-value" />
            </div>

            <div class="form-group">
                <label class="control-label" for="active">Active time <small>leave blank to make active now</small></label>
                <input type="datetime-local" class="form-control" name="active" id="challenge-add-active" />
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="challenge-add-submit">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    var token = $("input[name='_token']").val(),
                apiURL = "/api/v1/";

    // TEAM FUNCTIONS
    $("#team-create-submit").click(function() {
        $.ajax({
            type : 'post',
            url : apiURL + 'teams',
            data : {
                _token: token,
                name : $("#team-create-name").val(),
                color : $("#team-create-color").val()
            },
            success : function(d) {
                $("#team-create-modal input").val('');
                $("#team-create-modal").modal('hide');
                window.location.reload();
            },
            error : function() {
                alertify.error('Team creation failed!');
            }
        })
    });

    $("#team-edit-submit").click(function() {
        $.ajax({
            type : 'post',
            url : apiURL + 'teams/' + $("#team-edit-id").val(),
            data : {
                _token: token,
                name : $("#team-edit-name").val(),
                color : $("#team-edit-color").val()
            },
            success : function(d) {
                $("#team-edit-modal input").val('');
                $("#team-edit-modal").modal('hide');
                window.location.reload();
            },
            error : function() {
                alertify.error('Team update failed!');
            }
        })
    });

    $(".team-edit-btn").click(function() {
        var teamId = $(this).data('id');
        $.ajax({
            type : 'get',
            url : apiURL + 'teams/' + teamId,
            success : function(d) {
                $("#team-edit-name").val(d['data']['name']);
                $("#team-edit-color").val(d['data']['color']);
                $("#team-edit-id").val(d['data']['id']);
                $("#team-edit-modal").modal('show');
            },
            error : function() {
                alertify.error('Team lookup failed!');
            }
        })
    });

    // User functions
    $("#user-create-submit").click(function() {
        $.ajax({
            type : 'post',
            url : apiURL + 'users',
            data : {
                _token: token,
                name : $("#user-create-name").val(),
                password : $("#user-create-password").val(),
                role : $("#user-create-role").val(),
                team : $("#user-create-team").val(),
                points : $("#user-create-points").val()
            },
            success : function(d) {
                $("#user-create-modal input").val('');
                $("#user-create-modal").modal('hide');
                window.location.reload();
            },
            error : function() {
                alertify.error('User creation failed!');
            }
        });
    });

    $(".user-edit-btn").click(function() {
        var userId = $(this).data('id');
        $.ajax({
            type : 'get',
            url : apiURL + 'users/' + userId,
            success : function(d) {
                $("#user-edit-name").val(d['data']['name']);
                $('#user-edit-role-' + d['data']['role_id']).attr('selected', 'selected');
                $('#user-edit-team-' + d['data']['team_id']).attr('selected', 'selected');
                $('#user-edit-id').val(d['data']['id']);
                $("#user-edit-modal").modal('show');
            },
            error : function() {
                alertify.error('User lookup failed!');
            }
        });
    });

    $("#user-edit-submit").click(function() {
        $.ajax({
            type : 'post',
            url : apiURL + 'users/' + $("#user-edit-id").val(),
            data : {
                _token : token,
                name : $("#user-edit-name").val(),
                password : $("#user-edit-password").val(),
                team : $("#user-edit-team").val(),
                role : $("#user-edit-role").val()
            },
            success : function(d) {
                window.location.reload();
            },
            error : function() {
                alertify.error('User update failed!');
            }
        });
    });

    // Point functions
    $("#points-add-submit").click(function() {
        $.ajax({
            type : 'post',
            url : apiURL + 'points',
            data : {
                _token : token,
                user_id : $("#add-points-user").val(),
                amount : $("#add-points-amount").val(),
                note : $("#add-points-note").val()
            },
            success : function(d) {
                window.location.reload();
            },
            error : function() {
                alertify.error('Point addition failed!');
            }
        });
    });

    $("#create-message-submit").click(function(){
        $.ajax({
            type : 'post',
            url : apiURL + 'messages/admin',
            data : {
                _token : token,
                recipient : $("#create-message-recipient").val(),
                content : $("#create-message-content").val()
            },
            success : function(d) {
                $("#messages-list-modal select").val('');
                $("#messages-list-modal textarea").val('');
                $("#messages-list-modal").modal('hide');
                alertify.success('Message sent!');
            }
        });
    });

    // Mark message as read
    $(".message-read-btn").click(function() {
        var messageId = $(this).data('id');
        $.ajax({
            type : 'post',
            url : apiURL + 'messages/read/' + messageId,
            data : {
                _token : token
            }
        });
    });

    $("#user-standings-table").dataTable({
        "bFilter" : false,
        "bPaginate" : false,
        "bInfo" : false,
        "order" : [[1,'desc']]
    });

    $("#team-standings-table").dataTable({
        "bFilter" : false,
        "bPaginate" : false,
        "bInfo" : false,
        "order" : [[1,'desc']]
    });

    // Challenge functions
    $("#challenge-add-submit").click(function() {
        $.ajax({
            type : 'post',
            url : apiURL + 'challenges',
            data : {
                _token : token,
                prompt : $("#challenge-add-prompt").val(),
                answer : $("#challenge-add-answer").val(),
                value : $("#challenge-add-value").val(),
                active_time : $("#challenge-add-active").val()
            },
            success : function() {
                window.location.reload();
            }
        });
    });
});
</script>
@endsection