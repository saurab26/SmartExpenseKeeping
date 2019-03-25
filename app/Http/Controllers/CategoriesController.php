<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\CreateCategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoriesController extends Controller
{
    

	public function __construct()

	{
		$this->middleware('auth');

		$this->categories = new Category();
	}

    

	public function index()
	{

	}

	public function create()
	{

	}

	public function store(CreateCategoryRequest $request)
	{
		
		// dd($request);
		
		if(Auth::user()->role==3)
			{

				return redirect()->back()->with('error' , 'Access denied you do not have sufficient previleges');
			} 
	 
		
		 
		$category = new Category($request->all());

		$category->save();

		return redirect()->back()->with('message', 'New Category Created.');
	}

	public function edit($id)
	{
		// dd($id);
			

			if( Auth::user()->role==3)
			{

				return redirect()->back()->with('error' , 'Access denied you do not have sufficient previleges');
			}


			$data['category'] = $this->categories->where('id',$id)->first();

			// dd($data['category']);
			
			 return view('categories.edit-category', $data);
	}

	public function update(CreateCategoryRequest $request , $id)
	{
		// dd($id);
			
			if(Auth::user()->role==3)
			{

				return redirect()->back()->with('error' , 'Access denied you do not have sufficient previleges');
			}


			$category =  $this->categories->where('id',$id)->first();

			$category->name = $request->name;

			$category->save();

			return redirect()->route('categories-periods.index')->with('message','Category Updated Successfully');

	}

	public function delete($id)
	{
		
		if(Auth::user()->role ==2 || Auth::user()->role==3)
			{

				return redirect()->back()->with('error' , 'Access denied you do not have sufficient previleges');
			}

		$category =  $this->categories->where('id',$id);
		$category->delete();

		return redirect()->back()->with('error' , 'Record Deleted!');
	}





}
