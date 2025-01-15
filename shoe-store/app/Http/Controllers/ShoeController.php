<?php

namespace App\Http\Controllers;

use App\Models\Shoe;
use Illuminate\Http\Request;

class ShoeController extends Controller
{
    public function index()
    {
        $shoes = Shoe::paginate(12); // Hiển thị 12 sản phẩm mỗi trang
        return view('shoes.index', compact('shoes'));
    }

    public function search(Request $request)
    {
        $keyword = $request->input('q');

        $shoes = Shoe::where('name', 'LIKE', "%$keyword%")
            ->orWhere('brand', 'LIKE', "%$keyword%")
            ->paginate(12);

        return view('shoes.index', compact('shoes'))->with('keyword', $keyword);
    }

    public function filter(Request $request)
    {
        $query = Shoe::query();

        if ($request->has('brand') && $request->brand) {
            $query->where('brand', $request->brand);
        }

        if ($request->has('min_price') && $request->has('max_price')) {
            $query->whereBetween('price', [$request->min_price, $request->max_price]);
        }

        $shoes = $query->paginate(12);

        return view('shoes.index', compact('shoes'));
    }

}

