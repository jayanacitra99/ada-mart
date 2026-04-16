<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Product;
use App\Models\ProductCategories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\Rule;
use Session;
use Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'products'  => Product::with([])->get(),
        ];

        return view('Admin.products', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'categories'    => Categories::all()
        ];
        return view('Admin.product_create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'images.*' => 'required|image|max:2048', // Max 2MB
            'name'  => [
                'sometimes',
                'required',
                'string',
                Rule::unique('products', 'name'),
            ],
            'desc'  => 'required|string',
        ]);
        if($request->categories){
            $request->validate([
                'categories.*' => 'exists:categories,id',
            ]);
        }
        $product = new Product();
        $product->name = $request->name;
        $product->image = \json_encode('products/no-image.png');
        $product->description = $request->desc;
        $product->save();
        // Create a new folder for the product
        $folderName = 'PRODUCTS_' . $product->id;
        $folderPath = public_path('products/' . $folderName);
        File::makeDirectory($folderPath);

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = 'Product-' . $product->id .'-'.Str::random(5). '_' . time() . '.' . $image->extension();
                $image->move($folderPath, $imageName);
                $imagePaths[] = 'products/'.$folderName . '/' . $imageName;
            }
        }
        $product->image = \json_encode(\array_values($imagePaths));
        $product->save();

        if ($request->categories){
            $categories = $request->categories;
            foreach($categories as $category){
                $check = ProductCategories::where('product_id',$product->id)->where('category_id',$category)->first();
                if(is_null($check)){
                    ProductCategories::create([
                        'product_id'    => $product->id,
                        'category_id'   => $category,
                    ]);
                }
            }
        }

        $options = [
            'type' => 'success',
            'text' => 'Product Created',
        ];
        Session::flash('notif',$options);
        return \redirect('admin/products');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {   
        $product = Product::find($id);
        $data = [
            'product'   => $product,
            'details'   => $product->productDetails,
        ];
        return view('Admin.product_show',$data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = [
            'product'   => Product::find($id),
        ];
        return view('Admin.product_edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'images.*' => 'sometimes|required|image|max:2048', // Max 2MB
            'name'  => [
                'sometimes',
                'required',
                'string',
                Rule::unique('products', 'name')->ignore($id),
            ],
            'desc'  => 'sometimes|required|string',
        ]);
        $product = Product::find($id);
        // Handle image updates and deletions
        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $file) {
                $imageName = 'Product-' . $id. '-' . Str::random(5) . '_' . time() . '.' . $file->extension();
                $file->move(public_path('products/PRODUCTS_' . $id), $imageName); // Save image in a folder named after the product ID
                $images[] = 'products/PRODUCTS_' . $id . '/' . $imageName; // Store image path including folder
            }
            // Merge new images with existing images
            $productImages = json_decode($product->image, true) ?? [];
            $product->image = json_encode(array_values(array_merge($productImages, $images)));
        }

        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $image) {
                // Delete the image file
                if (file_exists(public_path($image)) && !str_contains($image, 'no-image.png')) {
                    unlink(public_path($image));
                }
                // Remove the image from the array
                $productImages = is_array($product->image) ? $product->image : json_decode($product->image, true);
                if ($productImages) {
                    $product->image = json_encode(array_values(array_diff($productImages, [$image])));
                }
            }
        }
        $product->name = $request->name;
        $product->description = $request->desc;
        $product->save();

        $options = [
            'type' => 'success',
            'text' => 'Product Updated',
        ];
        Session::flash('notif',$options);
        return \redirect('admin/products'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return Product::destroy($id);
    }
}
