@extends('layouts.main')

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="col-sm-8">
                <h2>Expense</h2>
            </div>
            <div class="col-sm-4" style="margin-top: 22px;">
                <a href="{{route('expense.index')}}">
                    <button class="btn btn-primary btn-block">All Expenses <i class="fa fa-arrow-circle-left"></i></button>
                </a>
            </div>
        </div>
    </div>
    <hr>

    <div class="row" style="margin-top: 10px;">
        <div class="col-sm-10 col-sm-offset-1">
            <table class="table table-bordered expense-table">
                <tr>
                    <th>ID: </th>
                    <td>{{$row->id}}</td>
                </tr>
                <tr>
                    <th>Item: </th>
                    <td>{{$row->item}}</td>
                </tr>
                <tr>
                    <th>From: </th>
                    <td>{{$row->user}}</td>
                </tr>
                <?php
					$color="purple";
					if($row->status=="Pending"){$color="yellow";}
					if($row->status=="Approved"){$color="green";}
					if($row->status=="Denied"){$color="red";}
					if($row->status=="Closed"){$color="black";}
				?>
                <tr>
                    <th>Status: </th>
                    <td>
                        <span class="expense-overdue bg-{{$color}}" style="float:left;">{{$row->status}}</span>
                        <div style="float:right; margin-top: 3px;">
                            <select name="" id="expense_status_{{$row->id}}" style="float: left;margin-top:5px; margin-right:10px;">
                                <option <?php if($row->status == 'Approved'){echo 'selected="selected"';} ?> value="Approved">Approved</option>
                                <option <?php if($row->status == 'Pending'){echo 'selected="selected"';} ?> value="Pending">Pending</option>
                                <option <?php if($row->status == 'Denied'){echo 'selected="selected"';} ?> value="Denied">Denied</option>
                                <option <?php if($row->status == 'Closed'){echo 'selected="selected"';} ?> value="Closed">Closed</option>
                            </select>
                            <button type="button" onclick="changestatussingle({{ $row->id }})" class="btn btn-success" style="width:auto;padding:3px 8px;" >Update</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>Budget: </th>
                    <td>$ {{$row->budget}}</td>
                </tr>
                <tr>
                    <th>Priority: </th>
                    <td>{{$row->priority}}</td>
                </tr>
                <tr>
                    <th>Requested: </th>
                    <td>$ {{$row->price}}</td>
                </tr>
                <tr>
                    <th>Left: </th>
                    <td>$ {{$row->budget-$row->price}}</td>
                </tr>
                <tr>
                    <th>Department: </th>
                    <td>{{$row->category}}</td>
                </tr>
                <tr>
                    <th>Subject: </th>
                    <td>{{$row->subject}}</td>
                </tr>
                <tr>
                    <th>Description: </th>
                    <td>{!! $row->description !!}</td>
                </tr>
                <tr>
                    <th>Approved: </th>
                    <td>
						@if($row->approver==""&&$row->status=="Pending")
							<p>Not Approved Yet!</p>
						@elseif($row->approver!=""&&$row->logo!="")
							<p align="center"><img src="{{asset('uploads/'.$row->file)}}" alt="file" width="25px"></p>
							<p>{{$row->user}}</p>
							<p>{{$row->email}}</p>
						@elseif($row->approver!=""&&$row->logo=="")
							<p>{{$row->user}}</p>
							<p>{{$row->email}}</p>
						@endif
					</td>
                </tr>
                <tr>
                    <th>Created: </th>
                    <td>{{\App\Providers\Common::format_date($row->created_at)}}</td>
                </tr>
                <tr>
                    <th>Last Activity: </th>
                    <td>{{date('m D Y,H:m:s A',strtotime($row->updated_at))}}</td>
                </tr>
                <tr>
                    <th>File: </th>
                    <td><p align="center"><img src="{{asset('uploads/'.$row->file)}}" alt="file" width="25px"></p></td>
                </tr>

                <tr id="comments_single_tr_id" style="display:none;">
                    <th>Comments:<span style="color:red;">Required</span> </th>
                    <td>
                        <textarea name="" id="comment_single_{{$row->id}}" style="width:100%;">{{$row->comments}}</textarea>
                    </td>
                </tr>

                @if($row->comments!='')
                    <tr>
                        <th>Comments: </th>
                        <td>{{$row->comments}}</td>
                    </tr>
                @else
                    <th>Comments: </th>
                    <td><p>NA</p></td>
                @endif
            </table>    
        </div>
    </div>
@endsection

@section('script')

<script>
    function changestatussingle(expenseid)
    {
        var commentbox = $("#comment_single_"+expenseid).val();
        var newstatus = $("#expense_status_"+expenseid).val();

        if(newstatus == 'Denied')
        {
            if(commentbox == '')
            {
                $("#comments_single_tr_id").slideDown('slow');
            }else{
                commentbox = $("#comment_single_"+expenseid).val();
                $.post("/expenses/updatestatus",{status:newstatus,comments:commentbox,id:expenseid,_token:'{!! csrf_token() !!}'}).done(function(data){
                location.reload();
            });
        }
        }else{
            $.post("/expenses/updatestatus",{status:newstatus,comments:commentbox,id:expenseid,_token:'{!! csrf_token() !!}'}).done(function(data){
                location.reload();
            });
        }
    }


</script>


@endsection