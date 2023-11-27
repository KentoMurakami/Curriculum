@extends('layouts.app')

@section('content')
<div class="container">
    <p class="text-center h1" style="margin:2vh 0vw 5vh 0vw;">在庫管理</p>

    <!--  一般ユーザの管理画面 -->
    @if($role === 1)   
        <!-- 検索機能 -->
        <div class="col-md-12" style="margin:0vh 0vw 4vh 0vw;">
            <form class="form-inline" style="margin:0vh 0vw 0vh 15vw;">
                @csrf
                <label for="item_name">商品名</label>
                <input type="text" name="item" class="form-control mb-2 mr-sm-2" style="width:20vw;" id="item" placeholder="商品名" value="{{ $item }}">
                
                <button type="submit" class="btn btn-primary mb-2" style="margin:0vh 0vw 0vh 3vw; width:6vw;">検索</button>
            </form>
        </div>
        <input type="hidden" id="role" value="{{ $role }}" />
        <input type="hidden" id="store_id" value="{{ $store->id }}" />

        <div class="d-flex justify-content-center">
            <div class="col-md-12">
                <p class="text-center h2" style="margin:3vh 0vw 5vh 0vw;">{{ $store->name }}店</p>
            </div>
        </div>
        <div class="shop-container">
            <div class="item-container">
                <div class="row" id="content">
                    @foreach ($stocks as $stock)
                    <div class="col-lg-4 col-md-6 count" style="margin:0vh 0vw 5vh 0vw;">
                        <div class="card">
                            <img src="{{ asset($stock->item->img) }}" alt="" class="card-img" style="height: 30vh;"/>
                            <div class="card-body">
                                <p class="card-title">商品名：{{ $stock->item->name }}</p>
                                <p class="card-text">数量：{{ number_format($stock->amount) }} </p>
                                <p class="card-text">重量：{{ number_format($stock->weight) }} </p>
                            </div>
                        </div>
                        <a href="{{ route('delete.stock', ['stock'=>$stock->id]) }}" style="margin:0vh 0vw 0vh 11vw;">削除</a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    @else
    <!-- 管理ユーザの管理画面 -->
    <div class="col-md-12" style="margin:0vh 0vw 5vh 0vw;">
        <form class="form-inline" style="margin:0vh 0vw 0vh 7vw;">
            @csrf
            <label for="item_name">商品名</label>
            <input type="text" name="item" class="form-control mb-2 mr-sm-2" style="width:20vw;" id="item" placeholder="商品名" value="{{ $item }}">
                    
            <label for="date" style="margin:0vh 0vw 0vh 2vw;">店舗名</label>
            <input type="text" name="store_name"  class="form-control mb-2 mr-sm-2" style="width:15vw;" id="store_name" placeholder="店舗名" value="{{ $store_name }}">
                
            <button type="submit" class="btn btn-primary mb-2" style="margin:0vh 0vw 0vh 3vw; width:6vw;">検索</button>
        </form>
    </div>
        <input type="hidden" id="store_id" value="{{ $store->id }}" />



        <div class="d-flex justify-content-center">
            <div class="col-md-12">
                @if($tokyo_stock_flg === 0)
                <p class="text-center h2" style="margin:6vh 0vw 7vh 0vw;  display: none;">東京店</p>
                @else
                <p class="text-center h2" style="margin:6vh 0vw 7vh 0vw;">東京店</p>
                @endif
            </div>
        </div>

        <div class="shop-container">
            <div class="item-container">
                <div class="row" id="content1">
                    @foreach ($stocks as $stock)
                    @if(1 == $stock->store_id)
                    <div class="col-lg-4 col-md-6 count" style="margin:0vh 0vw 5vh 0vw;">
                        <div class="card">
                            <img src="{{ asset($stock->item->img) }}" alt="" class="card-img" style="height: 30vh;"/>
                            <div class="card-body">
                                <p class="card-title">商品名：{{ $stock->item->name }}</p>
                                <p class="card-text">数量：{{ number_format($stock->amount) }} </p>
                                <p class="card-text">重量：{{ number_format($stock->weight) }} </p>
                            </div>
                        </div>
                        @if( $store->id == $stock->store_id)
                            <a href="{{ route('delete.stock', ['stock'=>$stock->id]) }}" style="margin:0vh 0vw 0vh 11vw;">削除</a>
                        @endif
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>

        <!-- もし初期画面の段階で、表示が0だったら非表示 -->
        <div class="d-flex justify-content-center">
            <div class="col-md-12">
                @if($osaka_stock_flg === 0)
                <p class="text-center h2  store2_name" style="margin:8vh 0vw 7vh 0vw; display: none;">大阪店</p>
                @else
                <p class="text-center h2  store2_name" style="margin:8vh 0vw 7vh 0vw; display: block;">大阪店</p>
                @endif
            </div>
        </div>

        <div class="shop-container">
            <div class="item-container">
                <div class="row" id="content2">
                @foreach ($stocks as $stock)
                    @if(2 == $stock->store_id)
                    <div class="col-lg-4 col-md-6 count" style="margin:0vh 0vw 5vh 0vw;">
                        <div class="card">
                            <img src="{{ asset($stock->item->img) }}" alt="" class="card-img" style="height: 30vh;"/>
                            <div class="card-body">
                                <p class="card-title">商品名：{{ $stock->item->name }}</p>
                                <p class="card-text">数量：{{ number_format($stock->amount) }} </p>
                                <p class="card-text">重量：{{ number_format($stock->weight) }} </p>
                            </div>
                        </div>
                        @if( $store->id == $stock->store_id)
                            <a href="{{ route('delete.stock', ['stock'=>$stock->id]) }}" style="margin:0vh 0vw 0vh 11vw;">削除</a>
                        @endif
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>


        <div class="d-flex justify-content-center">
            <div class="col-md-12">
                @if($hyogo_stock_flg === 0)
                <p class="text-center h2 store3_name" style="margin:8vh 0vw 7vh 0vw; display: none;">兵庫店</p>
                @else
                <p class="text-center h2 store3_name" style="margin:8vh 0vw 7vh 0vw;">兵庫店</p>
                @endif
            </div>
        </div>

        <div class="shop-container">
            <div class="item-container">
                <div class="row" id="content3">
                @foreach ($stocks as $stock)
                    @if(3 == $stock->store_id)
                    <div class="col-lg-4 col-md-6 count" style="margin:0vh 0vw 5vh 0vw;">
                        <div class="card">
                            <img src="{{ asset($stock->item->img) }}" alt="" class="card-img" style="height: 30vh;"/>
                            <div class="card-body">
                                <p class="card-title">商品名：{{ $stock->item->name }}</p>
                                <p class="card-text">数量：{{ number_format($stock->amount) }} </p>
                                <p class="card-text">重量：{{ number_format($stock->weight) }} </p>
                            </div>
                        </div>
                        @if( $store->id == $stock->store_id)
                            <a href="{{ route('delete.stock', ['stock'=>$stock->id]) }}" style="margin:0vh 0vw 0vh 11vw;">削除</a>
                        @endif
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>

@endsection

        





