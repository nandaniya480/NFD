<?php

namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use Yajra\DataTables\Facades\DataTables;

class ProductRepository implements ProductRepositoryInterface
{
    public function dataTable()
    {
        $data = Product::all();
        return DataTables::of($data)
            ->addIndexColumn()
            // ->addColumn('select', function ($row) {
            //     // return '<input type="checkbox" class="bulk-select-checkbox" value="' . $row->id . '">';
            //     return '';
            // })

            ->editColumn('action', function ($row) {
                $btn =  '<div class="v-button"><a href="' . route('product.show', $row->id) . '" class="btn"><i class="menu-icon tf-icons ti ti-solid ti-eye"></i></a>';
                $btn .=  '<a href="' . route('product.edit', $row->id) . '" class="btn" ><i class="menu-icon tf-icons ti ti-solid ti-pencil"></i></a>';
                $btn .= '<button class="btn deleteProduct" data-id="' . $row->id . '" data-action="' . route('product.destroy', $row->id) . '" ><i class="menu-icon tf-icons ti ti-solid ti-trash"></i></button></div>';
                return $btn;
            })
            // ->rawColumns(['select', 'action'])
            ->rawColumns(['action'])
            ->make(true);
    }

    public function all()
    {
        return Product::pluck('name')->all();
    }

    public function create($data)
    {
        if (isset($data['id']) && $data['id'] != null) {
            $product = Product::find($data['id'])->update($data);
        } else {
            $product = Product::create($data);
        }
    }

    public function delete($id)
    {
        Product::destroy($id);
    }

    public function find($id)
    {
        return Product::find($id);
    }
}
