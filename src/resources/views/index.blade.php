@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}" />
@endsection

@section('content')
<div class="page-link">
    <a href="" class="page-link__recommendation">おすすめ</a>
    <a href="" class="page-link__mylist">マイリスト</a>
</div>
<div class="item-list">
    @foreach($items as $item)
    <div class="item-card">
        <a href="/item/{$item_id}" class="item-link"></a>
        <img src="{{ asset('storage/' . $item->image) }}" alt="商品画像" class="img-content" width=100%/>
        <p class="item-card__name">{{$item->name}}</p>
    </div>
    @endforeach
</div>
@endsection