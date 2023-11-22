@extends('layouts.app')

@section('content')
<div class="container">
    <p class="text-center h1" style="margin:2vh 0vw 5vh 0vw;">⚫️メインメニュー</p>
    <div class="d-flex justify-content-center" style="margin: 0vh 0vw 5vh 5vw;">
        <!-- <div class="col-md-6">
            <a href="{{ route('stock.menu') }}" class="btn btn-info" style="width: 25vw; height: 30vh; font-size: 3vw; padding: 7vh 0vw;">在庫管理</a>
        </div> -->
        <div class="col-md-6">
            <a href="{{ route('view.stock') }}" class="btn btn-info" style="width: 25vw; height: 23vh; font-size: 3vw; padding: 7vh 0vw;">在庫管理</a>
        </div>
        <div class="col-md-6" style="height: 200px">
            <a href="{{ route('arrival.menu') }}" class="btn btn-info" style="width: 25vw; height: 23vh; font-size: 3vw; padding: 7vh 0vw;">入荷管理</a>
        </div>
    </div>

    <p class="text-center  h1" style="margin:0vh 0vw 7vh 0vw;">⚫️管理者メニュー</p>
    @if($role === 1) 
    <div class="d-flex justify-content-center" style="margin: 0vh 0vw 0vh 5vw;">
        <div class="col-md-6">
            <a href="#" class="btn btn-dark" style="width: 25vw; height: 23vh; font-size: 3vw; padding: 7vh 0vw;">社員登録</a>
        </div>
        <div class="col-md-6">
            <a href="#" class="btn btn-dark" style="width: 25vw; height: 23vh; font-size: 3vw; padding: 7vh 0vw;">商品登録</a>
        </div>
    </div>
    @else
    <div class="d-flex justify-content-center" style="margin: 0vh 0vw 0vh 5vw;">
        <div class="col-md-6">
            <a href="{{ route('register.user.form') }}" class="btn btn-dark" style="width: 25vw; height: 23vh; font-size: 3vw; padding: 7vh 0vw;">社員登録</a>
        </div>
        <div class="col-md-6">
            <a href="{{ route('register.item.form') }}" class="btn btn-dark" style="width: 25vw; height: 23vh; font-size: 3vw; padding: 7vh 0vw;">商品登録</a>
        </div>
    </div>
    @endif
</div>
@endsection


