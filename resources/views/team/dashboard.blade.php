@extends('layouts.team')

@section('content')
{{ csrf_field() }}
<div class="row menu-row">
    <div class="col-lg-7">
        <div class="row menu-row" style="padding-right:25px;">
            <h1>Welcome <em class="text-info">{{ $user->name }}</em></h1>
            <p>This is the player dashboard. It will be your gateway to your digital testing and communication. You can start by clicking HELP on the main navigation module.</p>
        </div>

        <div class="row menu-row">
            <h1>Your role: [<span class="text-info">{{ $user->role->name }}</span>]</h1>
            <p>{{ $user->role->description }}</p>
            <h3>Your tasks:</h3>
            <ul>
            @foreach (explode('|', $user->role->tasks) as $task)
                <li>{{ $task }}</li>
            @endforeach
            </ul>
        </div>

        <div class="row menu-row">
            <h1>Your role token:</h1>
            <p>A recruit can redeem their role token <strong>once</strong> for a reward and points.</p>
            @if ( $user->points->where('note', 'role token')->first() )
                <p>You've already redeemed your role token for
                <span class="text-info">{{ $user->points->where('note', 'role token')->first()->amount }}</span> points.</p>
            @else
                <p>Redeem your role token for [<span class="text-info">{{ $user->role->reward }}</span>] and <span class="text-info">{{ tokenRedeemValue() }}</span> points;</p>
                <input type="hidden" id="redeem-token-amount" value="{{ tokenRedeemValue() }}"/>
                <a href="#" class="btn btn-lg btn-success" id="redeem-token-btn">Redeem my token</a>
            @endif
        </div>

        @if ($user->role->name == 'Technologist')
        <div class="row menu-row">
            <h1>Digital quest</h1>
            <p>Current number of active challenges: {{ count($challenges) }}</p>
            <a href="quest" class="btn btn-default" @if (count($challenges) == 0) disabled="disabled" @endif>View Quest</a>
        </div>
        @endif
    </div>

    <div class="col-lg-5">
        <div class="row menu-row">
                <h1>Team Standings</h1>
                @if (count($teams) > 0)
                <table class="table" id="team-standings-table">
                    <thead>
                        <th>Name</th>
                        <th>Points</th>
                    </thead>
                    <tbody>
                        @foreach ($teams as $team)
                        <tr style="border-left: solid 10px {{ $team->color }}">
                            <td>{{ $team->name }}</td>
                            <td>{{ $team->points->sum('amount')}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                    <em>No teams at the moment.</em>
                @endif
            </div>

            <div class="row menu-row">
                <h1>Player Standings</h1>
                @if (count($players) > 0)
                <table class="table" id="user-standings-table">
                    <thead>
                        <th>Name</th>
                        <th>Points</th>
                        <th>&nbsp;</th>
                    </thead>
                    <tbody>
                        @foreach ($players as $player)
                        @if ($player->id != 1)
                            <tr style="border-left: solid 10px {{ $player->team->color }}">
                                <td>{{ $player->name }}</td>
                                <td>{{ $player->points->sum('amount')}}</td>
                                <td>
                                    @if ($player->id != $user->id)
                                    <a href="#" class="send-points-btn" data-id="{{$player->id}}">
                                        <i class="glyphicon glyphicon-plus"></i>
                                    </a>
                                    @endif
                                </td>
                            </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
                @else
                    <em>No players at the moment.</em>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@section('modals')
<div class="modal fade" id="send-points-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Send points</h4>
      </div>
      <div class="modal-body">
        <div class="row">
            @if ( $user->points->sum('amount') > 0)
                <h1>You have {{ $user->points->sum('amount') }} points.</h1>
                <h1>How many do you want to send to <span class="text-info" id="send-points-recipient-name"></span>?</h1>
                <input class="form-control" id="send-points-amount" type="number" value="0" max="{{ $user->points->sum('amount') }}"/>
                <input class="form-control" id="send-points-recipient-id" type="hidden" />
            @else
                <h1>Sorry, you have {{ $user->points->sum('amount') }} points, so you cannot send any.</h1>
            @endif
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        @if ( $user->points->sum('amount') > 0)
            <button type="button" class="btn btn-primary" id="send-points-submit">Send</button>
        @endif
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Points functions
    $(".send-points-btn").click(function(){
        var playerId = $(this).data('id');
        $.ajax({
            type : 'get',
            url : apiURL + 'users/' + playerId,
            success : function(d) {
                $("#send-points-recipient-name").html(d['data']['name']);
                $("#send-points-recipient-id").val(d['data']['id']);
                $("#send-points-modal").modal('show');
            }
        });
    });

    $("#send-points-submit").click(function(){
        $.ajax({
            type : 'post',
            url : apiURL + 'points/send/' + $("#send-points-recipient-id").val(),
            data : {
               _token : token,
               amount : $("#send-points-amount").val()
            },
            success : function(d) {
                window.location.reload();
            }
        });
    });

    $("#redeem-token-btn").click(function(){
        $.ajax({
            type : 'post',
            url : apiURL + 'points',
            data : {
                _token : token,
                amount : $("#redeem-token-amount").val(),
                note : 'role token',
                user_id : {{ $user->id }}
            },
            success : function() {
                window.location.reload();
            }
        });
    })
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
</script>
@endsection
