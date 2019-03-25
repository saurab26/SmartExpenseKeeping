<?php

namespace App\Http\Controllers;

use App\Category;
use App\Company;
use App\Http\Requests\CreateUserRequest;
use App\User;
use App\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    
    public function __construct()

	{
		$this->middleware('auth');

		$this->categories = new Category();
		$this->companies = new Company();
		$this->users = new User();
	}


	public function index()
	{

		$data['users']  = $this->users->whereUser();
		return view('users.index',$data);
	}

	public function create()
	{

		$data['roles'] 			= $this->users->roles();
    	$data['companies'] 		= $this->companies->whereUser();
    	$data['categories']		= $this->categories->whereUser();
		return view('users.create', $data);
	}

	public function store(CreateUserRequest $request)
	{
			// dd($request);
			
			$parent_id = Auth::user()->id; 

			$data['parent_id']  = $parent_id;
			$data['company_id']	= $request->company_id;
			$data['country']	= $request->country;
			$data['state']		= $request->state;
			$data['name']		= $request->name;
			$data['email']		= $request->email;
			$data['password']	= bcrypt($request->password);
			$data['phone']		= $request->phone;
			$data['city']		= $request->city;
			$data['address']	= $request->address;
			$data['post_code']	= $request->post_code;
			$data['role']		= $request->role;
			$data['status']	= $request->status;
			$data['logo']	= 'logo.png';


				$users = new User($data);

					$users->save();


					if(count($request->access)>0)
					{

							$user_id = $users->id;

							foreach ($request->access as $companyId => $category) 
							{
								if(count($category)>0)
								{
									foreach($category as $cat)

									{

										$ud['user_id'] 		= $user_id;
										$ud['company_id'] 	= $companyId;
										$ud['category_id'] 	= $cat;
											
											$user_detail = new UserDetail($ud);

											$user_detail->save();
									}
								}

							}
				}
					
					return redirect()->route('user.index')->with('message', 'New Record Inserted');
	}

			

	public function edit($id)
	{
		// dd($id);
	
		$data['roles']   		= $this->users->roles();
		$data['companies'] 		= $this->companies->whereUser();
		$data['categories'] 	= $this->categories->whereUser();
		$data['users'] 			= $this->users;
		$data['user']			= $this->users->whereUser($id);	
		$data['user']			= $data['user'][0];

		$data['id']				= $id;

			// dd($data['user']);
		
		return view('users.edit',$data);



	}

	public function update(Request $request , $id)
	{
			$users = User::find($id);

			// dd($users);
		 
				
				if($request->input('email') == $users->email)
				{
					$this->validate($request, [

						'name'  => 'required',
						'role'	=> 'required',

					]);
				}else
				{

					$this->validate($request, [

							'name' 	=> 'required',
							'email'	=> 'required|unique:users',
							'role'	=> 'required',

					]);
				}

			$users->name		= $request->name;
			$users->email		= $request->email;
			$users->phone		= $request->phone;
			$users->city		= $request->city;
			$users->address		= $request->address;
			$users->post_code	= $request->post_code;
			$users->role		= $request->role;
			$users->status	= $request->status;


			

					$users->save();

					// exit();

					UserDetail::where('user_id', $id)->delete();


					if(count($request->access)>0)
					{

							$user_id = $users->id;

							foreach ($request->access as $companyId => $category) 
							{
								if(count($category)>0)
								{
									foreach($category as $cat)

									{

										$ud['user_id'] 		= $user_id;
										$ud['company_id'] 	= $companyId;
										$ud['category_id'] 	= $cat;
											
											$user_detail = new UserDetail($ud);

											$user_detail->save();
									}
								}

							}
				}
					
					return redirect()->route('user.index')->with('message', 'Record Updated');
	}

	public function delete($id)
	{
		$user = User::find($id);
		$user->delete();

		return redirect()->back()->with('error' , 'Record Deleted');
	}
			




    
}
