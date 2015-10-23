@extends('layouts.team')

@section('content')
<div class="row menu-row">
    <a href="/dashboard" class="btn btn-primary"><i class="glyphicon glyphicon-arrow-left"></i> Dashboard</a>
</div>
<div class="row menu-row">
    <h1>Digital Quest</h1>
    @foreach($challenges as $challenge)
        <div class="form-group">
            <label class="control-label">{{$challenge->prompt}} </label>
            @if ( ! $user->points->where('note', 'challenge-' . $challenge->id)->first())
            <input type="text" class="form-control" name="answer" id="challenge-answer-{{$challenge->id}}" />
            <input type="hidden" value="{{ $challenge->value }}" class="form-control" id="challenge-value" />
            <a href="#" data-id="{{ $challenge->id }}" class="btn btn-info challenge-submit-btn" name="answer">Submit</a>
            <span id="challenge-error-{{ $challenge->id }}" class="text-danger"></span>
            @else
            <span class="text-info">SOLVED!</span>
            @endif
        </div>
    @endforeach
</div>
{{ csrf_field() }}
@endsection


@section('scripts')
<script>
$(document).ready(function(){
    $(".challenge-submit-btn").click(function(){
        var challengeId = $(this).data('id');
        $.ajax({
            type : 'post',
            url : apiURL + 'challenges/guess/' + challengeId,
            data : {
                _token : token,
                guess : $("#challenge-answer-" + challengeId).val()
            },
            success : function(d) {
                if (d['data']['correct'] == 1){
                    $.ajax({
                        type : 'post',
                        url : apiURL + 'points/team/' + {{ $user->team_id }},
                        data : {
                            _token : token,
                            note : 'challenge-' + challengeId,
                            amount : $("#challenge-value").val()
                        },
                        success : function() {
                            window.location.reload();
                        }
                    });
                } else {
                    $("#challenge-error-" + challengeId).html('INCORRECT');
                }
            }
        });
    });
});
</script>
@endsection