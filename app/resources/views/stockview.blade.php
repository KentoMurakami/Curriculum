@extends('layouts.app')

@section('content')
<div class="container">
    <p class="text-center h1" style="margin:2vh 0vw 4vh 0vw;">在庫管理</p>

    <!--  一般ユーザの管理画面 -->
    @if($role === 1)   
        <!-- 店名、新規入荷登録ボタン -->
        <div class="d-flex justify-content-center">
            <div class="col-md-12">
                <p class="text-center h2" style="margin:0vh 0vw 3vh 0vw;">{{ $store->name }}店</p>
            </div>
        </div>
        <!-- 検索機能 -->
        <div class="col-md-12" style="margin:0vh 0vw 4vh 0vw;">
            <form class="form-inline" style="margin:0vh 0vw 0vh 7vw;">
                @csrf
                <label for="item_name">商品名</label>
                <input type="text" name="item" class="form-control mb-2 mr-sm-2" style="width:20vw;" id="item" placeholder="商品名" value="{{ $item }}">
                    
                <label for="store_name" style="margin:0vh 0vw 0vh 2vw;">店舗名</label>
                <input type="text" name="store_name"  class="form-control mb-2 mr-sm-2" style="width:15vw;" id="store_name" placeholder="店舗名" value="{{ $store_name }}">
                
                <button type="submit" class="btn btn-primary mb-2" style="margin:0vh 0vw 0vh 3vw; width:6vw;">検索</button>
            </form>
        </div>
        <input type="hidden" id="store_id" value="{{ $store->id }}" />
        <div class="shop-container">
            <div class="item-container">
                <div class="row" id="content">
                    @foreach ($stocks as $stock)
                    <div class="col-lg-4 col-md-6 count" style="margin:0vh 0vw 3vh 0vw;">
                        <div class="card">
                            <img src="{{ asset($stock->item->img) }}" alt="" class="card-img" style="height: 30vh;"/>
                            <div class="card-body">
                                <p class="card-title">商品名：{{ $stock->item->name }}</p>
                                <p class="card-text">数量：{{ number_format($stock->amount) }} </p>
                                <p class="card-text">重量：{{ number_format($stock->weight) }} </p>
                            </div>
                        </div>
                        <a href="{{ route('delete.stock', ['id'=>$stock->id]) }}" style="margin:0vh 0vw 0vh 11vw;">削除</a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    @else
    <!-- 管理ユーザの管理画面 -->
    <div class="col-md-12" style="margin:0vh 0vw 4vh 0vw;">
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
        <div class="shop-container">
            <div class="item-container">
                <div class="row" id="content">
                    @foreach ($stocks as $stock)
                    <div class="col-lg-4 col-md-6 count" style="margin:0vh 0vw 3vh 0vw;">
                        <div class="card">
                            <img src="{{ asset($stock->item->img) }}" alt="" class="card-img" style="height: 30vh;"/>
                            <div class="card-body">
                                <p class="card-header text-center " style="width: 100%;" >{{ $stock->store->name }}店</p>
                                <p class="card-title">商品名：{{ $stock->item->name }}</p>
                                <p class="card-text">数量：{{ number_format($stock->amount) }} </p>
                                <p class="card-text">重量：{{ number_format($stock->weight) }} </p>
                            </div>
                        </div>
                        @if( $store->id == $stock->store_id)
                            <a href="{{ route('delete.stock', ['stock'=>$stock->id]) }}" style="margin:0vh 0vw 0vh 11vw;">削除</a>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>



<!-- <script src="{{ asset('/js/script.js') }}"></script> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script>
    $(function(){
    // スクロールされた時に実行
    $(window).on("scroll", function () {
        // pageBottom = [bodyの高さ] - [windowの高さ]
        var pageBottom = document.body.clientHeight - window.innerHeight;
        // スクロール量を取得
        var currentPos = window.pageYOffset;

        // スクロール量が最下部の位置を過ぎたか判定
        if (pageBottom <= currentPos) { 
            // console.log('res');
            // ajaxコンテンツ追加処理
            ajax_add_content()
        }
    });
     
    // ajaxコンテンツ追加処理
    function ajax_add_content() {
        // 追加コンテンツ
        var add_content = "";
        // コンテンツ件数           
        var count = $(".count").length;

        // 属する店舗取得
        var store_id = $('#store_id').val();

        //　検索ワード取得
        let item = $('#item').val();
        let store_name = $('#store_name').val();
        // ajax処理
        $.post({
            type: "post",
            datatype: "json",
            url: "/stockview",
            data:{ count : count, item : item, store_name : store_name },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        }).done(function(data){
                // ニュースを表示
            for (var i=0; i<data.length; i++) {
                if ( store_id == data[i]["store_id"]) {
                    $("#content").append(
                        // `<div class="col-lg-4 col-md-6" id="count">
                        `<div class="col-lg-4 col-md-6 count" style="margin:0vh 0vw 3vh 0vw;">
                            <div class="card">
                                <img src="${data[i]["item"]["img"]}" class="card-img" style="height: 30vh;">
                                <div class="card-body">
                                    <p class="card-header text-center " style="width: 100%;" >${data[i]["store"]["name"]}店</p>
                                    <p class="card-title">商品名：${data[i]["item"]["name"]}</p>
                                    <p class="card-text">数量：${data[i]["amount"]}</p>
                                    <p class="card-text">重量：${data[i]["weight"]}</p>
                                </div>
                            </div>
                            <a href="/stockview${data[i]["id"]}" style="margin:0vh 0vw 0vh 11vw;">削除</a>
                        </div>`
                    );
                } else {
                    $("#content").append(
                        // `<div class="col-lg-4 col-md-6" id="count">
                        `<div class="col-lg-4 col-md-6 count" style="margin:0vh 0vw 3vh 0vw;">
                            <div class="card">
                                <img src="${data[i]["item"]["img"]}" class="card-img" style="height: 30vh;">
                                <div class="card-body">
                                    <p class="card-header text-center " style="width: 100%;" >${data[i]["store"]["name"]}店</p>
                                    <p class="card-title">商品名：${data[i]["item"]["name"]}</p>
                                    <p class="card-text">数量：${data[i]["amount"]}</p>
                                    <p class="card-text">重量：${data[i]["weight"]}</p>
                                </div>
                            </div>
                        </div>`
                    );
                }   
            }
            // 取得件数を加算してセット
            // count += data.length
            // console.log(data.length);
            // $("#count").val(count);
            // // コンテンツ生成
            // $.each(data,function(key, val){
            //     add_content += "<div>"+val.content+"</div>";
            // })
            // // コンテンツ追加
            // $("#content").append(add_content);
            // // 取得件数を加算してセット
            // count += data.length
            // $("#count").val(count);
        }).fail(function(e){
            console.log(e);
        })
    }
});
</script>

@endsection

        





