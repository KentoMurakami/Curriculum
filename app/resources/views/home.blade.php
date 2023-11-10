@extends('layouts.app')

@section('content')
<div class="container">
    <p class="text-center h1">⚫️メインメニュー</p>
    <div class="d-flex justify-content-center">
        <div class="col-md-6" style="height: 200px">
            <a href="{{ route('stock.menu') }}" class="btn btn-info w-50 h-50">在庫管理</a>
        </div>
        <div class="col-md-6" style="height: 200px">
            <a href="{{ route('arrival.menu') }}" class="btn btn-info w-50 h-50">入荷管理</a>
        </div>
    </div>

    <p class="text-center  h1">⚫️管理者メニュー</p>
    <div class="d-flex justify-content-center">
        <div class="col-md-6" style="height: 200px">
            <a href="{{ route('register.user.form') }}" class="btn btn-dark w-50 h-50">社員登録</a>
        </div>
        <div class="col-md-6" style="height: 200px">
            <a href="{{ route('register.item.form') }}" class="btn btn-dark w-50 h-50">商品登録</a>
        </div>
    </div>
</div>
@endsection


