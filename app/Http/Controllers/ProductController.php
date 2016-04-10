<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Product;
use App\Repositories\ProductRepository;

class ProductController extends Controller
{
    /**
     * The product repository instance.
     *
     * @var ProductRepository
     */
    protected $products;

    /**
     * Create a new controller instance.
     *
     * @param  ProductRepository  $products
     * @return void
     */
    public function __construct(ProductRepository $products)
    {
        $this->middleware('auth');
        $this->products = $products;
    }

    /**
     * Display a list of available product.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user_roles = [];
        foreach (\Auth::user()->roles()->get() as $role) {
            $user_roles[] = $role->name;
        }

        if (in_array('admin', $user_roles)) {
            return redirect('/tasks');
        }

        if (in_array('merchant', $user_roles)) {
            return redirect('/dashboard');
        }

        $enrolled = [];
        $products = $request->user()->products()
                ->where('status', '=', 1)
                ->get();
        if (!empty($products)) {
            foreach ($products as $product) {
                $enrolled[] = $product->id;
            }
        }

        return view('products.index', [
            'products' => $this->products->available(),
            'enrolled' => $enrolled,
        ]);
    }

    /**
     * Display a list of all of the user's product.
     *
     * @param  Request  $request
     * @return Response
     */
    public function dashboard(Request $request)
    {
        return view('products.dashboard', [
            'products' => $this->products->all(),
        ]);
    }

    /**
     * Display a list enrollment.
     *
     * @param  Request  $request
     * @return Response
     */
    public function tasks(Request $request)
    {
        $product_user = \DB::table('product_user')
                        ->where('status', '=', 'pending')
                        ->get();

        foreach ($product_user as $key => $value) {
            $product = Product::find($product_user[$key]->product_id);
            $user = \App\User::find($product_user[$key]->user_id);
            $product_user[$key]->product_name = $product->name;
            $product_user[$key]->user_name = $user->name;
        }

        return view('products.tasks', [
            'products' => $product_user,
        ]);
    }

    public function moderate($action, $user, $product)
    {
        $product_user = \DB::table('product_user')
                        ->where('status', '=', 'pending')
                        ->where('user_id', '=', $user)
                        ->where('product_id', '=', $product)
                        ->update(['status' => $action]);

        $this->products->updateAvailability($product);

        return redirect('/tasks')->with('message', 'Moderated.');
    }

    public function userProductStatus()
    {
        $my_products = \DB::table('product_user')
                        ->where('user_id', '=', \Auth::user()->id)
                        ->get();

        foreach ($my_products as $key => $value) {
            $product = Product::find($my_products[$key]->product_id);
            $my_products[$key]->product_name = $product->name;
        }

        return view('products.user', [
            'products' => $my_products,
        ]);
    }

    /**
     * Show the form for creating a new product.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Create a new Product.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255|unique:products',
            'image' => 'required',
            'description' => 'required',
            'quantity' => 'required|numeric',
        ]);

        $this->products->create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $request->image,
            'quantity' => $request->quantity,
        ]);

        return redirect('/dashboard')->with('message', 'Product created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('products.show', [
            'product' => $this->products->find($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('products.edit', [
            'product' => $this->products->find($id),
        ]);
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
        $this->validate($request, [
            'name' => 'required|max:255',
            'image' => 'required',
            'description' => 'required',
            'quantity' => 'required|numeric',
        ]);

        $this->products->update([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $request->image,
            'quantity' => $request->quantity,
        ], $id);

        return redirect('/dashboard')->with('message', 'Product updated.');
    }

    /**
     * Destroy the given product.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->products->delete($id);

        return redirect('/dashboard')->with('message', 'Product deleted.');
    }

        /**
     * Enroll a Product.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function enroll(Request $request, $id)
    {
        $product_ids = array();
        $products = $request->user()->products()->get();
        if (!empty($products)) {
            foreach ($products as $product) {
                $product_ids[] = $product->id;
            }
        }

        // Update product_user table.
        $product_ids[] = $id;
        $request->user()->products()->sync($product_ids);

        // Update availability count.
        $this->products->updateAvailability($id);

        return redirect('/products')->with('message', 'Enrolled.');
    }
}
