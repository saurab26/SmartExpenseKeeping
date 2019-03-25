@extends('layouts.authApp')

@section('authcontent')

    
        <div class="col-sm-4"></div>

            <div class="col-sm-4 register-top-login">
                

              
                    <form  class="form-horizontal register-container tb-padding" role= "form" method="POST" action="{{ route('login') }}">
                       {{ csrf_field() }}

                        <div class="form-group">
                            <div class="col-sm-12">
                                <h3 class="text-center">Login to <span class="text-color">Smart Expense Keeping</span></h3>
                            </div>
                        </div>



                        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                           

                            <div class="col-sm-12">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }} ">
                           

                            <div class="col-sm-12">
                                <input id="password" type="password" class="form-control" name="password" placeholder="Password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group ">
                            <div class="col-xs-2">                               
                                   
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                           
                            </div>
                            <div class="col-xs-10 no-padding margin-style">Remember me</div>
                        </div>

                        <div class="form-group ">
                            <div class="col-sm-12 ">
                                <input type="submit" value="LOG IN" class="btn btn-danger btn-block" >
                                
                            </div>
                        </div>

                        <div class="form-group ">
                            <div class="col-sm-12 ">
                                <i class="fa fa-lock"></i> <a href="{{ route('password.request') }}" class="forgot-link">Forgot your Password?</a>
                                
                            </div>
                        </div>

                    </form>
            
                    <h5 class="text-center">Don't have an account? <a href="{{ route('register') }}">Sign Up</a></h5>
                    <h5 class="text-center">Developed By Saurab Karmacharya <a href="http://www.onlinesau.com">onlinesau</a></h5>

               
            </div>
     
    

@endsection
