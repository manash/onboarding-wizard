@if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form name="register-form" method="post" role="form" action="{{ url('/auth/register') }}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <div class="form-group">
        <input type="text" name="name" tabindex="1" class="form-control"
               placeholder="Name" value="{{ old('name') }}">
    </div>

    <div class="form-group">
        <input type="email" name="email" tabindex="2" class="form-control"
               placeholder="Email Address" value="{{ old('email') }}"
               ng-minlength=3 ng-maxlength=30 required>
    </div>

    <div class="form-group">
        <input type="text" name="phone" tabindex="3" class="form-control"
               placeholder="Phone Number" value="{{ old('phone') }}"
               maxlength=10 ng-pattern="/^[789]\d{9}$/" required>
    </div>

    <div class="form-group">
        <input type="password" name="password" tabindex="4" class="form-control"
               placeholder="Password" required>
    </div>

    <div class="form-group">
        <input type="password" name="password_confirmation" tabindex="5" class="form-control"
               placeholder="Confirm Password" required>
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                <input type="submit" name="submit" tabindex="6" class="form-control btn btn-primary" value="Register Now">
            </div>
        </div>
    </div>
</form>