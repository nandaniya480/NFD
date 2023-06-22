<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Traits\WebResponseTrait;
use App\Interfaces\ProductRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use WebResponseTrait;

    protected $productRepository;

    function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
        // $this->middleware('role:Admin', ['only' => ['index', 'store', 'create', 'edit', 'update', 'show', 'destroy']]);
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            info("json");
            return $this->productRepository->dataTable();
        }
        info("not json");
        $titles = [
            'title' => 'Product List',
            'breadcrumb_item' => [
                ['title' => 'Dashboard', 'link' => true, 'route' => route('dashboard')],
                ['title' => 'Product List', 'link' => false, 'route' => ''],
            ],
        ];
        return view('product.index', compact('titles'));
    }

    public function create()
    {
        $titles = [
            'title' => 'Create Product',
            'breadcrumb_item' => [
                ['title' => 'Dashboard', 'link' => true, 'route' => route('dashboard')],
                ['title' => 'Create Product', 'link' => false, 'route' => ''],
            ],
        ];
        return view('product.create', compact('titles'));
    }

    public function store(StoreProductRequest $request)
    {
        try {
            $this->productRepository->create($request->validated());
            $msg = isset($request->id) && $request->id != null ? 'messages.custom.update_messages' : 'messages.custom.create_messages';
            return $this->sendResponse(true, ['data' => []], trans(
                $msg,
                ["attribute" => "Product"]
            ));
        } catch (\Exception $e) {
            return $this->sendResponse(false, [], $e->getMessage());
        }
    }

    public function show($id)
    {
        $product = $this->productRepository->find($id);
        $titles = [
            'title' => 'Product Detail',
            'breadcrumb_item' => [
                ['title' => 'Dashboard', 'link' => true, 'route' => route('dashboard')],
                ['title' => 'Product Detail', 'link' => false, 'route' => ''],
            ],
        ];
        return view('product.show', compact('product', 'titles'));
    }

    public function edit($id)
    {
        $product = $this->productRepository->find($id);
        $titles = [
            'title' => 'Edit Product',
            'breadcrumb_item' => [
                ['title' => 'Dashboard', 'link' => true, 'route' => route('dashboard')],
                ['title' => 'Edit Product', 'link' => false, 'route' => ''],
            ],
        ];
        return view('product.edit', compact('product', 'titles'));
    }

    public function destroy($id)
    {
        try {
            $this->productRepository->delete($id);
            return $this->sendResponse(true, ['data' => []], trans(
                'messages.custom.delete_messages',
                ["attribute" => "User"]
            ));
        } catch (\Exception $e) {
            return $this->sendResponse(false, [], $e->getMessage());
        }
    }

    public function bulkAction(Request $request)
    {
        try {
            $this->productRepository->bulkAction($request);

            // $msg = isset($request->id) && $request->id != null ? 'messages.custom.update_messages' : 'messages.custom.create_messages';
            $msg = 'messages.custom.deleted';

            return $this->sendResponse(true, ['data' => []], trans(
                $msg,
                ["attribute" => "Product"]
            ));
        } catch (\Exception $e) {
            return $e;
            return $this->sendResponse(false, [], $e->getMessage());
        }
    }
}
