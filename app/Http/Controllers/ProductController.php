<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = Category::all();
        $products = product::with('category')->get();
        return view('product', compact('products', 'category'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'product_name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,category_id',
            'product_price' => 'required|numeric',
            'product_stock' => 'required|integer',
            'product_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($request->hasFile('product_image')) {
            // Simpan gambar ke storage/app/public/products
            $imagePath = $request->file('product_image')->store('products','public');

            // Masukan path/nama file ke dalam array $validateData untuk disimpan ke database
            $validateData['product_image'] = $imagePath;
        }

        Product::create($validateData);

        return redirect()->route('products')->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $products = product::findOrFail($id);

        $validateData = $request->validate([
            'product_name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,category_id',
            'product_price' => 'required|numeric',
            'product_stock' => 'required|integer',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        // jika user mengupload gambar baru, maka hapus gambar lama dan simpan gambar baru
        if ($request->hasFile('product_image')) {
            // hapus gambar lama jika ada
            if ($products->product_image && Storage::disk('public')->exists($products->product_image)) {
                    Storage::disk('public')->delete($products->product_image);
                }
                
            // simpan gambar baru
            $imagePath = $request->file('product_image')->store('products', 'public');
            $validateData['product_image'] = $imagePath;
        }

        $products->update($validateData);

        return redirect()->route('products')->with('success', 'Produk berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $products = product::findOrFail($id);

        // hapus gambar produk dari storage jika ada
        if ($products->product_image && Storage::disk('public')->exists($products->product_image)) {
            Storage::disk('public')->delete($products->product_image);
        }

        $products->delete();

        return redirect()->route('products')->with('success', 'Produk berhasil dihapus!');
    }
}
