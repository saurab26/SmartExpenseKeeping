@extends('layouts.authApp')

@section('authcontent')


        <div class="col-sm-8 col-sm-offset-2">

            <div class="col-sm-12"></div>
        <div class="col-sm-12  register-top">
           
               

                
                    <form  class="form-horizontal register-container tb-padding" role="form" method="POST" action="{{ route('register') }}" >
                      {{ csrf_field() }}


                      <div class="form-group">
                            <div class="col-sm-12 ">
                                <h3 class="text-center">Sign Up to <span class="text-color">Smart Expense Keeping</span></h3>
                            </div>
                        </div>


                        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                            <label for="name" class=" col-sm-2 form-control-label ">Name:</label>

                            <div class="col-sm-10 ">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}"  autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                            <label for="email" class=" form-control-label col-sm-2">E-Mail Address</label>

                            <div class="col-sm-10 ">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}"  >

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }} ">
                            <label for="password" class=" form-control-label col-sm-2">Password</label>

                            <div class="col-sm-10 ">
                                <input id="password" type="password" class="form-control" name="password" >

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group  {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                            <label for="password-confirm" class=" form-control-label col-sm-2">Confirm Password</label>

                            <div class="col-sm-10">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation"  >
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }} ">
                            <label for="phone" class=" form-control-label col-sm-2">Phone</label>

                            <div class="col-sm-10 ">
                                <input id="phone" type="text" class="form-control" name="phone" value="{{ old('phone') }}" >

                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                         

                        <div class="form-group">
                            <label for="country" class="form-control-label col-sm-2">Country</label>
                            <div class="col-sm-10">
                                
                                <select class="form-control" name="country" id="country" onchange="get_zones($(this).val())">
                                    
                            
                                <option value=""> Choose Country</option>
                                <?php 
                                $countries = DB::select(DB::raw('select * from countries'));

                                ?>
                                @if(count($countries)>0)
                                @foreach($countries as $country)
                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                                @endforeach
                                @endif

                                </select>

                                @if ($errors->has('country'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('country') }}</strong>
                                    </span>
                                @endif


                            </div>

                        </div>


                        <div class="form-group">
                            <label for="state" class=" col-sm-2 form-control-label">State</label>

                            <div class="col-sm-10 ">
                                <select class="form-control" id="state" name="state">                                   
                                   <!--  <option value="">Choose State</option> -->
                                   
                                </select>

                                 <img src="{{ asset('/img/spinner.gif') }}" id="loader" style="position: absolute;right: -9px; top: 9px; display: none;" />

                               

                                @if ($errors->has('state'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('state') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        

                         <div class="form-group {{ $errors->has('city') ? 'has-error' : '' }}">
                            <label for="city" class=" col-sm-2 form-control-label">City</label>

                            <div class="col-sm-10 ">
                                <input id="city" type="text" class="form-control" name="city" value="{{ old('city') }}"  autofocus>

                                @if ($errors->has('city'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('city') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                         <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
                            <label for="address" class=" col-sm-2 form-control-label">Address</label>

                            <div class="col-sm-10 ">
                                <input id="address" type="text" class="form-control" name="address" value="{{ old('address') }}"  autofocus>

                                @if ($errors->has('address'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                         <div class="form-group {{ $errors->has('post_code') ? 'has-error' : '' }}">
                            <label for="post_code" class=" col-sm-2 form-control-label">Postal Code</label>

                            <div class="col-sm-10 ">
                                <input id="post_code" type="text" class="form-control" name="post_code" value="{{ old('post_code') }}"  autofocus>

                                @if ($errors->has('post_code'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('post_code') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                         <div class="form-group {{ $errors->has('logo') ? 'has-error' : '' }}">
                           <label for="logo" class="col-sm-2 form-control-label">Logo</label>
                        
                           <div class="col-sm-10 ">
                               <input id="logo" type="file" class="form-control" name="logo" value="{{ old('logo') }}" autofocus>
                        
                               @if ($errors->has('logo'))
                                   <span class="help-block">
                                       <strong>{{ $errors->first('logo') }}</strong>
                                   </span>
                               @endif
                           </div>
                                                </div>




                        <div class="form-group  ">
                            <div class="col-sm-10 col-sm-offset-1">
                                <button type="submit" class="btn btn-danger btn-block">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                    <h5 class="text-center"> Already have an account? <a href="{{ route('login') }}"> Sign In</a></h5>

                    <div class="col-sm-10"></div>
        </div>
    

    </div><!-- col-sm-8-->


@endsection

@section('script')

        <script>

            function get_zones(id)
                    {
                        
                       
                        $('#loader').show();

                        $.post("/auth/get_zones",{id:id,_token:"{{ csrf_token() }}"}).done(function(e){

                            $('#state').html(e);
                            $('#loader').hide();


                        });
                    }
            

        </script>
@endsection
