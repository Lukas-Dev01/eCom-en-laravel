<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cart;
use App\Models\Order;
use Session;
class UserController extends Controller
{
    //
    function login(Request $req)
    {
        $req->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where(['email'=>$req->email])->first();
        if (!$user || !Hash::check($req->password,$user->password))
    {
        return back()
            ->withInput($req->only('email'))
            ->withErrors(['email' => 'The email or password is incorrect.']);
    }
    else {
        $req->session()->put('user',$user);
        foreach($req->session()->get('cart', []) as $productId)
        {
            $cart = new Cart;
            $cart->user_id = $user->id;
            $cart->product_id = $productId;
            $cart->save();
        }
        $req->session()->forget('cart');
        return redirect('/');
        }
    }
    function register(Request $req)
    {
        $req->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
        ]);

        $user = new User;
        $user->name=$req->name;
        $user->email=$req->email;
        $user->password=Hash::make($req->password);
        $user->save();
        return redirect('/login');
    }

    function profile()
    {
        if(!Session::has('user')) {
            return redirect('/login');
        }

        $user=Session::get('user');
        $orderCount=Order::where('user_id',$user['id'])->count();

        return view('profile',[
            'user'=>$user,
            'orderCount'=>$orderCount,
        ]);
    }

    function addresses()
    {
        if(!Session::has('user')) {
            return redirect('/login');
        }

        $user=Session::get('user');
        $sessionKey='saved_addresses_'.$user['id'];
        $savedAddresses=collect(Session::get($sessionKey, []))->map(function ($address) {
            $address['id'] = $address['id'] ?? uniqid('addr_', true);
            $address['source'] = 'saved';

            return $address;
        })->values();

        Session::put($sessionKey, $savedAddresses->all());

        return view('addresses',[
            'user'=>$user,
            'addresses'=>$savedAddresses,
        ]);
    }

    function saveAddress(Request $req)
    {
        if(!Session::has('user')) {
            return redirect('/login');
        }

        $req->validate([
            'label' => 'required|string|max:40',
            'street' => 'required|string|max:120',
            'apartment' => 'nullable|string|max:80',
            'city' => 'required|string|max:80',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:80',
            'phone' => 'nullable|string|max:30',
        ]);

        $user=Session::get('user');
        $sessionKey='saved_addresses_'.$user['id'];
        $addresses=Session::get($sessionKey, []);

        array_unshift($addresses, [
            'id' => uniqid('addr_', true),
            'source' => 'saved',
            'label' => $req->label,
            'name' => $user['name'],
            'street' => $req->street,
            'apartment' => $req->apartment,
            'city' => $req->city,
            'postal_code' => $req->postal_code,
            'country' => $req->country,
            'phone' => $req->phone,
        ]);

        Session::put($sessionKey, array_slice($addresses, 0, 6));

        return redirect('/addresses')->with('address_saved', 'Address saved.');
    }

    function updateAddress(Request $req)
    {
        if(!Session::has('user')) {
            return redirect('/login');
        }

        $req->validate([
            'address_id' => 'required|string',
            'label' => 'required|string|max:40',
            'street' => 'required|string|max:120',
            'apartment' => 'nullable|string|max:80',
            'city' => 'required|string|max:80',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:80',
            'phone' => 'nullable|string|max:30',
        ]);

        $user=Session::get('user');
        $sessionKey='saved_addresses_'.$user['id'];
        $addresses=collect(Session::get($sessionKey, []))->map(function ($address) use ($req, $user) {
            if(($address['id'] ?? null) !== $req->address_id) {
                return $address;
            }

            return [
                'id' => $req->address_id,
                'source' => 'saved',
                'label' => $req->label,
                'name' => $user['name'],
                'street' => $req->street,
                'apartment' => $req->apartment,
                'city' => $req->city,
                'postal_code' => $req->postal_code,
                'country' => $req->country,
                'phone' => $req->phone,
            ];
        })->values()->all();

        Session::put($sessionKey, $addresses);

        return redirect('/addresses')->with('address_saved', 'Address updated.');
    }

    function deleteAddress(Request $req)
    {
        if(!Session::has('user')) {
            return redirect('/login');
        }

        $req->validate([
            'address_id' => 'required|string',
        ]);

        $user=Session::get('user');
        $sessionKey='saved_addresses_'.$user['id'];
        $addresses=collect(Session::get($sessionKey, []))->filter(function ($address) use ($req) {
            return ($address['id'] ?? null) !== $req->address_id;
        })->values()->all();

        Session::put($sessionKey, $addresses);

        return redirect('/addresses')->with('address_saved', 'Address removed.');
    }
}
