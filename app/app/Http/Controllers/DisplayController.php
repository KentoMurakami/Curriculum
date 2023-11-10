<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Stock;

use App\Item;

use App\Arrival;

use App\User;

use App\Store;



class DisplayController extends Controller
{
    public function stockMenu(Request $request) {


        // 検索情報取得
        $item = $request->item;
        $store_name = $request->store_name;

        /* ログインユーザの店舗情報取得 */
        $store = Auth::user()->Store()->first();
        $store_id = $store->id;

        // ログインユーザがユーザ種別確認
        $role = Auth::user()->role;

        
        if ( $role == 1 ) {
            // 一般ユーザの場合
            if ( isset($item) ) {
                // 属する店舗の内、検索に該当する在庫を表示
                $stock = Stock::where('store_id', $store_id)->where('del_flg', 1)->whereHas('item', function ($query) use ($item) {
                    $query->where('name', 'like', '%'.$item.'%');
                })->get();
            } else {
                // 属する店舗の在庫を表示
                $stock = Stock::with('item')->where('store_id', $store_id)->where('del_flg', 1)->get();
            }
        } else {
            // 管理者ユーザの場合
            if ( isset($item) && isset($store_name) ) {
                // 商品名、店舗名の検索の場合
                $result = Store::where('name', 'like', "%{$store_name}%")->select('id')->get();
                $resultArray = $result->toArray();


                $stock = Stock::where('del_flg', 1)->whereIn('store_id', $resultArray)->whereHas('item', function ($query) use ($item) {
                    $query->where('name', 'like', '%'.$item.'%');
                })->get();

            } else if (isset($item) && !isset($store_name)) {
                // 商品名のみ検索の場合
                $stock = Stock::where('del_flg', 1)->whereHas('item', function ($query) use ($item) {
                    $query->where('name', 'like', '%'.$item.'%');
                })->get();
            } else if (!isset($item) && isset($store_name)) {
                // 店舗名のみ検索の場合
                $stock = Stock::with('item')->where('del_flg', 1)->whereHas('store', function ($query) use ($store_name) {
                    $query->where('name', 'like', '%'.$store_name.'%');
                })->get();
            } else {
                /* 初期画面、検索項目がない場合は、在庫商品を全て表示 */
                $stock = Stock::with(['item', 'store'])->where('del_flg', 1)->get();
            }

        }
              

        return view('stockmenu', [
            'stocks' => $stock,
            'store' => $store,
            'item' => $item,
            'store_name' => $store_name,
            'role' => $role
        ]);
    }

    public function arrivalMenu(Request $request) {

        $item = $request->item;
        $date = $request->date;

        /* ログインユーザの店舗情報取得 */
        $store = Auth::user()->Store()->first();
        $store_id = $store->id;
        
        if ( (isset($item) && isset($date))) { 
            /* 商品名、入荷予定日の検索の場合 */
            $arrival = Arrival::where('store_id', $store_id)->whereHas('item', function ($query) use ($request) {
                $query->where('name', 'like', '%'.$request->item.'%')->where('arrivaled_at', '>=', $request->date);
            })->get();
        } else if( isset($item) && !isset($date) ) {
            /* 商品名のみ検索の場合 */
            $arrival = Arrival::where('store_id', $store_id)->whereHas('item', function ($query) use ($item) {
                $query->where('name', 'like', '%'.$item.'%');
            })->get();
        } else if( !isset($item) && isset($date) ) {
            /* 入荷予定日のみ検索の場合 */
            $arrival = Arrival::with('item')->where('store_id', $store_id)->where('arrivaled_at', '>=', $date)->get();
        } else {
            /* 初期画面、検索項目がない場合は、入荷予定商品を全て表示 */
            $arrival = Arrival::with('item')->where('store_id', $store_id)->get();
        }

        return view('arrivalmenu', [
            'arrivals' => $arrival,
            'store' => $store,
            'item' => $item,
            'date' => $date
        ]);
    }

    public function registerUserForm() {

        return view('registeruser');
    }

    public function registerItemForm() {

        return view('registeritem');
    }

    public function registerArrivalForm() {

        $items = Item::get();

        return view('registerarrival', [
            'items' => $items,
        ]);
    }
}
