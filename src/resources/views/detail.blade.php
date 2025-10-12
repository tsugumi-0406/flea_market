@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
<div class="main-inner">
    <div class="item-image">
        <img src="{{ asset('storage/' . $item->image) }}" alt="商品画像" class="img-content" width=100%/>   
    </div>
    <div class="main-sentence">
        <h1 class="main-sentence__name">{{$item->name}}</h1>
        <p class="main-sentence__brand">{{$item->brand}}</p>
        <p class="main-sentence__price">¥{{$item->price}}(税込み)</p>

<p>いいねボタン</p>

        <a href="" class="main-sentence__link-sell">購入手続きへ</a>
        <h2 class="main-sentence_explanation">商品説明</h2>
        <p class="main-sentence__explanation-text">{{$item->description}}</p>
        <h2 class="main-sentence_information">商品の情報</h2>
        <p class="main-sentence_information-description">{{$item->condition}}</p>
        <form action="" class="coment-form">
            <label for="" class="coment-form__label">商品へのコメント</label>
            <textarea name="" id="" class="coment-form__text"></textarea>
            <input type="submit" value="コメントを送信する" class="coment-form__submit">
        </form>
    </div>
</div>
@endsection