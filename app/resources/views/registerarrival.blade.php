@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <p class="text-center h1">入荷情報登録</p>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register.arrival.form') }}">
                        @csrf
                        <div class="form-group row">
                            <label for='item' class="col-md-4 col-form-label text-md-right">商品名</label>
                            <div class="col-md-6">
                                <select name='item_id' class='form-control' required autocomplete="store_id">
                                    <option value='' hidden>商品名</option>
                                    @foreach($items as $item)
                                    <option value="{{ $item['id']}}">{{ $item['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="arrivaled_at" class="col-md-4 col-form-label text-md-right">入荷予定日</label>

                            <div class="col-md-6">
                                <input id="arrivaled_at" type="date" class="form-control @error('arrivaled_at') is-invalid @enderror" name="arrivaled_at" value="{{ old('arrivaled_at') }}" required autocomplete="arrivaled_at">

                                @error('arrivaled_at')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="amount" class="col-md-4 col-form-label text-md-right">数量</label>

                            <div class="col-md-6">
                                <input id="amount" type="number" class="form-control @error('amount') is-invalid @enderror" name="amount" value="{{ old('amount') }}" required autocomplete="amount">

                                @error('amount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary" style="margin: 0vh 0vw 0vh 7vw;">
                                    登録
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
