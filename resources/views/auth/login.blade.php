@extends('...layouts.team')

@section('content')
<div class="row">
    <div class="col-lg-4 col-lg-offset-4">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
        <form class="form-signin" method="POST" action="/auth/login">
            <h2 class="form-signin-heading">Please sign in</h2>
            <label for="name" class="sr-only">Name</label>
            <input type="text" name="name" id="login-name" class="form-control" placeholder="Your name" required autofocus>
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
            {{ csrf_field() }}
            <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
        </form>
    </div>
</div>

@endsection
