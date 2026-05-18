<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Wishlist;
use Session;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;
use App\Models\Order;

class ProductController extends Controller
{
    private const MAX_CART_QUANTITY = 3;
    private const DEAL_DISCOUNTS = [
        'MacBook Air 13 inch M3' => 17,
        'Samsung Galaxy S24 Ultra' => 12,
        'PlayStation 5 Slim Console' => 15,
        'Bose QuietComfort Ultra Headphones' => 19,
        'Ninja Foodi DualZone Air Fryer' => 21,
    ];
    private const NEW_ARRIVAL_PRODUCTS = [
        'iPad Air 11 inch M2',
        'AirPods Pro 2',
        'Google Pixel Watch 3',
        'GoPro HERO13 Black',
        'Canon EOS R50 Camera',
        'JBL Flip 6 Speaker',
        'Meta Quest 3 Headset',
    ];
    private const FEATURED_PRODUCTS = [
        'Samsung 55 inch Crystal UHD TV',
        'LG OLED C4 48 inch TV',
        'iPad Air 11 inch M2',
        'Canon EOS R50 Camera',
        'AirPods Pro 2',
        'Google Pixel Watch 3',
        'GoPro HERO13 Black',
        'JBL Flip 6 Speaker',
    ];
    private const CATEGORY_TITLES = [
        'mobile' => 'Mobiles',
        'tv' => 'TVs',
        'fridge' => 'Fridges',
        'laptop' => 'Laptops',
        'gaming' => 'Gaming',
        'audio' => 'Audio',
        'appliance' => 'Appliances',
        'tablet' => 'Tablets',
        'earbuds' => 'Earbuds',
        'wearable' => 'Wearables',
        'camera' => 'Cameras',
    ];

    function index()
    {
        $featuredNames = self::FEATURED_PRODUCTS;
        $productsByName = Product::whereIn('name', $featuredNames)->get()->keyBy('name');

        $data=collect($featuredNames)->map(function ($name) use ($productsByName) {
            return $productsByName->get($name);
        })->filter()->values();

        if($data->isEmpty()) {
            $data = Product::latest()->limit(8)->get();
        }

       return view('product',[
        'products'=>$data,
        'wishlistedProducts'=>$this->wishlistedProductIds(),
       ]);
    }
    function detail($id)
    {
        $data=Product::find($id);

        if($data) {
            $this->decorateProductPricing($data);
        }

        return view('detail',[
            'product'=>$data,
            'wishlistedProducts'=>$this->wishlistedProductIds(),
        ]);
    }
    function search(Request $req)
    {
        $query = trim((string) $req->input('query', ''));
        $category = $req->input('category');

        if(!$category && $query !== '' && strlen($query) < 2) {
            return redirect('/search');
        }

        $data= Product::query()
        ->when($category, function ($products) use ($category) {
            return $products->where('category', 'like', '%'.$category.'%');
        })
        ->when(!$category && $query, function ($products) use ($query) {
            return $products->where(function ($products) use ($query) {
                $products->where('name', 'like', '%'.$query.'%')
                ->orWhere('category', 'like', '%'.$query.'%');
            });
        })
        ->get()
        ->map(function ($product) {
            return $this->decorateProductPricing($product);
        });

        return view('search',[
            'products'=>$data,
            'wishlistedProducts'=>$this->wishlistedProductIds(),
        ]);
    }

    function searchSuggestions(Request $req)
    {
        $query = trim((string) $req->input('query', ''));

        if(strlen($query) < 2) {
            return response()->json([
                'products' => [],
                'categories' => [],
            ]);
        }

        $products = Product::query()
        ->where(function ($products) use ($query) {
            $products->where('name', 'like', '%'.$query.'%')
            ->orWhere('category', 'like', '%'.$query.'%');
        })
        ->orderBy('name')
        ->limit(5)
        ->get()
        ->map(function ($product) {
            return [
                'name' => $product->name,
                'category' => self::categoryLabel($product->category),
                'price' => '$'.number_format((float) $product->price, 2),
                'image' => Product::imageUrl($product->gallery),
                'url' => url('/detail/'.$product->id),
            ];
        })
        ->values();

        $categories = self::categoryOptions()
        ->filter(function ($label, $category) use ($query) {
            return Str::contains(Str::lower($category), Str::lower($query))
            || Str::contains(Str::lower($label), Str::lower($query));
        })
        ->take(5)
        ->map(function ($label, $category) {
            return [
                'label' => $label,
                'url' => url('/search').'?category='.urlencode($category),
            ];
        })
        ->values();

        return response()->json([
            'products' => $products,
            'categories' => $categories,
        ]);
    }

    static function categoryOptions()
    {
        return Product::query()
        ->select('category')
        ->distinct()
        ->orderBy('category')
        ->pluck('category')
        ->filter()
        ->mapWithKeys(function ($category) {
            return [$category => self::categoryLabel($category)];
        });
    }

    static function categoryLabel($category): string
    {
        return self::CATEGORY_TITLES[$category] ?? Str::headline($category);
    }

    function deals()
    {
        $dealNames = array_keys(self::DEAL_DISCOUNTS);
        $productsByName = Product::whereIn('name', $dealNames)->get()->keyBy('name');

        $data=collect($dealNames)->map(function ($name) use ($productsByName) {
            return $productsByName->get($name);
        })->filter()->map(function ($product) {
            return $this->decorateProductPricing($product);
        })->values();

        return view('collection',[
            'products'=>$data,
            'wishlistedProducts'=>$this->wishlistedProductIds(),
            'pageKicker'=>'Limited offers',
            'pageTitle'=>'Deals worth showing.',
            'pageSubtitle'=>'Handpicked offers featuring standout prices across our catalog.',
            'pageMode'=>'deals',
        ]);
    }

    private function dealDiscountPercent($product): int
    {
        return self::DEAL_DISCOUNTS[$product->name] ?? 0;
    }

    private function productUnitPrice($product): float
    {
        $price = (float) $product->price;
        $discount = $this->dealDiscountPercent($product);

        if($discount <= 0) {
            return $price;
        }

        return max(1, round($price * (100 - $discount) / 100, 2));
    }

    private function decorateProductPricing($product)
    {
        $discount = $this->dealDiscountPercent($product);

        $product->original_price = (float) $product->price;
        $product->unit_price = $this->productUnitPrice($product);
        $product->deal_discount_percent = $discount;
        $product->is_deal = $discount > 0;

        return $product;
    }

    function newArrivals()
    {
        $newArrivalNames = self::NEW_ARRIVAL_PRODUCTS;
        $productsByName = Product::whereIn('name', $newArrivalNames)->get()->keyBy('name');

        $data = collect($newArrivalNames)->map(function ($name) use ($productsByName) {
            return $productsByName->get($name);
        })->filter()->values();

        return view('collection',[
            'products'=>$data,
            'wishlistedProducts'=>$this->wishlistedProductIds(),
            'pageKicker'=>'Fresh in store',
            'pageTitle'=>'New Arrivals',
            'pageSubtitle'=>'Discover the latest tech additions now available at CartFuse.',
            'pageMode'=>'new',
        ]);
    }
    function addToCart(Request $req)
    {
        $req->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $this->putProductInCart($req, $req->product_id);

        if($req->ajax() || $req->wantsJson()) {
            return response()->json([
                'added' => true,
                'cart_count' => self::cartItem(),
            ]);
        }

        return back();
    }

    private function putProductInCart(Request $req, $productId)
    {
        if($this->cartProductQuantity($req, $productId) >= self::MAX_CART_QUANTITY) {
            return;
        }

        if($req->session()->has('user'))
        {
           $cart= new Cart;
           $cart->user_id=$req->session()->get('user')['id'];
           $cart->product_id=$productId;
           $cart->save();

           return;
        }

        $cart = $req->session()->get('cart', []);
        $cart[] = (int) $productId;
        $req->session()->put('cart', $cart);
    }

    private function cartProductQuantity(Request $req, $productId)
    {
        if($req->session()->has('user')) {
            return Cart::where('user_id',$req->session()->get('user')['id'])
            ->where('product_id',$productId)
            ->count();
        }

        return collect($req->session()->get('cart', []))->filter(function ($cartProductId) use ($productId) {
            return (int) $cartProductId === (int) $productId;
        })->count();
    }

    private function enforceCartQuantityLimit(Request $req)
    {
        if(!$req->session()->has('user')) {
            $limitedCart = collect($req->session()->get('cart', []))->groupBy(function ($productId) {
                return (int) $productId;
            })->flatMap(function ($productIds) {
                return $productIds->take(self::MAX_CART_QUANTITY);
            })->values()->all();

            $req->session()->put('cart', $limitedCart);

            return;
        }

        $userId = $req->session()->get('user')['id'];
        $cartGroups = Cart::where('user_id',$userId)
        ->select('product_id', DB::raw('COUNT(id) as quantity'))
        ->groupBy('product_id')
        ->get();

        foreach($cartGroups as $cartGroup) {
            if($cartGroup->quantity <= self::MAX_CART_QUANTITY) {
                continue;
            }

            $extraCartIds = Cart::where('user_id',$userId)
            ->where('product_id',$cartGroup->product_id)
            ->orderBy('id')
            ->pluck('id')
            ->skip(self::MAX_CART_QUANTITY)
            ->values();

            Cart::whereIn('id',$extraCartIds)->delete();
        }
    }

    private function cartResponseData(Request $req, $productId)
    {
        $quantity = $this->cartProductQuantity($req, $productId);
        $product = Product::find($productId);
        $subtotal = $product ? $this->productUnitPrice($product) * $quantity : 0;
        $cartTotal = $this->currentCartTotal($req);

        return [
            'quantity' => $quantity,
            'subtotal' => '$'.number_format($subtotal, 2),
            'cart_count' => self::cartItem(),
            'cart_total' => '$'.number_format($cartTotal, 2),
            'max_quantity' => self::MAX_CART_QUANTITY,
        ];
    }

    private function currentCartTotal(Request $req)
    {
        if(!$req->session()->has('user')) {
            $cart = $req->session()->get('cart', []);

            return Product::whereIn('id', $cart)->get()->sum(function ($product) use ($cart) {
                $quantity = collect($cart)->filter(function ($productId) use ($product) {
                    return (int) $productId === (int) $product->id;
                })->count();

                return $this->productUnitPrice($product) * $quantity;
            });
        }

        $userId = $req->session()->get('user')['id'];

        return DB::table('cart')
        ->join('products','cart.product_id','=','products.id')
        ->where('cart.user_id',$userId)
        ->select('products.*', DB::raw('COUNT(cart.id) as quantity'))
        ->groupBy('cart.product_id','products.id','products.name','products.price','products.category','products.description','products.gallery','products.created_at','products.updated_at')
        ->get()
        ->sum(function ($product) {
            return $this->productUnitPrice($product) * $product->quantity;
        });
    }
    static function cartItem()
    {
     if(!Session::has('user')) {
        return count(Session::get('cart', []));
     }

     $userId=Session::get('user')['id']; 
     return Cart::where('user_id',$userId)->count();
    }

    static function wishlistItem()
    {
        if(!Session::has('user')) {
            return count(Session::get('wishlist', []));
        }

        $userId=Session::get('user')['id'];
        return Wishlist::where('user_id',$userId)->count();
    }

    private function wishlistedProductIds()
    {
        if(!Session::has('user')) {
            return collect(Session::get('wishlist', []))->map(function ($productId) {
                return (int) $productId;
            })->all();
        }

        $userId=Session::get('user')['id'];
        return Wishlist::where('user_id',$userId)->pluck('product_id')->map(function ($productId) {
            return (int) $productId;
        })->all();
    }

    function addToWishlist(Request $req)
    {
        $req->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        if($req->session()->has('user')) {
            $userId=$req->session()->get('user')['id'];

            $exists = Wishlist::where('user_id',$userId)
            ->where('product_id',$req->product_id)
            ->exists();

            if(!$exists) {
                $wishlist= new Wishlist;
                $wishlist->user_id=$userId;
                $wishlist->product_id=$req->product_id;
                $wishlist->save();
            }
        }
        else {
            $wishlist = $req->session()->get('wishlist', []);
            $wishlist[] = (int) $req->product_id;
            $wishlist = array_values(array_unique($wishlist));
            $req->session()->put('wishlist', $wishlist);
        }

        if($req->ajax() || $req->wantsJson()) {
            return response()->json([
                'wishlisted' => true,
                'wishlist_count' => self::wishlistItem(),
            ]);
        }

        return back();
    }

    function removeFromWishlist(Request $req)
    {
        $req->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        if(!Session::has('user')) {
            $wishlist = Session::get('wishlist', []);
            $wishlist = array_values(array_filter($wishlist, function ($productId) use ($req) {
                return (int) $productId !== (int) $req->product_id;
            }));
            Session::put('wishlist', $wishlist);

            if($req->ajax() || $req->wantsJson()) {
                return response()->json([
                    'wishlisted' => false,
                    'wishlist_count' => self::wishlistItem(),
                ]);
            }

            return back();
        }

        $userId=Session::get('user')['id'];
        Wishlist::where('user_id',$userId)
        ->where('product_id',$req->product_id)
        ->delete();

        if($req->ajax() || $req->wantsJson()) {
            return response()->json([
                'wishlisted' => false,
                'wishlist_count' => self::wishlistItem(),
            ]);
        }

        return back();
    }

    function wishlist()
    {
        if(!Session::has('user')) {
            $wishlist = Session::get('wishlist', []);
            $productsById = Product::whereIn('id', $wishlist)->get()->keyBy('id');

            $products = collect($wishlist)->map(function ($productId) use ($productsById) {
                $product = $productsById->get($productId);

                if(!$product) {
                    return null;
                }

                $item = (object) $product->toArray();
                $item->wishlist_id = $productId;
                $this->decorateProductPricing($item);

                return $item;
            })->filter()->values();

            return view('wishlist',['products'=>$products]);
        }

        $userId=Session::get('user')['id'];
        $products= DB::table('wishlist')
        ->join('products','wishlist.product_id','=','products.id')
        ->where('wishlist.user_id',$userId)
        ->select('products.*','wishlist.id as wishlist_id')
        ->get()
        ->map(function ($item) {
            return $this->decorateProductPricing($item);
        });

        return view('wishlist',['products'=>$products]);
    }

    function removeWishlist($id)
    {
        if(!Session::has('user')) {
            $wishlist = Session::get('wishlist', []);
            $wishlist = array_values(array_filter($wishlist, function ($productId) use ($id) {
                return (int) $productId !== (int) $id;
            }));
            Session::put('wishlist', $wishlist);

            return redirect('wishlist');
        }

        Wishlist::destroy($id);
        return redirect('wishlist');
    }

    function buyWishlist(Request $req)
    {
        $req->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $this->putProductInCart($req, $req->product_id);

        if($req->ajax() || $req->wantsJson()) {
            return response()->json($this->cartResponseData($req, $req->product_id));
        }

        return redirect('cartlist');
    }
    function cartlist(Request $req)
    {
        $this->enforceCartQuantityLimit($req);

        if(!Session::has('user')) {
            $cart = Session::get('cart', []);
            $productsById = Product::whereIn('id', $cart)->get()->keyBy('id');

            $products = collect($cart)->countBy()->map(function ($quantity, $productId) use ($productsById) {
                $product = $productsById->get($productId);

                if(!$product) {
                    return null;
                }

                $item = (object) $product->toArray();
                $item->cart_id = $productId;
                $item->quantity = $quantity;
                $this->decorateProductPricing($item);
                $item->subtotal = $item->unit_price * $quantity;

                return $item;
            })->filter()->values();

            return view('cartlist',[
                'products'=>$products,
                'cartTotal'=>$products->sum('subtotal'),
            ]);
        }

        $userId=Session::get('user')['id'];
        $products= DB::table('cart')
        ->join('products','cart.product_id','=','products.id')
        ->where('cart.user_id',$userId)
        ->select('products.*','cart.product_id as cart_id', DB::raw('COUNT(cart.id) as quantity'))
        ->groupBy('cart.product_id','products.id','products.name','products.price','products.category','products.description','products.gallery','products.created_at','products.updated_at')
        ->get()
        ->map(function ($item) {
            $this->decorateProductPricing($item);
            $item->subtotal = $item->unit_price * $item->quantity;

            return $item;
        });

        return view('cartlist',[
            'products'=>$products,
            'cartTotal'=>$products->sum('subtotal'),
        ]);
    }
    function removeCart($id) // Removes selected product from cart
    {
        if(!Session::has('user')) {
            $cart = Session::get('cart', []);
            $cart = array_values(array_filter($cart, function ($productId) use ($id) {
                return (int) $productId !== (int) $id;
            }));
            Session::put('cart', $cart);

            return redirect('cartlist');
        }

        $userId=Session::get('user')['id'];
        Cart::where('user_id',$userId)->where('product_id',$id)->delete();

        return redirect('cartlist');
    }

    function increaseCart(Request $req)
    {
        $req->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $this->putProductInCart($req, $req->product_id);

        if($req->ajax() || $req->wantsJson()) {
            return response()->json($this->cartResponseData($req, $req->product_id));
        }

        return redirect('cartlist');
    }

    function decreaseCart(Request $req)
    {
        $req->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        if(!Session::has('user')) {
            $cart = Session::get('cart', []);
            $removed = false;
            $cart = array_values(array_filter($cart, function ($productId) use ($req, &$removed) {
                if(!$removed && (int) $productId === (int) $req->product_id) {
                    $removed = true;
                    return false;
                }

                return true;
            }));
            Session::put('cart', $cart);

            if($req->ajax() || $req->wantsJson()) {
                return response()->json($this->cartResponseData($req, $req->product_id));
            }

            return redirect('cartlist');
        }

        $userId=Session::get('user')['id'];
        $cartItem = Cart::where('user_id',$userId)
        ->where('product_id',$req->product_id)
        ->first();

        if($cartItem) {
            $cartItem->delete();
        }

        if($req->ajax() || $req->wantsJson()) {
            return response()->json($this->cartResponseData($req, $req->product_id));
        }

        return redirect('cartlist');
    }

    function updateCart(Request $req)
    {
        $req->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:'.self::MAX_CART_QUANTITY,
        ]);

        $productId = (int) $req->product_id;
        $quantity = (int) $req->quantity;

        if(!Session::has('user')) {
            $cart = array_values(array_filter(Session::get('cart', []), function ($cartProductId) use ($productId) {
                return (int) $cartProductId !== $productId;
            }));

            for($i = 0; $i < $quantity; $i++) {
                $cart[] = $productId;
            }

            Session::put('cart', $cart);

            if($req->ajax() || $req->wantsJson()) {
                return response()->json($this->cartResponseData($req, $productId));
            }

            return redirect('cartlist');
        }

        $userId=Session::get('user')['id'];
        Cart::where('user_id',$userId)
        ->where('product_id',$productId)
        ->delete();

        for($i = 0; $i < $quantity; $i++) {
            $cart = new Cart;
            $cart->user_id = $userId;
            $cart->product_id = $productId;
            $cart->save();
        }

        if($req->ajax() || $req->wantsJson()) {
            return response()->json($this->cartResponseData($req, $productId));
        }

        return redirect('cartlist');
    }

    function OrderNow(Request $req) // Ordernow function
    {
        if($req->filled('product_id')) {
            $req->validate([
                'product_id' => 'exists:products,id',
            ]);

            $this->putProductInCart($req, $req->product_id);
        }

        $this->enforceCartQuantityLimit($req);

        $userId=Session::get('user')['id'];
        $checkoutItems = DB::table('cart')
        ->join('products','cart.product_id','=','products.id')
        ->where('cart.user_id',$userId)
        ->select('products.*', DB::raw('COUNT(cart.id) as quantity'))
        ->groupBy('cart.product_id','products.id','products.name','products.price','products.category','products.description','products.gallery','products.created_at','products.updated_at')
        ->get()
        ->map(function ($item) {
            $this->decorateProductPricing($item);
            $item->subtotal = $item->unit_price * $item->quantity;

            return $item;
        });

        $subtotal= $checkoutItems->sum('subtotal');

        $tax = 0;
        $fee = $subtotal > 0 ? 10 : 0;
        $grandTotal = $subtotal + $tax + $fee;

        return view('ordernow',[
            'checkoutItems'=>$checkoutItems,
            'subtotal'=>$subtotal,
            'tax'=>$tax,
            'fee'=>$fee,
            'delivery'=>$fee,
            'grandTotal'=>$grandTotal,
        ]);
    }
    function orderPlace(Request $req)
    {
    $this->enforceCartQuantityLimit($req);

    $userId=Session::get('user')['id'];
    $allCart=Cart::where('user_id',$userId)->get();

    if($allCart->isEmpty()) {
        return redirect('cartlist')->with('error','Your cart is empty. Add a product before checkout.');
    }

    $req->validate([
        'label' => 'required|string|max:40',
        'street' => 'required|string|max:120',
        'apartment' => 'nullable|string|max:80',
        'city' => 'required|string|max:80',
        'postal_code' => 'required|string|max:20',
        'country' => 'required|string|max:80',
        'phone' => 'nullable|string|max:30',
        'payment' => 'required|in:online,emi,cash',
    ],[
        'label.required' => 'Please add an address label.',
        'street.required' => 'Please add a street address.',
        'city.required' => 'Please add a city.',
        'postal_code.required' => 'Please add a postal code.',
        'country.required' => 'Please choose a country.',
        'payment.required' => 'Please choose a payment method.',
    ]);

    $deliveryAddress = collect([
        $req->label,
        $req->street,
        $req->apartment,
        trim($req->city.' '.$req->postal_code),
        $req->country,
        $req->phone,
    ])->filter()->implode(', ');

    DB::transaction(function () use ($allCart, $deliveryAddress, $req, $userId) {
        foreach($allCart as $cart)
        {
            $order=new Order;
            $order->product_id=$cart['product_id'];
            $order->user_id=$cart['user_id'];
            $order->status="pending";
            $order->payment_method=$req->payment;
            $order->payment_status="pending";
            $order->address=$deliveryAddress;
            $order->save();
        }

        Cart::where('user_id',$userId)->delete();
    });
    
    $req->input();
    return redirect('myorders')->with('success','Order placed. It is waiting for confirmation.');

    }
    function myOrders()
    {
        $userId=Session::get('user')['id'];
        $orders=DB::table('orders')
        ->join('products','orders.product_id','=','products.id')
        ->where('orders.user_id',$userId)
        ->select('products.*','orders.id as order_id','orders.status','orders.cancel_reason','orders.address','orders.payment_status','orders.payment_method','orders.created_at as order_date')
        ->orderByRaw("CASE WHEN orders.status = 'cancelled' THEN 1 ELSE 0 END")
        ->orderBy('orders.created_at','desc')
        ->get();

        $historyStatuses=['cancelled','delivered'];
        $ordersByHistoryStatus=$orders->partition(function ($order) use ($historyStatuses) {
            $status=strtolower(trim($order->status ?? 'pending'));
            return in_array($status,$historyStatuses,true);
        });

        return view('myorders',[
            'activeOrders'=>$ordersByHistoryStatus[1]->values(),
            'orderHistory'=>$ordersByHistoryStatus[0]->values(),
        ]);
        
    }

    function cancelOrder(Request $req)
    {
        $req->validate([
            'order_id' => 'required|exists:orders,id',
            'cancel_email' => 'required|email',
            'cancel_reason_group' => 'required|in:Changed my mind,Ordered by mistake,Found a better price,Delivery takes too long,Other',
            'cancel_reason_details' => 'required|string|max:255',
        ]);

        $userId=Session::get('user')['id'];
        $userEmail=Session::get('user')['email'];

        if($req->cancel_email !== $userEmail) {
            return back()->withErrors(['cancel_email' => 'Please use your account email address.']);
        }

        $cancelReason=$req->cancel_reason_group.': '.$req->cancel_reason_details.' ('.$userEmail.')';

        Order::where('id',$req->order_id)
        ->where('user_id',$userId)
        ->where('status','pending')
        ->update([
            'status' => 'cancelled',
            'cancel_reason' => $cancelReason,
            'payment_status' => 'cancelled',
        ]);

        return redirect('myorders')->with('success','Order cancelled and moved to order history.');
    }

    function deleteOrder(Request $req)
    {
        $req->validate([
            'order_id' => 'required|exists:orders,id',
        ]);

        $userId=Session::get('user')['id'];
        Order::where('id',$req->order_id)
        ->where('user_id',$userId)
        ->where('status','cancelled')
        ->delete();

        return redirect('myorders')->with('success','Cancelled order removed from history.');
    }
}
