<?php
namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductService {
    
    public function getListProduct(){
        return Product::latest()->get();
    }

    public function searchProduct($query){
        return Product::where('name', 'LIKE', "%$query%")->paginate(6);
    }

    public function getProductBySlug($slug){
        return Product::where('slug', $slug)->get();
    }

    public function getProductById($id){
        return Product::where('id', $id)->first();
    }

    public function filterProducts($params)
    {
        $query = Product::query();
        
        if(isset($params['category_id'])){
            return $query->where('category_id', $params['category_id'])->get();
        } else{
            return $query->paginate($params['page']);
        }
    }

    public function storeProduct($data){
        $slug  = Str::slug($data['name']);
        if(isset($data['images'])){
            $imagename = '';
            foreach($data['images'] as $key=>$image){
                $currentDate = Carbon::now()->toDateString();
                $imageName = $slug.'-'. $currentDate .'-'. $key . '.' . $image->getClientOriginalExtension(); 
                //check dir exist
                if (!Storage::disk('public')->exists('product')) {
                    Storage::disk('public')->makeDirectory('product');
                }
                
                Storage::disk('public')->put('product/' . $imageName, $imageName);

                $imagename = $imagename. ',' . $imageName;
            }
        }
        $product = Product::create([
            'admin_id' => Auth::user()->id,
            'category_id' => $data['category'],
            'name' => $data['name'],
            'slug' => $slug,
            'price' => $data['price'],
            'quantity' => $data['quantity'],
            'description' => $data['description'],
            'images' => $imagename,
        ]);
        $product->colors()->attach($data['colors']);
        $product->sizes()->attach($data['sizes']);
    }
    
    public function updateProduct($data, $id){
        $product = $this->getProductById($id);
        $slug  = Str::slug($data['name']);
        if(isset($data['images'])){
            $imagename = '';
            foreach($data['images'] as $key=>$image){
                $currentDate = Carbon::now()->toDateString();
                $imageName = $slug.'-'. $currentDate .'-'. $key . '.' . $image->getClientOriginalExtension(); 
                //check dir exist
                if (!Storage::disk('public')->exists('product')) {
                    Storage::disk('public')->makeDirectory('product');
                }
                
                Storage::disk('public')->put('product/' . $imageName, $imageName);

                $imagename = $imagename. ',' . $imageName;
            }
        }
        $product->update([
            'admin_id' => Auth::user()->id,
            'category_id' => $data['category'],
            'name' => $data['name'],
            'slug' => $slug,
            'price' => $data['price'],
            'quantity' => $data['quantity'],
            'description' => $data['description'],
            'images' => $imagename,
        ]);
        $product->colors()->sync($data['colors']);
        $product->sizes()->sync($data['sizes']);
    }
    public function deleteProduct($id){
        $product = Product::where('id', $id);
        $product->colors()->detach();
        $product->sizes()->detach();
        $product->delete();
    }

}