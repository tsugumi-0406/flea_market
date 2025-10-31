@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
<div class="main-inner">
    <div class="top">
        <div class="top-content">
            <div class="top-content__image">
                <img src="{{ asset('storage/' . $item->image) }}" alt="商品画像" width=100%/>
            </div>
            <div class="top-content__detail">
                <h1 class="top-content__detail-name">{{$item->name}}</h1>
                <p class="top-content__detail-price">¥{{$item->price}}</p>
            </div>
        </div>
        <table class="pay-table">
            <tr>
                <td class="pay-table__td">商品代金</td>
                <td class="pay-table__td">¥{{$item->price}}</td>
            </tr>
            <tr>
                <td>支払方法</td>
                <td>コンビニ支払</td>
            </tr>
         </table>
    </div>
    <div class="center">
        <h2 class="center__title">支払方法</h2>
        <form action="/order" method="post" class="pay-form">
            <select name="method" id="" class="pay-form__select">
                <option selected hidden>選択してください</option>
                <option value="コンビニ支払">1.コンビニ支払</option>
                <option value="カード支払い">2.カード支払い</option>
            </select>
            <input type="submit" class="pay-form__submit" value="購入する">
        </form>
    </div>
    <div class="bottum">
        <div class="bottum-header">
            <h2 class="buttum__title">配送先</h2>
            <a href="{{ route('item.address', ['item_id' => $item->id]) }}" class="bottum__destination-link">変更する</a>
        </div>
        <div class="bottom__destination">
            <p class="bottom__destination--post_code">〒{{$account->post_code}}</p>
            <p class="bottom__destination--address">{{$account->address}}{{$account->building}}</p>
        </div>
    </div>
</div>
@endsection