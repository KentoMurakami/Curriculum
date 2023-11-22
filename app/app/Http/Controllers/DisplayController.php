<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Http\Response;

use Illuminate\Support\Facades\Auth;

use App\Stock;

use App\Item;

use App\Arrival;

use App\User;

use App\Store;

class DisplayController extends Controller
{

    public function viewContent(Request $request) {
        // 検索情報取得
        $item = $request->item;
        $store_name = $request->store_name;


        /* ログインユーザの店舗情報取得 */
        $store = Auth::user()->Store()->first();
        $store_id = $store->id;

        // ログインユーザがユーザ種別確認
        $role = Auth::user()->role;

        if ( 1 == $role) {
            // 一般ユーザの場合
            if ( isset($item) ) {
                // 「商品名」で検索があった場合、該当する件数を取得
                $stock_count = Stock::where('store_id', $store_id)->where('del_flg', 1)->whereHas('item', function ($query) use ($item) {
                    $query->where('name', 'like', '%'.$item.'%');
                })->count();
                
                if ( 6 <= $stock_count ) {
                    $stock = Stock::where('store_id', $store_id)->where('del_flg', 1)->whereHas('item', function ($query) use ($item) {
                        $query->where('name', 'like', '%'.$item.'%');
                    })->take(6)->get();
                } else {
                    $stock = Stock::where('store_id', $store_id)->where('del_flg', 1)->whereHas('item', function ($query) use ($item) {
                        $query->where('name', 'like', '%'.$item.'%');
                    })->take($stock_count % 6)->get();
                }
            } else {
                // 属する店舗の在庫件数を取得
                $stock_count = Stock::where('store_id', $store_id)->where('del_flg', 1)->count();
                if (6 <= $stock_count ) {
                    $stock = Stock::with('item')->with('store')->where('store_id', $store_id)->where('del_flg', 1)->take(6)->get();
                } else {
                    $stock = Stock::with('item')->with('store')->where('store_id', $store_id)->where('del_flg', 1)->take($stock_count % 6)->get();
                }
            }
        } else {
            // 管理ユーザの場合
            if ( isset($item) && isset($store_name) ) {
                // 商品名、店舗名の検索の場合
                $result = Store::where('name', 'like', "%{$store_name}%")->select('id')->get();
                $resultArray = $result->toArray();

                // 検索に該当する在庫件数を取得
                $stock_count = Stock::where('del_flg', 1)->whereIn('store_id', $resultArray)->whereHas('item', function ($query) use ($item) {
                    $query->where('name', 'like', '%'.$item.'%');
                })->count();
                if ( 6 <= $stock_count) {
                    $stock = Stock::where('del_flg', 1)->whereIn('store_id', $resultArray)->whereHas('item', function ($query) use ($item) {
                        $query->where('name', 'like', '%'.$item.'%');
                    })->take(6)->get();
                } else {
                    $stock = Stock::where('del_flg', 1)->whereIn('store_id', $resultArray)->whereHas('item', function ($query) use ($item) {
                        $query->where('name', 'like', '%'.$item.'%');
                    })->take($stock_count % 6)->get();
                }
            } else if (isset($item) && !isset($store_name)) {
                // 商品名のみ検索の場合
                $stock_count = Stock::where('del_flg', 1)->whereHas('item', function ($query) use ($item) {
                    $query->where('name', 'like', '%'.$item.'%');
                })->count();
                if (6 <= $stock_count) {
                    $stock = Stock::where('del_flg', 1)->whereHas('item', function ($query) use ($item) {
                        $query->where('name', 'like', '%'.$item.'%');
                    })->take(6)->get();
                } else {
                    $stock = Stock::where('del_flg', 1)->whereHas('item', function ($query) use ($item) {
                        $query->where('name', 'like', '%'.$item.'%');
                    })->take($stock_count % 6)->get();
                }
            } else if (!isset($item) && isset($store_name)) {
                // 店舗名のみ検索の場合
                $stock_count = Stock::with('item')->where('del_flg', 1)->whereHas('store', function ($query) use ($store_name) {
                    $query->where('name', 'like', '%'.$store_name.'%');
                })->count();

                if ( 6 <= $stock_count) {
                    $stock = Stock::with('item')->where('del_flg', 1)->whereHas('store', function ($query) use ($store_name) {
                        $query->where('name', 'like', '%'.$store_name.'%');
                    })->take(6)->get();
                } else {
                    $stock = Stock::with('item')->where('del_flg', 1)->whereHas('store', function ($query) use ($store_name) {
                        $query->where('name', 'like', '%'.$store_name.'%');
                    })->take($stock_count % 6)->get();
                }
            } else {
                /* 初期画面、検索項目がない場合は、在庫商品を全て表示 */
                $stock_count = Stock::with(['item', 'store'])->where('del_flg', 1)->count();
                if (6 <= $stock_count ) {
                    $stock = Stock::with(['item', 'store'])->where('del_flg', 1)->take(6)->get();
                } else {
                    $stock = Stock::with(['item', 'store'])->where('del_flg', 1)->take($stock_count % 6)->get();
                }
            }
        }
        return view('stockview', [
            'stocks' => $stock,
            'store' => $store,
            'item' => $item,
            'store_name' => $store_name,
            'role' => $role
        ]);
    }


    public function getContent(Request $request) {

        // リクエストに含まれている値を代入
        $count = $request->count;
        $item = $request->item;
        $store_name = $request->store_name;

        /* ログインユーザの店舗情報取得 */
        $store = Auth::user()->Store()->first();
        $store_id = $store->id;

        // ログインユーザがユーザ種別確認
        $role = Auth::user()->role;

        // 追加で取得必要か確認
        if ( 6 <= $count ) {
            // ユーザ種別による検索結果取得
            if ( 1 == $role ) {
                // 一般ユーザの場合
                if ( isset($item) ) {
                    // 「商品名」で検索があった場合
                    $stock_count = Stock::where('store_id', $store_id)->where('del_flg', 1)->whereHas('item', function ($query) use ($item) {
                        $query->where('name', 'like', '%'.$item.'%');
                    })->count();
                    if ( $stock_count > $count ) {
                        if ( 6 >= ($stock_count - $count) ) {
                            $stock = Stock::where('store_id', $store_id)->where('del_flg', 1)->whereHas('item', function ($query) use ($item) {
                                $query->where('name', 'like', '%'.$item.'%');
                            })->skip($count)->take(6)->get();
                        } else {
                            $stock = Stock::where('store_id', $store_id)->where('del_flg', 1)->whereHas('item', function ($query) use ($item) {
                                $query->where('name', 'like', '%'.$item.'%');
                            })->skip($count)->take(($stock_count - $count) % 6)->get();
                        }
                        return response()->json($stock);
                    } else {
                        return false;
                    }
                } else {
                    // 検索がない場合
                    $stock_count = Stock::where('store_id', $store_id)->where('del_flg', 1)->count();
                    if ( $stock_count > $count ) {
                        if ( 6 >= ($stock_count - $count) ) {
                            $stock = Stock::with('item')->where('store_id', $store_id)->where('del_flg', 1)->skip($count)->take(6)->get();
                        } else {
                            $stock = Stock::with('item')->where('store_id', $store_id)->where('del_flg', 1)->skip($count)->take(($stock_count - $count) % 6)->get();
                        }
                        return response()->json($stock);
                    } else {
                        return false;
                    }         
                }
            } else {
                // 管理者ユーザの場合
                if ( isset($item) && isset($store_name) ) {
                    // 商品名、店舗名の検索の場合
                    $result = Store::where('name', 'like', "%{$store_name}%")->select('id')->get();
                    $resultArray = $result->toArray();
    
                    // 検索に該当する在庫件数を取得
                    $stock_count = Stock::where('del_flg', 1)->whereIn('store_id', $resultArray)->whereHas('item', function ($query) use ($item) {
                        $query->where('name', 'like', '%'.$item.'%');
                    })->count();
                    if ( $stock_count > $count ) {
                        if ( 6 <= ($stock_count - $count) ) {
                            $stock = Stock::where('del_flg', 1)->whereIn('store_id', $resultArray)->whereHas('item', function ($query) use ($item) {
                                $query->where('name', 'like', '%'.$item.'%');
                            })->skip($count)->take(6)->get();
                        } else {
                            $stock = Stock::where('del_flg', 1)->whereIn('store_id', $resultArray)->whereHas('item', function ($query) use ($item) {
                                $query->where('name', 'like', '%'.$item.'%');
                            })->skip($count)->take(($stock_count - $count) % 6)->get();
                        }
                        return response()->json($stock);
                    } else {
                        return false;
                    }
                } else if (isset($item) && !isset($store_name)) {
                    // 商品名のみ検索の場合
                    $stock_count = Stock::where('del_flg', 1)->whereHas('item', function ($query) use ($item) {
                        $query->where('name', 'like', '%'.$item.'%');
                    })->count();
                    if ( $stock_count > $count ) {
                        if (6 <= ($stock_count - $count)) {
                            $stock = Stock::where('del_flg', 1)->whereHas('item', function ($query) use ($item) {
                                $query->where('name', 'like', '%'.$item.'%');
                            })->skip($count)->take(6)->get();
                        } else {
                            $stock = Stock::where('del_flg', 1)->whereHas('item', function ($query) use ($item) {
                                $query->where('name', 'like', '%'.$item.'%');
                            })->skip($count)->take(($stock_count - $count) % 6)->get();
                        }
                        return response()->json($stock);
                    } else {
                        return false;
                    } 
                } else if (!isset($item) && isset($store_name)) {
                    // 店舗名のみ検索の場合
                    $stock_count = Stock::with('item')->where('del_flg', 1)->whereHas('store', function ($query) use ($store_name) {
                        $query->where('name', 'like', '%'.$store_name.'%');
                    })->count();
    
                    if ( $stock_count > $count ) {
                        if (6 <= ($stock_count - $count)) {
                            $stock = Stock::with('item')->where('del_flg', 1)->whereHas('store', function ($query) use ($store_name) {
                                $query->where('name', 'like', '%'.$store_name.'%');
                            })->skip($count)->take(6)->get();
                        } else {
                            $stock = Stock::with('item')->where('del_flg', 1)->whereHas('store', function ($query) use ($store_name) {
                                $query->where('name', 'like', '%'.$store_name.'%');
                            })->skip($count)->take(($stock_count - $count) % 6)->get();
                        }
                        return response()->json($stock);
                    } else {
                        return false;
                    }
                } else {
                    /* 検索項目がない場合は、在庫商品を全て表示 */
                    $stock_count = Stock::with(['item', 'store'])->where('del_flg', 1)->count();
                    if ( $stock_count > $count ) {
                        if (6 <= ($stock_count - $count)) {
                            $stock = Stock::with(['item', 'store'])->where('del_flg', 1)->skip($count)->take(6)->get();
                        } else {
                            $stock = Stock::with(['item', 'store'])->where('del_flg', 1)->skip($count)->take(($stock_count - $count) % 6)->get();
                        }
                        return response()->json($stock);
                    } else {
                        return false;
                    }
                }
            }
        }
    }



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

        $stores = Store::get();

        // ログインユーザがユーザ種別確認
        $role = Auth::user()->role;
        if (1 == $role) {
            return redirect()->route('home', ['role' => $role]);
        } else {
            return view('registeruser', [
                'stores' => $stores,
            ]);
        }
    }

    public function registerItemForm() {

        // ログインユーザがユーザ種別確認
        $role = Auth::user()->role;
        if (1 == $role) {
            return redirect()->route('home', ['role' => $role]);
        } else {
            return view('registeritem');
        }
    }

    public function registerArrivalForm() {

        $items = Item::get();

        return view('registerarrival', [
            'items' => $items,
        ]);
    }
}
