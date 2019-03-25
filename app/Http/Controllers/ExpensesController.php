<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Period;
use App\Category;
use App\Budget;
use App\Expense;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateExpenseRequest;
use Illuminate\Support\Facades\Input;


class ExpensesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

        $this->periods = new Period();
        $this->categories = new Category();
        $this->budgets = new Budget();
        $this->expenses = new Expense();
        $this->colors = \App\Providers\Common::Colors();
    }

    public function index()
    {
        // if( Auth::user()->role == 3)
    	
    	// {
    	// 	return redirect()->route('home')->with('error','Access denied you do not have sufficient privileges');

    	// }


        if(Input::get('department' ==false) || Input::get('status') ==false || Input::get('period') ==false )
        {
            return redirect('/expenses?department=all&status=all&period=all');
        }

        if(Auth::user()->company_id == NULL)

			{

				return redirect()->route('company.index')->with('error', 'Please select / create your company first');
            }
            $data['status'] = Input::get('status');
            $data['department'] = Input::get('department');
            $data['period'] = Input::get('period');
            $data['page'] = Input::get('page');
            $data['expenses'] = $this->expenses->getAll();
            $data['expenses'] = $data['expenses']->appends(Input::except('page'));
            $data['periods'] = $this->periods->whereUser();
            $data['categories'] = $this->categories->whereUser();
        return view('expenses.index',$data);
    }
    public function create()
    {
        $data['budgets'] = $this->budgets->whereUser();
        $data['periods'] = $this->periods->whereUser();
        return view('expenses.create',$data);
    }
    public function store(CreateExpenseRequest $request)
    {
        $budget_id = explode(":",$request->budget_id);
        // $request ->budget_id = $budget_id[0];
        $budgetID = $budget_id[0];
        $category_id = $budget_id[2];
        $period_id = $budget_id[3];

        $expense = new Expense($request->all());
        $expense->category_id = $category_id;
        $expense->period_id = $period_id;
        $expense->budget_id =$budgetID;
        $expense->user_id = Auth::user()->id;
        $expense->company_id = Input::get('company_id');
        $expense->outside = Input::get('outside');

        if($request->file('file') && $request->file('file')->isValid())
        {
            $destinationPath = './uploads';

            $filename = time().'.'.$request->file('file')->getClientOriginalExtension();

            $request->file('file')->move($destinationPath, $filename);

            $expense->file = $filename;
        }
            $expense->save();

            return redirect()->route('expense.index')->with('message','New  Record Inserted');
        // dd($budget_id);
    }

    public function edit()
    {

    }

    public function show($id)
    {
        $expenses = $this->expenses->getAll($id);
        
        $data['row'] = $expenses[0];

        return view('expenses.show',$data);
    }

    public function updatestatus(Request $request)
    {
        $id = $_POST['id'];
        $status = $_POST['status'];
        $comments = $_POST['comments'];

        $expense = Expense::find($id);

        $expense->status = $status;
        $expense->comments = $comments;
        $expense->approver_id = Auth::user()->id;
        
        $expense->save();
    }

    public function editstatus(Request $request)
    {
       $status = $request->status;
       foreach($request->expenses as $row)
       {
           $expense = Expense::find($row);

           $expense->status = $status;
           $expense->comments =$_POST['comments'][$row];
           $expense->approver_id = Auth::user()->id;

           $expense->save();
       } 
       return redirect()->back()->with('message','Changes Saved');
    }

    public function search(Request $request)
    {
        $request = $request->all();

        return redirect('/expenses?department=all&status=all&period=all&search='.$request['search']);
    }

    public function update()
    {

    }
    public function delete()
    {

    }
    
}
