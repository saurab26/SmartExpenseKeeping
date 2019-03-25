<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class Expense extends Model
{
   

    	 protected $table = 'expenses';
    	 protected $fillable = ['copmany_id','user_id','budget_id','approver_id','priority','price','outside','subject','description','file','status','comments'];


		 public function getAll($id=NULL)
		 {
			 $company_id = Auth::user()->company_id;
			 $department = Input::get('department');
			 $status = Input::get('status');
			 $period = Input::get('period');
			 $search = Input::get('search');

			 $table = DB::table('expenses as e');

			 $table = $table->select(
				'e.id', 'e.price', 'e.outside as budget', 'e.priority','e.status', 'e.subject', 'e.description', 'e.comments', 'e.approver_id as approver', 'e.company_id', 'e.created_at', 'e.updated_at','e.file', 'u.name as user', 'u.logo as logo', 'u.email','b.item','c.name as category', 'p.id as period', 'app.name as approver_name', 'app.logo as approver_logo'  
			 );

			 $table = $table->LeftJoin('companies as cmp', 'cmp.id', '=', 'e.company_id');
			 $table = $table->LeftJoin('budgets as b', 'b.id', '=', 'e.budget_id');
			 $table = $table->LeftJoin('categories as c', 'c.id', '=', 'e.category_id');
			 $table = $table->LeftJoin('users as u', 'u.id', '=', 'e.user_id');
			 $table = $table->LeftJoin('users as app', 'app.id', '=', 'e.approver_id');
			 $table = $table->LeftJoin('periods as p', 'p.id', '=', 'e.period_id');

			 if($id == NULL){

				$table = $table->where('e.company_id','=',$company_id);

			 if(Auth::user()->role!=1)
			 {
				 $table = $table->whereIn('e.category_id',$this->user_details());
			 }

			 if($department && $department!="all")
			 {
				 $table = $table->where('b.category_id',$department);
			 }
			 if($period && $period!="all")
			 {
				 $table = $table->where('b.period_id',$period);
			 }
			 if($status && $status!="all")
			 {
				 $table = $table->where('e.status',$status);
			 }

			 if($search)
			 {
				 $table = $table->where('e.id','like',$search);
				 $table = $table->orwhere('u.name','like','%'.$search.'%');
				 $table = $table->orwhere('b.item','like','%'.$search.'%');
				 $table = $table->orwhere('e.price','like','%'.$search.'%');
				 $table = $table->orwhere('c.name','like','%'.$search.'%');
				 $table = $table->orwhere('e.status','like','%'.$search.'%');
				 $table = $table->orwhere('e.outside','like','%'.$search.'%');
				 $table = $table->orwhere('e.created_at','like','%'.$search.'%');
			 }

			 $table = $table->orderBy('created_at','DESC');
			//  $table = $table->get();
			$table = $table->paginate(2);

			 return $table;

			 }else{
				 $table = $table->where('e.id',$id);
				 return $table->get();
			 }


			//  $table = $table->where('e.company_id','=',$company_id);

			//  if(Auth::user()->role!=1)
			//  {
			// 	 $table = $table->whereIn('e.category_id',$this->user_details());
			//  }

			//  if($department && $department!="all")
			//  {
			// 	 $table = $table->where('b.category_id',$department);
			//  }
			//  if($period && $period!="all")
			//  {
			// 	 $table = $table->where('b.period_id',$period);
			//  }
			//  if($status && $status!="all")
			//  {
			// 	 $table = $table->where('e.status',$status);
			//  }

			//  $table = $table->orderBy('created_at','DESC');
			//  $table = $table->get();

			//  return $table;

		 }

		 public function user_details()
		 {
			 $company_id = Auth::user()->company_id;
			 $user_id = Auth::user()->id;

			 $table = DB::table('user_details');

			 $table = $table->select('category_id');
			 $table = $table->where('company_id',$ompany_id);
			 $table = $table->where('user_id',$user_id);

				 $result = $table->get();
				 
				 $array = [];

				 if(count($result)>0):
					foreach($result as $row):
						$array[] = $row->category_id;

					endforeach;
				endif;
				return $array;
		 }

		 public function catexpense()
		 {
			 $company_id = Auth::user()->company_id;
			 $user_id = Auth::user()->id;

			 return DB::select(DB::raw("
			 SELECT b.id,e.company_id,SUM(e.price) as expenseTotal, b.category_id as category_id
			 FROM budgets as b
			 LEFT JOIN expenses as e ON e.budget_id = b.id

			 WHERE e.company_id = $company_id
			 AND b.user_id = $user_id

			 GROUP BY e.budget_id
			 
			 "));
		 }

		 public function dashboard_data($userid,$companyid,$status)
		 {
			 $table = DB::table('expenses');
			 $table->select('*');
			 $table->where('user_id',$userid);
			 $table->where('company_id',$companyid);
			 $table->where('status',$status);

			 $result = $table->count();
			 return $result;
		 }


}
