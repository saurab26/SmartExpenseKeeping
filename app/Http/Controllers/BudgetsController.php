<?php

namespace App\Http\Controllers;

use App\Budget;
use App\Category;
use App\Expense;
use App\Http\Requests\CreateBudgetRequest;
use App\Period;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class BudgetsController extends Controller
{
   
	
	public function __construct()

	{
		$this->middleware('auth');

		$this->categories = new Category();
		$this->periods = new Period();
		$this->colors = \App\Providers\Common::colors();
		$this->budgets = new Budget();
		$this->catexpenses = new Expense();
	}



	public function index()
	{
		
		if( Auth::user()->role == 3)
    	
    	{
    		return redirect()->route('home')->with('error','Access denied you do not have sufficient privileges');

    	}


		if(Auth::user()->company_id == NULL)

			{

				return redirect()->route('company.index')->with('error', 'Please select / create your company first');
			}


		if(Input::get('department') == false || Input::get('period') == false)

		{

			return redirect('/budgets?department=all&period=all');
		}

		$data['department']		= 	Input::get('department');
		$data['period']			= 	Input::get('period');
		


		$data['periods']		= $this->periods->whereUser();
		$data['categories']		= $this->categories->whereUser();
		$data['budgets']		= $this->budgets->whereUser();

			

		$data['colors']	= $this->colors;
		$data['catexpenses']	= $this->catexpenses->catexpense();
		$data['budgetExpenseTotal']	= $this->budgets->budgetExpenseTotal();
		$data['budgetExpenseTotal']	= $data['budgetExpenseTotal'][0];


		return view('budgets.index' ,  $data);
	}

	public function create()
	{

		$data['categories'] = $this->categories->whereUser();
		$data['periods']	= $this->periods->whereUser();


			return view('budgets.create', $data);

	}

	public function store(CreateBudgetRequest $request)
	{
			
			if(Auth::user()->role == 3)

				{

						return redirect()->back()->with('error','Access denied you do not have sufficient privileges');
				}

			
			$budgets = new Budget($request->all());

			$budgets->user_id = Auth::user()->id;
			$budgets->company_id = Input::get('company_id');


				$budgets->save();

				return redirect()->route('budget.index')->with('message','Record Inserted');


	}

	public function edit()
	{
		
	}

	public function update()
	{
		
	}

	public function delete()
	{
		
	}



   
}
