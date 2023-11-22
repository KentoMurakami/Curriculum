
// スクロールされた時に実行
$(window).on("scroll", function () {
        // スクロール位置
        var document_h = $(document).height();              
        var window_h = $(window).height() + $(window).scrollTop();    
        var scroll_pos = (document_h - window_h) / document_h ;   
            
        // 画面最下部にスクロールされている場合
        if (scroll_pos <= 1) {

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
        var count = $("#count").val();
         
        // ajax処理
        $.post({
            type: "post",
            datatype: "json",
            url: "/contentview",
            data:{ count : count },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        }).done(function(data){
                // ニュースを表示
            for (var i=0; i<data.length; i++) {
                $("#content").append(
                    `<div class="col-lg-4 col-md-6">
                        <div class="card">
                            <img src="${data[i]["item"]["img"]}" class="card-img" style="height: 30vh;">
                            <div class="card-body">
                                <p class="card-title">商品名：${data[i]["item"]["name"]}</p>
                                <p class="card-text">数量：${data[i]["amount"]}</p>
                                <p class="card-text">重量：${data[i]["weight"]}</p>
                            </div>
                        </div>
                        <a href="/contentview${data[i]["id"]}">削除</a>
                    </div>`
                );
            }
            // 取得件数を加算してセット
            count += data.length
            console.log(count);
            $("#count").val(count);



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