<?php
namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductService {
    
    public function query()
    {
        return Product::query();
    }

    public function getListProduct(){
        return Product::latest()->get();
    }

    public function searchProduct($query){
        return Product::where('name', 'LIKE', "%$query%")->paginate(6);
    }

    public function getProductBySlug($slug){
        return Product::where('slug', $slug)->first();
    }

    public function getProductById($id){
        return Product::where('id', $id)->first();
    }

    public function filterProducts($params)
    {
        $recorder = $params['recorder'] ?? 10;
        $query = Product::query();

        if(isset($params['category_id'])){
            $query->where('category_id', $params['category_id']);
        }

        if(isset($params['orderBy'])){
            $query->orderBy($params['orderBy']['colum'], $params['orderBy']['dir']);
        }

        if(isset($params['search'])){
            $query->where('name', 'LIKE', '%'.$params['search'].'%');
        }

        return $query->paginate($recorder);
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
                $productImage = Image::make($image)->resize(333, 466)->save($imageName);
                Storage::disk('public')->put('product/' . $imageName, $productImage);

                $imagename = $imagename. ',' . $imageName;
            }
        }
        $product = Product::create([
            'admin_id' => Auth::id(),
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
    
    public function updateProduct($data, $id)
    {
        $product = $this->getProductById($id);
        $slug  = Str::slug($data['name']);
        if(isset($data['images'])){
            $imgs = explode(",", $product->images);
            $images = array_slice($imgs,1,3);
            foreach($images as $image){
                if (Storage::disk('public')->exists('product/' . $image)) {
                    Storage::disk('public')->delete('product/' . $image);
                }
            }
            $imagename = '';
            foreach($data['images'] as $key=>$image){
                $currentDate = Carbon::now()->toDateString();
                $imageName = $slug.'-'. $currentDate .'-'. $key . '.' . $image->getClientOriginalExtension(); 
                //check dir exist
                if (!Storage::disk('public')->exists('product')) {
                    Storage::disk('public')->makeDirectory('product');
                }
                $productImage = Image::make($image)->resize(333, 466)->save($imageName);
                Storage::disk('public')->put('product/' . $imageName, $productImage);

                $imagename = $imagename. ',' . $imageName;
            }
        }
        $product->update([
            'admin_id' => Auth::id(),
            'category_id' => $data['category'],
            'name' => $data['name'],
            'slug' => $slug,
            'price' => $data['price'],
            'quantity' => $data['quantity'],
            'description' => $data['description'],
            'images' => $imagename ?? $product->images,
        ]);
        $product->colors()->sync($data['colors']);
        $product->sizes()->sync($data['sizes']);
    }
    public function deleteProduct($id)
    {
        return Product::destroy($id);
    }

    public function deleteProductImage($id)
    {
        try {
            DB::beginTransaction();
            if(!$this->deleteImage($id)){
                return false;
            }
            if(!is_array($id)){
                $ids = array($id);
            }
            foreach($ids  as $key=>$id){
                $product = Product::find($id);
                $product->colors()->detach();
                $product->sizes()->detach();
                $product->delete();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
        return true;
    }

    public function deleteImage($arrayId)
    {

        if(!is_array($arrayId)){
            $arrayId = array($arrayId);
        }

        try {
            DB::beginTransaction();
            foreach($arrayId as $key=>$id){
                $rs = $this->query()->find($id);
                 if($rs){
                    $imgs = explode(",", $rs->images);
                    $images = array_slice($imgs,1,3);
                    foreach($images as $image){
                        $path = $image;
                        if(file_exists($path)){
                             unlink($path);
                        }
                    }
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
        return true;
    }

}