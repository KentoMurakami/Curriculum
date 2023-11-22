@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <p class="text-center">商品登録</p>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('register.item.form') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">商品名</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control " name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @if($errors->has('name'))
                                <div class='alert alert-danger'>
                                    @error('name')
                                        <li>{{$message}}</li>
                                    @enderror
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="img" class="col-md-4 col-form-label text-md-right">画像</label>

                            <div class="col-md-6">
                                <input id="img" type="file" class="form-control " name="img" value="{{ old('img') }}" required autocomplete="img">
                                @if($errors->has('img'))
                                <div class='alert alert-danger'>
                                    @error('img')
                                        <li>{{$message}}</li>
                                    @enderror
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">重量</label>

                            <div class="col-md-6">
                                <input id="weight" type="number" class="form-control " name="weight" value="{{ old('weight') }}" required autocomplete="weight">
                                @if($errors->has('weight'))
                                <div class='alert alert-danger'>
                                    @error('weight')
                                        <li>{{$message}}</li>
                                    @enderror
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
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
