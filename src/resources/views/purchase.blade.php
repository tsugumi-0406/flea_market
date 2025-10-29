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
        <form action="" class="pay-form">
            <select name="" id="" class="pay-form__select">
                <option value=""selected hidden>選択してください</option>
                <option value="">1.コンビニ支払</option>
                <option value="">2.カード支払い</option>
            </select>
            <input type="submit" class="pay-form__submit" value="購入する">
        </form>
    </div>
    <div class="bottum">
        <div class="bottum-header">
            <h2 class="buttum__title">配送先</h2>
            <a href="" class="bottum__destination-link">変更する</a>
        </div>
        <div class="bottom__destination">
            <p class="bottom__destination--post_code">〒郵便番号</p>
            <p class="bottom__destination--address">住所</p>
        </div>
    </div>
</div>
@endsection