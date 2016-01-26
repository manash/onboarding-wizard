<form id="login-form" action="{{ url('/auth/login') }}" method="post" role="form">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <div class="form-group">
        <label for="inputUseremail">Email</label>
        <input type="text" name="email" tabindex="1" class="form-control" placeholder="Email" value="{{ old('email') }}" id="inputUseremail">
    </div>
    <div class="form-group">
        <label for="inputPassword">Password</label>
        <input type="password" name="password" tabindex="2" class="form-control" placeholder="Password" id="inputPassword">
    </div>

    <input type="submit" name="submit" tabindex="4" class=" btn btn-primary" value="Log In" />
    </div>
</form>