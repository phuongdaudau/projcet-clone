<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use App\Services\ColorService;
use App\Services\ProductService;
use App\Services\SizeService;
use Illuminate\Http\Request;

use App\Models\Product;

class ProductController extends Controller
{
    protected $productService;
    protected $sizeService;
    protected $colorService;
    protected $categoryService;

    public function __construct(
        ProductService $productService,
        ColorService $colorService,
        CategoryService $categoryService,
        SizeService $sizeService
        )
    {
        $this->productService = $productService;
        $this->colorService = $colorService;
        $this->sizeService = $sizeService;
        $this->categoryService = $categoryService;
    }

    public function list(Request $request)
    {
        $params['orderBy'] = [
            'colum' => 'id',
            'dir'   => 'desc'
        ];
        $params['recorder'] = $request->get('recorder') ?? 6;
        if($request->get('search')){
            $params['search'] = $request->get('search');
        }

        if($request->get('category') && $request->get('category') != 0){
            $params['category'] = $request->get('category');
        }

        $products = $this->productService->filterProducts($params);
        $sizes = $this->sizeService->getListSize();
        $colors = $this->colorService->getListColor();
        $categories = $this->categoryService->getListCategory();
        return view('member.product.list', compact('products', 'sizes', 'colors', 'categories'));
    }

    public function search(Request $request){
        $query = $request->input('query');
        $products = $this->productService->searchProduct($query);
        return view('member.product.search', compact('products', 'query'));
    }
    
    public function detail($slug){
        $product = $this->productService->getProductbySlug($slug);
        return view('member.product.detail', compact('product'));
    }
}
