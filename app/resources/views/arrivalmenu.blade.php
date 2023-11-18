@extends('layouts.app')

@section('content')
<div class="container">
    <p class="text-center h1">入荷管理</p>

    <!-- 店名、新規入荷登録ボタン -->
    <div class="d-flex justify-content-center">
        <div class="col-md-8">
            <p class="text-center h2">{{ $store->name }}店</p>
        </div>
        <div>
            <a href="{{ route('register.arrival.form') }}" class="btn btn-dark">新規入荷登録</a>
        </div>
    </div>



    <!-- 検索機能 -->
    <div class="col-md-9">
        <form class="form-inline">
            @csrf
            <label for="item_name">商品名</label>
            <input type="text" name="item" class="form-control mb-2 mr-sm-2" id="item_name" placeholder="商品名" value="{{ $item }}">

            <label for="date">入荷予定日</label>
            <input type="date" name="date"  class="form-control mb-2 mr-sm-2" id="date" value="{{ $date }}">

            <button type="submit" class="btn btn-primary mb-2">検索</button>
        </form>
    </div>

    <!-- 在庫表示(テーブル) -->
    <div class="shop-container">
        <div class="item-container">
            <div class="row">
                @foreach ($arrivals as $arrival)
                <div class="col-lg-4 col-md-6">
                    <div class="card">
                        <img src="{{ asset($arrival->item->img) }}" alt="" class="card-img" style="height: 30vh;"/>
                        <div class="card-body">
                            <p class="card-title">商品名：{{ $arrival->item->name }}</p>
                            <p class="card-text">数量：{{ number_format($arrival->amount) }} </p>
                            <p class="card-text">重量：{{ number_format($arrival->weight) }} </p>
                        </div>
                        
                    </div>
                    <a href="{{ route('decision.arrival', ['id'=>$arrival->id]) }}">確定</a>
                </div>
                @endforeach
            </div>

        </div>

    </div>

</div>
@endsection
