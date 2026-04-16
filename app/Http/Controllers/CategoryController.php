<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\ProductCategories;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Session;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'categories'    => Categories::all()
        ];
        return view('Admin.categories',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.category_create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'  => [
                'required',
                'string',
                Rule::unique('categories','name')
            ],
            'image' => 'required|image|max:2048'
        ]);

        $category = new Categories();
        $category->name = $request->name;
        $category->image = 'categories/no-image.png';
        $category->save();
        if(!is_null($request->image)){
            // Get the image file
            $image = $request->file('image');

            // Generate a unique name for the image
            $imageName = 'Category-'.$category->id.'_'.time() . '.' . $image->extension();
            // Store the image
            $image->move(public_path('categories'),$imageName);
            $category->image = 'categories/'.$imageName;
            $category->save();
        }
        $options = [
            'type' => 'success',
            'text' => 'Category Created',
        ];
        Session::flash('notif',$options);
        return \redirect('admin/categories');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = [
            'category'  => Categories::find($id),
            'products'  => ProductCategories::with('product')->where('category_id',$id)->get(),
        ];
        return view('Admin.category_show',$data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = [
            'category'  => Categories::find($id)
        ];
        return view('Admin.category_edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'  => [
                'sometimes',
                'required',
                'string',
                Rule::unique('categories','name')->ignore($id)
            ],
            'image' => 'sometimes|required|image|max:2048'
        ]);

        $category = Categories::find($id);
        
        if(!is_null($request->image)){
            if (file_exists(public_path($category->image)) && !str_contains($category->image, 'no-image.png')) {
                unlink(public_path($category->image));
            }
            // Get the image file
            $image = $request->file('image');

            // Generate a unique name for the image
            $imageName = 'Category-'.$category->id.'_'.time() . '.' . $image->extension();
            // Store the image
            $image->move(public_path('categories'),$imageName);
            $category->image = 'categories/'.$imageName;
        }
        $category->name = $request->name;
        $category->save();
        $options = [
            'type' => 'success',
            'text' => 'Category Updated',
        ];
        Session::flash('notif',$options);
        return \redirect('admin/categories');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return Categories::destroy($id);
    }
}
