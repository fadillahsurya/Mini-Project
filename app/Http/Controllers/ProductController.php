<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function boot(): void { Paginator::useBootstrapFive(); }
     private function generateProductCode(): string
    {
        $date   = date('Ymd');            
        $prefix = "PRD-{$date}-";          

       
        $last = DB::table('master_products')
            ->where('product_code', 'like', $prefix.'%')
            ->orderByDesc('product_code')
            ->limit(1)
            ->value('product_code');

        $seq = 1;
        if ($last) {
            // ambil 4 digit paling kanan sebagai urutan
            $seq = (int) substr($last, -4) + 1;
        }

        return $prefix . str_pad((string)$seq, 4, '0', STR_PAD_LEFT);
    }

    public function index(Request $r)
    {
        $q = trim((string)$r->get('q',''));

        $builder = DB::table('vw_active_products');

        if ($q !== '') {
            $builder->where(function($w) use ($q) {
                $w->where('product_code','like',"%{$q}%")
                  ->orWhere('product_name','like',"%{$q}%");
            });
        }

        $products = $builder->orderByDesc('product_id')->paginate(10);

        return view('products.index', compact('products'));
    }

    public function create()
    {
        // prefill kode otomatis di form (readonly di Blade)
        $autocode = $this->generateProductCode();
        return view('products.create', compact('autocode'));
    }

    public function store(Request $r)
    {
        // product_code TIDAK diwajibkan karena di-generate server-side
        $r->validate([
            // 'product_code'   => 'max:20', // opsional, kalau field tetap dikirim
            'product_name'   => 'required|max:200',
            'price'          => 'required|numeric',
            'stock_quantity' => 'required|integer|min:0',
        ]);

        // paksa pakai kode hasil generate (abaikan input user demi konsistensi)
        $code   = $this->generateProductCode();
        $name   = trim($r->product_name);
        $price  = (float) $r->price;
        $qty    = (int) $r->stock_quantity;
        $active = $r->has('is_active') ? 1 : 0;

        try {
            DB::select('CALL sp_create_product(?,?,?,?,?)', [
                $code, $name, $price, $qty, $active
            ]);
        } catch (\Throwable $e) {
            return back()->withErrors(['db' => $e->getMessage()])->withInput();
        }

        return redirect()->route('products.index')->with('ok', 'Product created');
    }

    public function edit($id)
    {
        $product = DB::table('master_products')->where('product_id', $id)->first();
        abort_unless($product, 404);

        return view('products.edit', compact('product'));
    }

    public function update(Request $r, $id)
    {
        // saat edit, kalau ingin kode bisa diubah → tetap required
        $r->validate([
            'product_code'   => 'required|max:20',
            'product_name'   => 'required|max:200',
            'price'          => 'required|numeric',
            'stock_quantity' => 'required|integer|min:0',
        ]);

        $code   = trim($r->product_code);
        $name   = trim($r->product_name);
        $price  = (float) $r->price;
        $qty    = (int) $r->stock_quantity;
        $active = $r->has('is_active') ? 1 : 0;

        try {
            DB::select('CALL sp_update_product(?,?,?,?,?,?)', [
                (int)$id, $code, $name, $price, $qty, $active
            ]);
        } catch (\Throwable $e) {
            return back()->withErrors(['db' => $e->getMessage()])->withInput();
        }

        return redirect()->route('products.index')->with('ok','Product updated');
    }

    public function destroy($id)
    {
        try {
            DB::select('CALL sp_soft_delete_product(?)', [(int)$id]);
        } catch (\Throwable $e) {
            return back()->withErrors(['db' => $e->getMessage()]);
        }
        return redirect()->route('products.index')->with('ok','Product deleted');
    }

}
