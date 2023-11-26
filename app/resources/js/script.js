
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

        var role = $('#role').val();

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
                if ( 1 == role ) {
                    $("#content").append(
                        `<div class="col-lg-4 col-md-6 count" style="margin:0vh 0vw 5vh 0vw;">
                            <div class="card">
                                <img src="${data[i]["item"]["img"]}" class="card-img" style="height: 30vh;">
                                <div class="card-body">
                                    <p class="card-title">商品名：${data[i]["item"]["name"]}</p>
                                    <p class="card-text">数量：${data[i]["amount"]}</p>
                                    <p class="card-text">重量：${data[i]["weight"]}</p>
                                </div>
                            </div>
                        </div>`
                    );
                } else {
                    if ( 1 == data[i]["store_id"] ) {
                        $("#content1").append(
                        `<div class="col-lg-4 col-md-6 count" style="margin:0vh 0vw 5vh 0vw;">
                            <div class="card">
                                <img src="${data[i]["item"]["img"]}" class="card-img" style="height: 30vh;">
                                <div class="card-body">
                                    <p class="card-title">商品名：${data[i]["item"]["name"]}</p>
                                    <p class="card-text">数量：${data[i]["amount"]}</p>
                                    <p class="card-text">重量：${data[i]["weight"]}</p>
                                </div>
                            </div>
                            <a href="/stockview${data[i]["id"]}" style="margin:0vh 0vw 0vh 11vw;">削除</a>
                        </div>`
                    );
                    } else if (2 == data[i]["store_id"]) {
                        $(".store2_name").css("display", "block");
                        $("#content2").append(
                            `<div class="col-lg-4 col-md-6 count" style="margin:0vh 0vw 5vh 0vw;">
                                <div class="card">
                                    <img src="${data[i]["item"]["img"]}" class="card-img" style="height: 30vh;">
                                    <div class="card-body">
                                        <p class="card-title">商品名：${data[i]["item"]["name"]}</p>
                                        <p class="card-text">数量：${data[i]["amount"]}</p>
                                        <p class="card-text">重量：${data[i]["weight"]}</p>
                                    </div>
                                </div>
                            </div>`
                        );
                    } else {
                        $(".store3_name").css("display", "block");
                        $("#content3").append(
                            `<div class="col-lg-4 col-md-6 count" style="margin:0vh 0vw 5vh 0vw;">
                                <div class="card">
                                    <img src="${data[i]["item"]["img"]}" class="card-img" style="height: 30vh;">
                                    <div class="card-body">
                                        <p class="card-title">商品名：${data[i]["item"]["name"]}</p>
                                        <p class="card-text">数量：${data[i]["amount"]}</p>
                                        <p class="card-text">重量：${data[i]["weight"]}</p>
                                    </div>
                                </div>
                            </div>`
                        );
                    }  
                }
            }

        }).fail(function(e){
            console.log(e);
        })
    }
});