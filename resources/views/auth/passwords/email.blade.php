@extends('layouts.authApp')

@section('authcontent')

     <div class="col-sm-4"></div>
        <div class="col-sm-6 register-top-login">
            
               

               
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class = "form-horizontal register-container tb-padding" role="form"  method="POST" action="{{ route('password.email') }}">
                      {{ csrf_field() }}

                        <div class="form-group">
                          <div class="col-sm-12">
                            <h3 class="text-center">Forgot Password?</h3>
                          </div>
                        </div>

                        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                            <label for="email" class="col-sm-3 col-form-label ">E-Mail Address</label>

                            <div class="col-sm-9">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group ">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-danger btn-block">
                                   Send Password Reset Link
                                </button>
                            </div>
                        </div>
                    </form>

                    <h5 class="text-center">Don't have an account? <a href="{{ route('register') }}">Sign Up</a></h5>
                      <h5 class="text-center">Go Home <a href="{{ route('login') }}">Sign In</a></h5>

            
          
        </div>
   

@endsection
