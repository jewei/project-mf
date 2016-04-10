<?php

namespace App\Repositories;

use App\User;
use App\Product;
use DB;

class ProductRepository
{
    /**
     * Maintain the product availability count.
     *
     * @param $id
     */
    public function updateAvailability($id)
    {
        $product_user = DB::table('product_user')
                        ->where('product_id', '=', $id)
                        ->where('status', '=', 'approved')
                        ->get();
        $taken = count($product_user);

        $product = Product::find($id);
        $product->available = $product->quantity - $taken;

        return $product->save();
    }

    /**
     * Get all of the available products.
     *
     * @return Collection
     */
    public function available()
    {
        $products = Product::where('available', '>', 0)
                    ->orderBy('created_at', 'asc')
                    ->get();

        return $products;
    }

    /**
     * Get all products for admin purpose.
     *
     * @return Collection
     */
    public function all()
    {
        return Product::where('id', '>', 0)
                    ->orderBy('created_at', 'asc')
                    ->get();
    }

    /**
     * Get all of the available products.
     *
     * @param  User  $user
     * @return Collection
     */
    public function status(User $user)
    {
        return Product::where('user_id', $user->id)
                    ->orderBy('created_at', 'asc')
                    ->get();
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        $product = new Product;
        $product->name = $data['name'];
        $product->description = $data['description'];
        $product->image = $data['image'];
        $product->quantity = $data['quantity'];
        $product->available = $data['quantity'];

        return $product->save();
    }

    /**
     * @param array $data
     * @param $id
     * @param string $attribute
     */
    public function update(array $data, $id, $attribute = "id")
    {
        $product = Product::find($id);
        $product->name = $data['name'];
        $product->description = $data['description'];
        $product->image = $data['image'];
        $product->quantity = $data['quantity'];
        $product->save();
        $this->updateAvailability($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        $product = Product::find($id);

        return $product->destroy($id);
    }

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = array('*'))
    {
        return Product::where('id', $id)->get();
    }

    /**
     * @param $attribute
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($attribute, $value, $columns = array('*'))
    {
        return $this->model->where($attribute, '=', $value)->first($columns);
    }
}
