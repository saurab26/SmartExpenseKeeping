@extends('layouts.authApp')

@section('authcontent')

    <div class="col-sm-4"></div>
        <div class="col-sm-8 col-sm-offset-2 register-top-login">
            
             

                
                    <form  class="form-horizontal register-container tb-padding" method="POST" action="{{ route('password.request') }}">
                    {{ csrf_field() }}

                        <input type="hidden" name="token" value="{{ $token }}">

                       
                        <div class="form-group">
                          <div class="col-sm-12">
                            <h3 class="text-center">Reset Password?</h3>
                          </div>
                        </div>


                        <div class="form-group">
                            <label for="email" class="col-sm-4 form-control-label">E-Mail Address</label>

                            <div class="col-sm-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ $email ?? old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="col-sm-4 form-control-label">Password</label>

                            <div class="col-sm-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-sm-4 form-control-label">Confirm Password</label>

                            <div class="col-sm-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-danger btn-block">
                                    Reset Password
                                </button>
                            </div>
                        </div>
                    </form>
                
            
        </div>
  

@endsection
