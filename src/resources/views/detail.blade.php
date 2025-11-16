@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
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
<!--いいねボタンの作成 -->
<div class="main-sentence__count">
    <div class="flex items-center gap-3"> 
        @auth
            @php
                $account = \App\Models\Account::where('user_id', Auth::id())->first();
            @endphp
            <!--その投稿がいいねしているか判定 -->

            @if ($account && $account->likes()->where('item_id', $item->id)->exists())
                <ion-icon name="heart" class="like-btn cursor-pointer text-pink-500" data-item-id="{{ $item->id }}"></ion-icon>
            @else
                <ion-icon name="heart" class="like-btn cursor-pointer" data-item-id="{{ $item->id }}"></ion-icon>
            @endif

            <p class="count-num">{{ $item->likes->count() }}</p>
        @endauth
    </div>
    <div class="comment-count">
        <ion-icon name="chatbubble-outline"></ion-icon>
        <p class="count-comment">{{$item->comments->count()}}</p>
    </div>
</div>

        <a href="{{ route('item.purchase', ['item_id' => $item->id]) }}" class="main-sentence__link-sell">購入手続きへ</a>
        <h2 class="main-sentence_title">商品説明</h2>
        <p class="main-sentence__explanation-text">{{$item->description}}</p>
        <h2 class="main-sentence_title">商品の情報</h2>
        <div class="main-sentence__category">
            <label for="" class="main-sentence__label">カテゴリー</label>
                @foreach($item->categories as $category)
                    <p class="main-sebtebce__category-name">{{ $category->name }}</p>
                @endforeach
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
                @foreach($item->comments as $comment)
                <div class="comment__userdata">
                    <img src="{{ asset('storage/' . $comment->account->image) }}">
                    <p class="comment__user-name">{{ $comment->account->name }}</p>
                </div>
                    <p class="comment__sentence">{{ $comment->sentence }}</p>
                @endforeach
        </div>

        <form action="/comment" method="post" class="comment-form">
        @csrf
            <input type="hidden" name="item_id" value="{{ $item->id }}">
            <label class="comment-form__label">商品へのコメント</label>
            <textarea name="sentence" class="comment-form__text"></textarea>
            <input type="submit" value="コメントを送信する" class="comment-form__submit">
        </form>
    </div>
</div>
<script src="{{ asset('js/like.js') }}"></script>
@endsection