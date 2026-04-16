<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\ShoppingCartResource;
use App\Models\Order;
use App\Models\ProductDetail;
use App\Models\ShoppingCart;
use Auth;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Yajra\DataTables\EloquentDataTable;

class ShoppingCartController extends Controller
{
    public function index($user_id){
        $data = [
            'carts' => ShoppingCart::with(['productDetail.product','productDetail.promo'])->where('user_id',$user_id)->get(),
        ];
        return view('Customer.shopping_carts', $data);
    }

    public function addToCart(Request $request)
    {
        $unitTypeId = $request->input('unit_type');
        $quantity = $request->input('quantity');
        $userId = $request->input('user_id');

        // Validate the data
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'unit_type' => 'required|exists:product_details,id',
            'quantity' => [
                'required',
                'integer',
                'min:1',
                function (string $attribute, mixed $value, Closure $fail) use ($unitTypeId, $userId) {
                    $productDetail = ProductDetail::with('product')->find($unitTypeId);
                    $cartQuantity = ShoppingCart::where('user_id', $userId)
                        ->where('product_detail_id', $unitTypeId)
                        ->value('quantity') ?? 0;
    
                    if (($cartQuantity + $value) > $productDetail->quantity) {
                        $fail("Stok {$productDetail->product->name} habis");
                    }
                },
            ],
        ]);

        $cartQuantity = ShoppingCart::where('user_id', $userId)
                    ->where('product_detail_id', $unitTypeId)
                    ->value('quantity');
        $cart = ShoppingCart::updateOrCreate(
            [
                'user_id' => $userId,
                'product_detail_id' => $unitTypeId
            ],
            ['quantity' => $cartQuantity + $quantity]
        );

        if($cart){
            return response()->json([
                'success'       => true,
                'count_cart'    => Auth::user()->shoppingCarts->count(),
                'message'       => 'Product added to cart successfully!',
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Failed to add cart',
        ],500);
    }

    public function update(Request $request, $id)
    {
        $cart = ShoppingCart::findOrFail($id);

        if ($request->has('quantity')) {
            $cart->quantity = $request->input('quantity');
        }

        if ($request->has('productDetailId')) {
            $cart->product_detail_id = $request->input('productDetailId');
        }

        $cart->save();

        $productDetail = ProductDetail::findOrFail($cart->product_detail_id);
        $price = $productDetail->promo?->active ? $productDetail->promo_price : $productDetail->price;
        
        return response()->json([
            'success' => true,
            'price' => $price,
            'priceHtml' => $productDetail->promo?->active
                ? '<small class="text-muted"><s>' . \number_format($productDetail->price,0,',','.') . '</s></small> Rp ' . \number_format($productDetail->promo_price,0,',','.')
                : 'Rp ' . \number_format($productDetail->price,0,',','.'),
            'quantityLeft' => $productDetail->quantity,
        ]);
    }

    // Delete cart item
    public function destroy($id)
    {
        $cart = ShoppingCart::findOrFail($id);
        $cart->delete();

        return response()->json(['success' => true]);
    }
}
