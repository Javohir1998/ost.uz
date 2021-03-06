<?php

namespace App\Http\Controllers;
use App\Http\Requests\ProductRequest;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @returnFF \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Products::latest()->paginate(5);
        return view('products.index',compact('products'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(ProductRequest $request)
    {

        $produc = new Products();
        $produc->title   =   $request->title;
        $produc->about   =   $request->about;
        $produc->link    =   $request->link;
        if ($request->hasFile('image')){
            $image = $request->file('image');
            $image_name = ((int) (microtime(true))).$image->getClientOriginalName();
            $image->move(base_path('public\images'), $image_name);
        }
        $produc->image = $image_name;
        $produc->save();
        return redirect()->route('products.index')->with('success','Yangi Ilova qushildi.');
    }









//    /**
//     * Display the specified resource.
//     *
//     * @param  \App\UserData  $userData
//     * @return \Illuminate\Http\Response
//     */
    public function show($id)
    {
        $products = Products::find($id);
        return view('products.show',compact('products'));
    }

//    /**
//     * Show the form for editing the specified resource.
//     *
//     * @param  \App\UserData  $userData
//     * @return \Illuminate\Http\Response
//     */
    public function edit($id)
    {
        $products = Products::find($id);
        return view('products.edit',compact('products','id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserData  $userData
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $products = Products::find($id);
        $products->title = request('title');
        $products->about = request('about');
        $products->link = request('link');
        $products->save();
        return redirect()->route('products.index')->with('success','User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserData  $userData
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Products::find($id)->delete();

        return redirect()->route('products.index')
            ->with('success','User deleted successfully');
    }
}
