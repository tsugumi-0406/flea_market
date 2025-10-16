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
        <h2 class="main-sentence_title">商品説明</h2>
        <p class="main-sentence__explanation-text">{{$item->description}}</p>
        <h2 class="main-sentence_title">商品の情報</h2>
        <div class="main-sentence__category">
            <label for="" class="main-sentence__label">カテゴリー</label>
        </div>
        <div class="main-sentence__condition">
            <label for="" class="main-sentence__label">商品の状態</label>
            <div class="main-sentence__condition-content">
                @if($item['condition'] == 1)
                良好    
                @elseif($item['condition'] == 2)
                目立った傷や汚れなし
                @elseif($item['condition'] == 3)
                やや傷や汚れあり
                @else
                状態が悪い
                @endif
            </div>
        </div>

        <div class="comment">
            <p class="comment__title">コメント</p>
            <p class="comment__sentence">
                コメントがここに入る
            </p>
        </div>
        <form action="" class="comment-form">
            <label for="" class="comment-form__label">商品へのコメント</label>
            <textarea name="" id="" class="comment-form__text"></textarea>
            <input type="submit" value="コメントを送信する" class="comment-form__submit">
        </form>
    </div>
</div>
@endsection