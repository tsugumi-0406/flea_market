@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/address.css') }}">
@endsection

@section('content')
    <div class="main-inner">
        <h1 class="main-title">
            住所の変更
        </h1>
        <form action="" class="main-form">
            <label for="" class="main-form__label">郵便番号</label>
            <input type="text" class="main-form__input">
            <div class="main-form__error">
            @error('name')
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