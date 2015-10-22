@extends('layouts.team')

@section('content')
{{ csrf_field() }}
<div class="row menu-row">
    <div class="col-lg-7">
        <div class="row menu-row" style="padding-right:25px;">
            <h1>Welcome <em>{{ $user->name }}</em></h1>
            <p>This is the player dashboard. It will be your gateway to your digital testing and communication. You can start by clicking HELP on the main navigation module.</p>
        </div>

        <div class="row menu-row">
            <h1>Digital quest</h1>
            <p>Current number of active challenges: {{ count($challenges) }}</p>
            <a href="#" class="btn btn-default" @if (count($challenges) == 0) disabled="disabled" @endif>Begin Quest</a>
        </div>
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
                                    <a href="#" class="send-points-btn">
                                        <i class="glyphicon glyphicon-plus"></i>
                                    </a>
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
            @if (count($user->receivedMessages) > 0)
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    @foreach ($user->receivedMessages->sortByDesc('created_at')->take(10) as $key => $message)
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
                        @foreach ($players->sortBy('name') as $player)
                            @if ($user->id != $player->id)
                                <option value="{{ $player->id }}">{{ $player->name }}</option>
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
                <h1>How many do you want to send?</h1>
            @else
                <h1>Sorry, you have {{ $user->points->sum('amount') }} points, so you cannot send any.</h1>
            @endif
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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

    $("#create-message-submit").click(function(){
        $.ajax({
            type : 'post',
            url : apiURL + 'messages',
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

    // Points functions
    $(".send-points-btn").click(function(){
        $("#send-points-modal").modal('show');
    });
});
</script>
@endsection
