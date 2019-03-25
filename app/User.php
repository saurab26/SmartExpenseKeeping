<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','phone','country','state','city','address','post_code','logo','status','company_id','company_name','role','access','parent_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];



      public function companies()

            {
                return $this->hasMany('App\Company');
            }


    public function roles()
    {

        return DB::table('roles')->get();

    }


    public function whereUser($id=NULL)
    {

            $parent_id = Auth::user()->parent_id;

            if(Auth::user()->parent_id==0)
                {

                    $parent_id = Auth::user()->id;
                }


            $table = DB::table('users as u');
            $table->where('u.parent_id', $parent_id);

            if($id!=NULL)
            {
                $table->where('id', $id);
            }
            if($id==NULL)
            {

                $table->select('u.id','u.name', 'u.email','u.phone','u.status','r.name as role');
                $table->leftJoin('roles as r', 'u.role' , '=' , 'r.id');

            }

            return $table->get();
    }

    public function exists($id=NULL,$company_id=NULL,$category_id=Null)


    {
        $parent_id = Auth::user()->parent_id;

        if(Auth::user()->parent_id == 0)

            {
                $parent_id = Auth::user()->id;
            }

              $table = DB::table('user_details');
                $table->where('user_id',$id);
                $table->where('company_id',$company_id);
                    if($category_id!=NULL)
                    {
                        $table->where('category_id',$category_id);
                    }

                    $result = $table->get();
                        if(count($result)>0)
                        {
                            return TRUE;
                        }

                            return FALSE;
            
    }



}
