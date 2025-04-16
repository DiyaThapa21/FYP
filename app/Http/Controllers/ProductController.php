<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with('addedBy')->paginate();
        // return $products;
        return view('backend.product.index')->with('products', $products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brand = Brand::get();
        $category = Category::where('is_parent', 1)->get();
        // return $category;
        return view('backend.product.create')->with('categories', $category)->with('brands', $brand);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'string|required',
            'summary' => 'string|required',
            'description' => 'string|nullable',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'size' => 'nullable',
            'stock' => "required|numeric",
            'cat_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'child_cat_id' => 'nullable|exists:categories,id',
            'is_featured' => 'sometimes|in:1',
            'status' => 'required|in:active,inactive',
            'condition' => 'in:default,new,hot',
            'price' => 'required|numeric',
            'discount' => 'nullable|numeric'
        ]);

        $data = $request->all();
        $slug = Str::slug($request->title);
        $count = Product::where('slug', $slug)->count();
        if ($count > 0) {
            $slug = $slug . '-' . date('ymdis') . '-' . rand(0, 999);
        }
        $data['slug'] = $slug;
        $data['is_featured'] = $request->input('is_featured', 0);


        $user = auth()->user();
        if ($user && $user->role_id == 5) {
            $data['status'] = 'inactive';
            $data['added_by'] = $user->id;
        }

        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $photo = $request->file('photo');

            $uploadDirectory = public_path('uploads/products');
            if (!file_exists($uploadDirectory)) {
                mkdir($uploadDirectory, 0777, true);
            }

            $photoPath = $photo->move($uploadDirectory, $photo->getClientOriginalName());
            $data['photo'] = 'uploads/products/' . $photo->getClientOriginalName();
        }

        $status = Product::create($data);

        if ($status) {
            request()->session()->flash('success', 'Product Successfully added');
        } else {
            request()->session()->flash('error', 'Please try again!!');
        }

        return redirect()->route('product.index');
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $brand = Brand::get();
        $product = Product::findOrFail($id);
        $category = Category::where('is_parent', 1)->get();
        $items = Product::where('id', $id)->get();
        // return $items;
        return view('backend.product.edit')->with('product', $product)
            ->with('brands', $brand)
            ->with('categories', $category)->with('items', $items);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $this->validate($request, [
            'title' => 'string|required',
            'summary' => 'string|required',
            'description' => 'string|nullable',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'size' => 'nullable',
            'stock' => "required|numeric",
            'cat_id' => 'required|exists:categories,id',
            'child_cat_id' => 'nullable|exists:categories,id',
            'is_featured' => 'sometimes|in:1',
            'brand_id' => 'nullable|exists:brands,id',
            'status' => 'required|in:active,inactive',
            'condition' => 'in:default,new,hot',
            'price' => 'required|numeric',
            'discount' => 'nullable|numeric'
        ]);

        $data = $request->all();
        $data['is_featured'] = $request->input('is_featured', 0);

        // Check authenticated user's role
        $user = auth()->user();
        if ($user && $user->role_id == 5) {
            $data['status'] = 'inactive'; // Force status to inactive
            $data['added_by'] = $user->id; // Set added_by
        }

        // Handle the photo upload if a new photo is provided
        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $photo = $request->file('photo');

            $uploadDirectory = public_path('uploads/products');
            if (!file_exists($uploadDirectory)) {
                mkdir($uploadDirectory, 0777, true);
            }

            // Delete old image if it exists
            if ($product->photo && file_exists(public_path($product->photo))) {
                unlink(public_path($product->photo));
            }

            $photoPath = $photo->move($uploadDirectory, $photo->getClientOriginalName());
            $data['photo'] = 'uploads/products/' . $photo->getClientOriginalName();
        }

        $status = $product->fill($data)->save();

        if ($status) {
            request()->session()->flash('success', 'Product Successfully updated');
        } else {
            request()->session()->flash('error', 'Please try again!!');
        }

        return redirect()->route('product.index');
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $status = $product->delete();

        if ($status) {
            request()->session()->flash('success', 'Product successfully deleted');
        } else {
            request()->session()->flash('error', 'Error while deleting product');
        }
        return redirect()->route('product.index');
    }

    public function updateStatus(Request $request)
    {

        $product = Product::find($request->id);

        if ($product) {
            $product->status = $request->status;
            $product->save();

            request()->session()->flash('success', 'Product updated  successfully');
        }
        return redirect()->route('product.index');
    }
}
