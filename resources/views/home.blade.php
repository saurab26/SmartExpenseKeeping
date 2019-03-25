@extends('layouts.main')

@section('content')

    <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
            
                
                <div class="col-sm-10 col-sm-offset-1">
                    
                
                <h2 class="col-sm-10 col-sm-offset-1" style="color: #e97856;"> Smart Expense <span class="text-color">Keeeping</span></h2>



                </div>
                
                <div class="col-sm-10 col-sm-offset-1" style="margin-top: 20px;">


                    <div class="col-sm-3">
                        <div class="jumbotron" style="background-color: #e8b40b;">
                        <h4>Open Expense</h4>
                        <p class="badge">{{$Pending}}</p>
                        </div>
                    </div>
                    
                    <div class="col-sm-3">
                        <div class="jumbotron" style="background-color: #006633;">
                        <h4>Approved Expense</h4>
                        <p class="badge">{{$Approved}}</p>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="jumbotron" style="background-color: #e80b16;">
                        <h4>Rejected Expense</h4>
                        <p class="badge">{{$Denied}}</p>
                        </div>
                    </div>
                    
                    <div class="col-sm-3">
                        <div class="jumbotron" style="background-color: #000000;">
                        <h4>Closed Expense</h4>
                        <p class="badge">{{$Closed}}</p>
                        </div>
                    </div>

                </div>
                   
                
            
        </div>
    </div>

    <hr>
                    <div class="row">
                        <div class="col-sm-10 col-sm-offset-1" style="margin-top: 10px">
                            <div class="col-sm-3">  
                                <div class="jumbotron" style="background-color: #4286f4; color:#ffffff ;">
                                <h4>Departments</h4>
                                <p class="badge">{{count($categories)}}</p>
                                </div>
                            </div>

                            <div class="col-sm-3">  
                                <div class="jumbotron" style="background-color: #4286f4; color:#ffffff ;">
                                <h4>Periods</h4>
                                <p class="badge">{{count($periods)}}</p>
                                </div>
                            </div>

                            <div class="col-sm-3">  
                                <div class="jumbotron" style="background-color: #4286f4; color:#ffffff ;">
                                <h4>Budgets</h4>
                                <p class="badge">{{count($budgets)}}</p>
                                <p><span>Total: {{\App\Providers\Common::format_currency($total->budgetTotal)}}</span></p>
                                </div>
                            </div>

                            <div class="col-sm-3">  
                                <div class="jumbotron" style="background-color: #4286f4; color:#ffffff ;">
                                <h4>Expenses</h4>
                                <p class="badge">{{count($expenses)}}</p>
                                <p><span>Total: {{\App\Providers\Common::format_currency($total->expenseTotal)}}</span></p>
                                </div>
                            </div>

                            <!-- <div class="col-sm-3">  
                                <div class="jumbotron" style="background-color: #4286f4; color:#ffffff ;">
                                <h4>Remaining Balance</h4>
                                <p><span>Total: {{\App\Providers\Common::format_currency($total->remainingBalance)}}</span></p>
                                </div>
                            </div> -->

                        </div>
                    </div>
@endsection
