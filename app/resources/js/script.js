
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
            // コンテンツ生成
            console.log(data);
        }).fail(function(e){
            console.log(e);
        })
    }