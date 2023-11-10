@extends('layouts.app')

@section('content')
<div class="container">
    <p class="text-center h1">在庫管理</p>

    @if($role === 1)
    <!--  一般ユーザの管理画面 -->
            <!-- 店名、新規入荷登録ボタン -->
        <div class="d-flex justify-content-center">
            <div class="col-md-12">
                <p class="text-center h2">{{ $store->name }}店</p>
            </div>
        </div>
        <!-- 検索機能 -->
        <div class="col-md-9">
            <form class="form-inline">
                @csrf
                <label for="item_name">商品名</label>
                <input type="text" name="item" class="form-control mb-2 mr-sm-2" id="item_name" placeholder="商品名" value="{{ $item }}">

                <label for="date">店舗名</label>
                <input type="text" name="store_name"  class="form-control mb-2 mr-sm-2" id="store_name" placeholder="店舗名" value="{{ $store_name }}">

                <button type="submit" class="btn btn-primary mb-2">検索</button>
            </form>
        </div>

        <!-- 在庫表示(テーブル) -->
        <div class="shop-container">
            <div class="item-container">
                <div class="row">
                    @foreach ($stocks as $stock)
                    <div class="col-lg-4 col-md-6">
                        <div class="card">
                            <img src="{{ asset($stock->item->img) }}" alt="" class="card-img"/>
                            <div class="card-body">
                                <p class="card-title">商品名：{{ $stock->item->name }}</p>
                                <p class="card-text">数量：{{ number_format($stock->amount) }} </p>
                                <p class="card-text">重量：{{ number_format($stock->weight) }} </p>
                            </div>
                            <a href="{{ route('delete.stock', ['id'=>$stock->id]) }}">削除</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    @else
        <!--  管理者ユーザの管理画面 -->
        <!-- 検索機能 -->
        <div class="col-md-9">
            <form class="form-inline">
                @csrf
                <label for="item_name">商品名</label>
                <input type="text" name="item" class="form-control mb-2 mr-sm-2" id="item_name" placeholder="商品名" value="{{ $item }}">

                <label for="date">店舗名</label>
                <input type="text" name="store_name"  class="form-control mb-2 mr-sm-2" id="store_name" placeholder="店舗名" value="{{ $store_name }}">

                <button type="submit" class="btn btn-primary mb-2">検索</button>
            </form>
        </div>

        <!-- 在庫表示(テーブル) -->
        <div class="shop-container">
            <h1></h1>
            <div class="item-container">
                <div class="row">
                    @foreach ($stocks as $stock)
                    <div class="col-lg-4 col-md-6">
                        <div class="card">
                            <img src="{{ asset($stock->item->img) }}" alt="" class="card-img"/>
                            <div class="card-body">
                                <p class="card-title">商品名：{{ $stock->item->name }}</p>
                                <p class="card-text">数量：{{ number_format($stock->amount) }} </p>
                                <p class="card-text">重量：{{ number_format($stock->weight) }} </p>
                            </div>
                            @if( $store->id == $stock->store_id)
                            <a href="{{ route('delete.stock', ['id'=>$stock->id]) }}">削除</a>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

    @endif

</div>
@endsection
