<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    


    Protected $table = 'categories';
   
   Protected $fillable = ['user_id', 'company_id', 'name'];



   public static function whereUser($company_id = NULL)

   {

   		$company_id = ($company_id==NULL ? Auth::user()->company_id : $company_id);

        $AND = "";

            if(Auth::user()->role!=1)
              {

                $AND = "

                AND c.id IN (

                SELECT ud.category_id
                FROM user_details as ud
                WHERE ud.user_id = ".Auth::user()->id."   

                )

                ";
              }



   		return DB::select(DB::raw("

			SELECT c.id, c.company_id,c.name, c.created_at,c.updated_at,b.budgets,b.budgetTotal

      FROM categories as c
       
      LEFT JOIN
      (
          SELECT count(b.id) as budgets, b.company_id,b.category_id,SUM(b.budget) as budgetTotal

          FROM budgets as b

          WHERE b.company_id = $company_id
          GROUP BY b.category_id

      ) b ON b.category_id = c.id




			WHERE c.company_id = $company_id
      $AND

			GROUP BY c.id
			ORDER BY c.name ASC

   			"));

   }






}
