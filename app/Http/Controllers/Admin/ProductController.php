<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Services\CategoryService;
use App\Services\ColorService;
use App\Services\ProductService;
use App\Services\SizeService;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;

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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = $this->productService->getListProduct();
        return view('admin.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sizes = $this->sizeService->getListSize();
        $colors = $this->colorService->getListColor();
        $categories = $this->categoryService->getListCategory();
        return view('admin.product.create', compact('sizes', 'colors', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $attributes = [
            "name" => $request->name,
            "price" => $request->price,
            "quantity" => $request->quantity,
            "category" => $request->category,
            "colors" => $request->colors,
            "sizes" => $request->sizes,
            "description" => $request->description,
            'images' => $request->images,
        ];
        $this->productService->storeProduct($attributes);
        return redirect()->route('admin.product.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = $this->productService->getProductById($id);
        $sizes = $this->sizeService->getListSize();
        $colors = $this->colorService->getListColor();
        $categories = $this->categoryService->getListCategory();
        return view('admin.product.detail', compact('product', 'sizes', 'colors', 'categories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = $this->productService->getProductById($id);
        $sizes = $this->sizeService->getListSize();
        $colors = $this->colorService->getListColor();
        $categories = $this->categoryService->getListCategory();
        return view('admin.product.edit', compact('product', 'sizes', 'colors', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductUpdateRequest $request, $id)
    {
        $attributes = [
            "name" => $request->name,
            "price" => $request->price,
            "quantity" => $request->quantity,
            "category" => $request->category,
            "colors" => $request->colors,
            "sizes" => $request->sizes,
            "description" => $request->description,
            'images' => $request->images,
        ];
        $this->productService->updateProduct($attributes, $id);
        return redirect()->route('admin.product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->productService->deleteProduct($id);
        return redirect()->route('admin.product.index');
    }
}
