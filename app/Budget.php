<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class Budget extends Model
{
    


	protected $table = 'budgets';
    protected $fillable = ['user_id','company_id','category_id','period_id','item','unit','quantity','budget'];

    public function whereUser()
    {

    	$company_id = Auth::user()->company_id;

    		$department = "";
    		$period = "";
    		$AND = "";

    		if(Auth::user()->role!=1)

    			{

    				$AND = "
					
					AND c.id IN(

					SELECT ud.category_id
					FROM user_details as ud
					WHERE ud.user_id = ".Auth::user()->id."

					)
    				";

    			}


    		if(Input::get('department')&&Input::get('department')!="all")

    				{
    					$department = "AND b.category_id = ". Input::get('department'). "";
    				}
    		if(Input::get('period')&&Input::get('period')!="all")

    				{
    					$period = "AND b.period_id = ". Input::get('period'). "";
    				}

    	return DB::select(DB::raw("


				SELECT

				b.id, b.item, b.unit, b.company_id, b.category_id, b.period_id, b.quantity, b.budget, b.created_at,u.name as name,c.name as category,

				CASE
					WHEN(b.budget - SUM(e.price)>0)
					THEN b.budget - SUM(e.price)

					ELSE b.budget

					END as outside
				 

				
				FROM budgets as b

				LEFT JOIN users as u ON b.user_id = u.id
				LEFT JOIN categories as c ON b.category_id = c.id
				LEFT JOIN companies as co ON b.company_id = co.id
				LEFT JOIN expenses as e ON e.budget_id = b.id

				WHERE b.company_id = $company_id 

				$department
				$period
				$AND

				GROUP BY b.id
				ORDER BY b.id DESC



    		"));


    }
	public function budgetExpenseTotal()
	{
		$company_id = Auth::user()->company_id;

    	$department = "";
    	$period = "";
		$AND = "";
		
		if(Auth::user()->role!=1)
		{
			$AND = "
			AND category_id IN(
				SELECT ud.category_id
				FROM user_details ud
				WHERE ud.user_id = ".Auth::user()->id."
				)
			";
		}
		if(Input::get('department') && Input::get('department')!="all")
		{
			$department = "AND category_id =".Input::get('department')."";
		}
		if(Input::get('period') && Input::get('period')!="all")
		{
			$period = "AND period_id =".Input::get('period')."";
		}
		return DB::select(DB::raw("
		 SELECT b.budgetTotal,e.expenseTotal,SUM(b.budgetTotal)-SUM(expenseTotal) as remainingBalance
		 FROM(
			 SELECT * ,SUM(budget) as budgetTotal
			 FROM budgets
			 WHERE company_id = $company_id
			 $department
			 $period
			 $AND


		 ) as b,
		(
			SELECT * ,SUM(price) as expenseTotal
			 FROM expenses
			 WHERE company_id = $company_id
			 $department
			 $period
			 $AND
		) as e
		
		"));
	}

}
