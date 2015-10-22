@extends('layouts.admin')

@section('content')
<div class="col-lg-7">
    <div class="row menu-row">
        <div class="col-lg-12">
            <h1>Message functions</h1>
            <a href="#" class="btn btn-default" data-toggle="modal" data-target="#user-list-modal">Show messages</a>
            <a href="#" class="btn btn-default" data-toggle="modal" data-target="#user-create-modal">New message</a>
        </div>
    </div>

    <div class="row menu-row">
        <div class="col-lg-12">
            <h1>Scavenger hunt </h1>
            <a href="#" class="btn btn-info" data-toggle="modal" data-target="#user-list-modal">Show questions</a>
            <a href="#" class="btn btn-info" data-toggle="modal" data-target="#user-create-modal">Add question</a>
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
                        {{--<a href="#" class="team-delete-btn" data-id="{{ $team->id }}"><i class="glyphicon glyphicon-trash"></i></a>--}}
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
                <label class="control-label" for="name">Team</label>
                <select name="team" class="form-control" id="user-create-team">
                        <option>Select a team</option>
                    @foreach ($teams as $team)
                        <option value="{{ $team->id }}">{{ $team->name }}</option>
                    @endforeach
                </select>
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
                <label class="control-label" for="name">Team</label>
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
                team : $("#user-create-team").val()
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
                id : $("#user-edit-id").val()
            },
            success : function(d) {
                window.location.reload();
            },
            error : function() {
                alertify.error('User lookup failed!');
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
});
</script>
@endsection