<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Manufacturer;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{

    public function shopManufacturer(Manufacturer $manufacturer){
        return view('adm.shops.index', ['shops' => $manufacturer->shops, 'manufacturer' => Manufacturer::all()]);
    }

    public function shopCategory(Category $category){
        return view('adm.shops.index', ['shops' => $category->shops, 'categories' => Category::all()]);
    }

    public function show(Shop $shop){
        return view('adm.shops.show', ['shop' => $shop, 'categories' => Category::all()]);
    }

    public function product(Request $request){
        if ($request->search){
            $shops = Shop::where('name', 'LIKE', '%' .$request->search. '%')
                ->with('manufacturer')->get();
        }else{
            $shops = Shop::with('manufacturer')->get();
        }
        return view('adm.shops.product', ['products' => $shops, 'product'=>Shop::all()]);
    }

    public function index(){
        $all = Shop::with('category')->get();
        return view('adm.shops.index',['shops'=>$all, 'categories' => Category::all(), 'manufacturer' => Manufacturer::all()]);
    }

    public function create(){
        return view('adm.shops.create', ['manufacturer' => Manufacturer::all(), 'categories' => Category::all()]);
    }

    public function store(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'size' => 'required|numeric',
            'description' => 'required|',
            'image' =>'required|string',
            'manufacturer_id' => 'required',
            'category_id' => 'required',
        ]);
        Auth::user()->shops()->create($validated);

        return redirect()->route('adm.shops.product')->with('message', 'Saved successfully');
    }

    public function edit(Shop $shop){
        return view('adm.shops.edit', ['shop' => $shop, 'manufacturer' => Manufacturer::all(), 'categories' => Category::all()]);
    }

    public function update(Request $request, Shop $shop){
        $shop->update([
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'size' => $request->input('size'),
            'description' => $request->input('description'),
            'image' => $request->input('image'),
            'manufacturer_id' => $request->input('manufacturer_id'),
            'category_id' => $request->input('category_id'),
        ]);
        return redirect()->route('adm.shops.product',['manufacturer' => Manufacturer::all()])->with('message', 'Updated Successfully');
    }

    public function destroy(Shop $shop){
        $shop->delete();
        return redirect()->route('adm.shops.product')->withErrors('Destroyed successfully');
    }

}
