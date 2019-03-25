<?php

namespace App\Http\Controllers;

use App\Company;
use App\Http\Requests\CreateCompanyRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
class CompaniesController extends Controller
{
    

    public function __construct()

	{
		$this->middleware('auth');

		$this->companies = new Company;
		$this->users 	 = new User;
		$this->colors    =  \App\Providers\Common::colors();
	}


	public function index()
	{

		$data['title'] = trans('app.companies-title');
		$data['colors'] = $this->colors;
		$data['users'] = $this->users;
		// $data['companies'] = $this->companies->where('user_id', Auth::user()->id)->get();
		$data['companies'] = $this->companies->whereUser();



		return view('companies.index', $data);
	}

	public function create()
	{

		if(Auth::user()->role ==2 || Auth::user()->role==3)
			{

				return redirect()->back()->with('error' , 'Access denied you do not have sufficient previleges');
			}

		$data['title']  = trans('app.companies-create');

		return view('companies.create', $data);

	}

	public function store(CreateCompanyRequest $request)
	{
			
			if(Auth::user()->role ==2 || Auth::user()->role==3)
			{

				return redirect()->back()->with('error' , 'Access denied you do not have sufficient previleges');
			}

		
			$company = new Company($request->all());

			Auth::user()->companies()->save($company);

			return redirect()->back()->with('message', ' New Company Created');

		/*$this->validate($request , [

			'name' => 'required|unique:companies,name,'.Auth::user()->id.'user_id',


		]);	


		$company = new Company;

		$user_id = Auth::user()->id;

		$company->name 			= $request->name;
		$company->user_id 		= $user_id;

		
		
		$company->save();

		return redirect()->back()->with('message', ' New Company Created');
*/

	}

	public function active()
	{
				$user_id = Auth::user()->id;
				$company = Input::get('company');
				$companyid = 	base64_decode(urldecode($company));

				$cname = $this->companies->find($companyid);

					$users = $this->users->find($user_id);

					$users->company_id = $companyid;
					$users->company_name = $cname->name;

					$users->save();

					return redirect()->route('company.index')->with('message', 'New Company '.$cname->name. 'Selected');

				// dd($cid);

	}











}
