@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
    <div class="main-inner">
        <h1 class="main-title">
            プロフィール設定
        </h1>
        <form action="" class="main-form" method="post">
            @csrf
            <div class="main-form__image">
                <p>アイコン画像</p>
                <input type="file" name="image" accept="image/*" hidden id="imageInput">
                <button type="button" class="form__input-image" onclick="document.getElementById('imageInput').click();">
                    画像を選択する
                </button>
            </div>
            <label for="" class="main-form__label">ユーザー名</label>
            <input type="text" class="main-form__input">
            <div class="main-form__error">
            @error('name')
                {{ $errors->first('name') }}
            @enderror
            </div>
            <label for="" class="main-form__label">郵便番号</label>
            <input type="text" class="main-form__input">
            <div class="main-form__error">
            @error('post_code')
                {{ $errors->first('post_code') }}
            @enderror
            </div>
            <label for="" class="main-form__label"> 住所</label>
            <input type="text" class="main-form__input">
            <div class="main-form__error">
            @error('name')
                {{ $errors->first('address') }}
            @enderror
            </div>
            <label for="" class="main-form__label"> 建物名</label>
            <input type="text" class="main-form__input">
            <div class="main-form__error">
            @error('name')
                {{ $errors->first('build') }}
            @enderror
            </div>
            <input type="submit" class="main-dorm__submit" value="更新する">
            </form>
        </div>
@endsection