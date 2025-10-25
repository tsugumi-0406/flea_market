@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}" />
@endsection

@section('content')
<div class="page-link">
    <a href="/" class="tab-link {{ $tab === 'recommendation' ? 'active' : '' }}">おすすめ</a>
    <a href="/?tab=mylist" class="tab-link {{ $tab === 'mylist' ? 'active' : '' }}">マイリスト</a>
</div>

@if($tab === 'recommendation')
<div class="recomendation-list" id="tabContent01">
    @foreach($items as $item)
    <div class="item-card">
        <a href="/item/{$item_id}" class="item-link">
            <img src="{{ asset('storage/' . $item->image) }}" alt="商品画像" class="img-content" width=100%/>
            <p class="item-card__name">{{$item->name}}</p>
        </a>
    </div>
    @endforeach
</div>

@elseif($tab === 'mylist')
    @auth
<div class="mylist-list" id="tabContent02">
    @foreach($items as $item)
    <div class="item-card">
        <a href="/item/{$item_id}" class="item-link">
            <img src="{{ asset('storage/' . $item->image) }}" alt="商品画像" class="img-content" width=100%/>
            <p class="item-card__name">{{$item->name}}</p>
        </a>
    </div>
    @endforeach
</div>
 @endauth
@endif
@endsection