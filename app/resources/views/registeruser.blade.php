@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <p class="text-center">社員登録</p>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register.user.form') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">名前</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

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
                            <label for="email" class="col-md-4 col-form-label text-md-right">メールアドレス</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @if($errors->has('email'))
                                <div class='alert alert-danger'>
                                    @error('email')
                                        <li>{{$message}}</li>
                                    @enderror
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">パスワード</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="password">

                                @if($errors->has('password'))
                                <div class='alert alert-danger'>
                                    @error('password')
                                        <li>{{$message}}</li>
                                    @enderror
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">パスワード(確認用)</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div> -->

                        <div class="form-group row">
                            <label for="store_id" class="col-md-4 col-form-label text-md-right">店舗</label>
                            <div class="col-md-6">
                                <select name='store_id' class='form-control'  required autocomplete="store_id">
                                    <option value='' hidden>店舗名</option>
                                    @foreach($stores as $store)
                                    <option value="{{ $store['id']}}">{{ $store['name'] }}</option>
                                    @endforeach
                                </select>
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
