<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePeriodRequest;
use App\Period;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeriodsController extends Controller
{
    

	public function __construct()

	{
		$this->middleware('auth');

		$this->periods = new Period();
	}


    public function index()
	{

	}

	public function create()
	{

	}

	public function store(CreatePeriodRequest $request)
	{
		  
		if(Auth::user()->role ==2 || Auth::user()->role==3)
			{

				return redirect()->back()->with('error' , 'Access denied you do not have sufficient previleges');
			}

		  $period = new Period($request->all());

		  $period->save();

		  return redirect()->back()->with('message' , ' New Period Created');
	}

	public function edit($id)
	{
			// dd($id);
			 
			 if(Auth::user()->role ==2 || Auth::user()->role==3)
			{

				return redirect()->back()->with('error' , 'Access denied you do not have sufficient previleges');
			}




			$data['period']    =   $this->periods->where('id' , $id)->first();

				// dd($data['period']);
			

			 return view('periods.edit-period', $data);
			
	}

	public function update(CreatePeriodRequest $request, $id)
	{
			// dd($request);
			
			if(Auth::user()->role ==2 || Auth::user()->role==3)
			{

				return redirect()->back()->with('error' , 'Access denied you do not have sufficient previleges');
			}



			$period  = $this->periods->where('id', $id)->first();


				$period->from = $request->from;
				$period->to = $request->to;

				$period->save();

			return redirect()->route('categories-periods.index')->with('message','Period Updated Successfully');

	}

	public function delete($id)
	{
		// dd($id);
		 
		
		if(Auth::user()->role ==2 || Auth::user()->role==3)
			{

				return redirect()->back()->with('error' , 'Access denied you do not have sufficient previleges');
			}

		$period  = $this->periods->where('id', $id);

		$period->delete();

		return redirect()->back()->with('error','Record Deleted!');
	}


}