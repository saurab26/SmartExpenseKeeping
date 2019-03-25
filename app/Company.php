<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Company extends Model
{
   

   Protected $table = 'companies';
   
   Protected $fillable = ['user_id', 'name'];


     public function user()

	    {

	    	return $this->belongsTo('App\User');

	    }


	    public function whereUser()

	    {


	    	$user = Auth::user()->id;

	    		if(Auth::user()->parent_id!=0)

	    			{
	    				$user = Auth::user()->parent_id;
	    			}

	    			$AND = "";

	    			if(Auth::user()->role!=1)
	    				{

	    					$AND = "

								AND c.id IN (

								SELECT ud.company_id
								FROM user_details as ud
								WHERE ud.user_id = ".Auth::user()->id."		

								)

	    					";
	    				}


	    			return DB::select(DB::raw("


					SELECT *
					FROM companies as c

					WHERE user_id = $user
					$AND

	    				"));


	    }




}
