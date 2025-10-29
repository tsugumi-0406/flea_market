    @extends('layouts.app')

    @section('css')
    <link rel="stylesheet" href="{{ asset('css/sell.css') }}">
    @endsection

    @section('content')
        <div class="main-inner">
            <h1 class="main-title">
                商品の出品
            </h1>
            <form action="/listing" method="post" class="main-form" enctype="multipart/form-data">
                @csrf
                <div class="main-form__image">
                    <h2 class="main-form__titile">商品画像</h2>
                    <div class="main-form__image-submit">
                        <input type="file" name="image" accept="image/*" hidden id="imageInput">
                        <button type="button" class="form__input-image" onclick="document.getElementById('imageInput').click();">
                        画像を選択する
                        </button>
                    </div>
                </div>
                <div class="subtitle">
                    <h3 class="subtitle__text">商品の詳細</h3>
                    <h2 class="main-form__titile">カテゴリー</h2>
                    <div class="main-form__category">
                    @foreach($categories as $category)
                        <div class="main-form__category-list">
                            <input type="checkbox"  id="{{$category->id}}" class="main-dorm__category-checkbox" name="category_id[]" value="{{$category->id}}">
                            <label class="main-form__category-label" for="{{$category->id}}">{{$category->name}}</label>
                        </div>  
                    @endforeach
                    </div>
                    <h2 class="main-form__titile">商品の状態</h2>
                    <select class="main-form__condition-select" name="condition" value="{{request('gender')}}">
                        <option disabled selected>選択してください</option>
                        <option value="1">良好</option>
                        <option value="2">目立った傷や汚れなし</option>
                        <option value="3">やや傷や汚れあり</option>
                        <option value="4">状態が悪い</option>
                    </select>
                </div>
                <div class="subtitle">
                    <h3 class="subtitle__text">商品名と説明</h3>
                </div>
                <label for="" class="main-form__label">商品名</label>
                <input type="text" class="main-form__input" name="name">
                <div class="main-form__error">
                @error('name')
                    {{ $errors->first('name') }}
                @enderror
                </div>
                <label for="" class="main-form__label">ブランド名</label>
                <input type="text" class="main-form__input" name="brand">
                <div class="main-form__error">
                @error('post_code')
                    {{ $errors->first('post_code') }}
                @enderror
                </div>
                <label for="" class="main-form__label"> 商品の説明</label>
                <textarea class="main-form__text" name="description">
                </textarea>
                <div class="main-form__error">
                @error('name')
                    {{ $errors->first('address') }}
                @enderror
                </div>
                <label for="" class="main-form__label"> 販売価格</label>
                <span class="yen-mark">¥</span>
                <input type="text" class="main-form__input" name="price">
                <div class="main-form__error">
                @error('name')
                    {{ $errors->first('build') }}
                @enderror
                </div>
                <input type="submit" class="main-dorm__submit" value="出品する">
                </form>
            </div>
    @endsection