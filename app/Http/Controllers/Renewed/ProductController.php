<?php

namespace App\Http\Controllers\Renewed;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    private function createProductValidator(Request $request)
    {
        $rules = [
            'images' => 'required',
            'name' => 'required',
            'price' => 'required|numeric|min:1',
            'stock' => 'required|numeric|min:1',
            'description' => 'required',
            'product_origin' => 'required',
            'dimention' => 'required',
            'weight' => 'required|numeric|min:1'
        ];

        $messages = [
            'required' => 'The :attribute field is required.',
            'numeric' => 'The :attribute field must be numeric.',
            'min' => 'The minimum value of :attribute field is 1.',
        ];

        return Validator::make($request->all(), $rules, $messages);
    }

    public function store(Request $request, $id)
    {
        // authorize user
        if (!Auth::check()) {
            // user not authorized
            return null;
        }

        // validate input request
        $validator = $this->createProductValidator($request);
        if ($validator->fails()) {
            // $validator->fails() returns false, then data are valid
            // $validator->fails() returns true, then data are not valid
            return null;
        }

        $product = new Product();
        $product->color = $request->color;

        if ($id == 1) {
            $product->cat_product = "ulos";
            $product->specification = json_encode([
                'dimention' => $request->dimention,
                'weight' => $request->weight
            ]);
            $product->category = $request->category;
        } else if ($id == 2) {
            $product->cat_product = "pakaian";
            $product->specification = json_encode([
                'size' => $request->dimention,
                'weight' => $request->weight
            ]);
            $product->category = $request->category;
        } else if ($id == 3) {
            $product->cat_product = "makanan";
            $product->specification = json_encode([
                'size_pack' => $request->dimention,
                'weight' => $request->weight,
                'umur_simpan' => $request->color
            ]);
            $product->color = "-";
            $product->category = $request->category;
        } else if ($id == 4) {
            $product->cat_product = "aksesoris";
            $product->specification = json_encode([
                'size' => $request->dimention,
                'weight' => $request->weight
            ]);
            $product->category = $request->category;
        } else if ($id == 5) {
            $product->cat_product = "obat";
            $product->specification = json_encode([
                'jenis' => $request->dimention,
                'weight' => $request->weight
            ]);

            if ($request->dimention == "Padat") {
                $product->color = $request->color_1;
            }

            $product->category = "-";
        }

        $product->user_id = Auth::user()->id;
        $product->name = $request->name;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->sold = 0;
        $product->description = $request->description;
        $product->images = json_encode($request->images);
        $product->asal = $request->product_origin;

        try {
            $product->save();
        } catch (\Exception $e) {
            return null;
        }

        return $product;
    }

    public function update(Request $request, $id)
    {
        // authorize user
        if (!Auth::check()) {
            // user not authorized
            return null;
        }

        // validate input request
        $validator = $this->createProductValidator($request);
        if ($validator->fails()) {
            // $validator->fails() returns false, then data are valid
            // $validator->fails() returns true, then data are not valid
            return null;
        }

        $imageNames = [];
        if ($request->file('images')) {
            $images = $request->file('images');
            foreach ($images as $image) {
                $imageName = time() . "-" . $image->getClientOriginalName();

                array_push($imageNames, $imageName);

                $destinationPath = public_path('/images');
                $image->move($destinationPath, $imageName);
            }
        }

        $product = Product::find($id);
        $product->name = $request->name;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->description = $request->description;

        if ($product->cat_product == "ulos") {
            $product->specification = json_encode([
                'dimention' => $request->dimention,
                'weight' => $request->weight
            ]);
            $product->color = $request->color;
            $product->category = $request->category;
        } else if ($product->cat_product == "pakaian") {
            $product->specification = json_encode([
                'size' => $request->dimention,
                'weight' => $request->weight
            ]);
            $product->color = $request->color;
            $product->category = $request->category;
        } else if ($product->cat_product == "makanan") {
            $product->specification = json_encode([
                'size_pack' => $request->dimention,
                'weight' => $request->weight,
                'umur_simpan' => $request->color
            ]);
            $product->category = $request->category;
        } else if ($product->cat_product == "aksesoris") {
            $product->specification = json_encode([
                'size' => $request->dimention,
                'weight' => $request->weight
            ]);
            $product->color = $request->color;
            $product->category = $request->category;
        } else if ($product->cat_product == "obat") {
            $product->specification = json_encode([
                'jenis' => $request->dimention,
                'weight' => $request->weight
            ]);

            if ($request->dimention == "Padat") {
                $product->color = $request->color;
            } else if ($request->dimention == "Cair") {
                $product->color = $request->color;
            }

            $product->category = "-";
        } else {
            return null;
        }


        $currentImageNames = json_decode($product->images);
        $deletedImages = explode(",", $request->deletedImages);

        foreach ($deletedImages as $image) {
            if (false !== $key = array_search($image, $imageNames)) {
                unset($imageNames[$key]);
            }
        }

        $finalImageNames = array_merge($imageNames, $currentImageNames);

        $product->images = json_encode($finalImageNames);
        $product->update();

        return $product;
    }
}
