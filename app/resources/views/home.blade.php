@extends('layouts.app')

@section('content')
<div class="container">
    <p class="text-center">⚫️メインメニュー</p>
    <div class="d-flex justify-content-center">
        <div class="col-md-6">
            <!-- <a href="{{ route('stock.menu') }}" class="btn btn-info">在庫管理</a> -->
        </div>
        <div class="col-md-6">
            <button type="button" class="btn btn-info">入荷管理</button>
        </div>
    </div>
    <!-- <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div> -->
    <p class="text-center">⚫️管理者メニュー</p>
    <div class="d-flex justify-content-center">
        <div class="col-md-6">
            <button type="button" class="btn btn-dark">社員登録</button>
        </div>
        <div class="col-md-6">
            <button type="button" class="btn btn-dark">商品登録</button>
        </div>
    </div>
</div>
@endsection
