<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// use App\Http\Controllers\Auth;

// use Image;

use App\Http\Requests\CreateUserData;

use App\Http\Requests\CreateItemData;

use Illuminate\Support\Facades\Auth;

use App\Item;

use App\User;

use App\Arrival;

use App\Stock;

use Illuminate\Support\Facades\Hash;

class RegistrationController extends Controller
{

    public function registerUser(CreateUserData $request) {

        $user = new User;

        $request->password = Hash::make($request->password);
        
        $columns = ['name', 'email', 'password', 'store_id'];

        foreach($columns as $column) {
            $user->$column = $request->$column;
        }

        $user->save();

        return redirect('/home');
    }
    
    public function registerItem(CreateItemData $request) {

        $item = new Item;

        // ディレクトリ名
        $dir = 'sample';

        // アップロードされたファイル名を取得
        $file_name = $request->file('img')->getClientOriginalName();
        
        // 取得したファイル名で保存
        $request->file('img')->storeAs('public/' . $dir, $file_name);

        // InterventionImage::make($file)->resize(1080, 700)->save(public_path('/images/' . $filename ) );;

        // Image::make($request->file('img'))->resize(1080, 700)->storeAs('public/' . $dir, $file_name);


        $item->img = 'storage/' . $dir . '/' . $file_name;

        
        $columns = ['name', 'weight'];

        foreach($columns as $column) {
            $item->$column = $request->$column;
        }

        $item->save();

        return redirect('/home');
    }

    public function registerArrival(Request $request) {

        $arrival = new Arrival;
        
        $columns = ['item_id', 'arrivaled_at', 'amount', 'weight'];

        foreach($columns as $column) {
            $arrival->$column = $request->$column;
        }

        $arrival->store_id = Auth::user()->store_id;

        $arrival->save();

        return redirect('/arrivalmenu');
    }

    public function decisionArrival(Arrival $arrival) {

        $stock = new Stock;

        $columns = ['item_id', 'amount', 'weight', 'store_id'];

        
        if ( Stock::where('item_id', $arrival->item_id)->where('store_id', $arrival->store_id)->exists() ) {
            // 入荷する商品が在庫にある場合
            $stock = Stock::where('item_id', $arrival->item_id)->where('store_id', $arrival->store_id)->first();

            $stock->amount = $stock->amount + $arrival->amount;
            $stock->weight = $stock->weight + $arrival->weight;

            $stock->save();

            $arrival->delete();

            return redirect('/arrivalmenu');
        } else {
            // 入荷する商品が在庫にない場合
            
            foreach($columns as $column) {
                $stock->$column = $arrival->$column;
            }

            $stock->del_flg = 1;

            $stock->save();

            $arrival->delete();

            return redirect('/arrivalmenu');
        }
    }

    public function deleteStock(Stock $stock) {

        $stock->del_flg = 0;

        $stock->save();

            // return redirect('/stockmenu');
            return redirect('/stockview');
    }
}
