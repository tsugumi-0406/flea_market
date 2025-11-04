@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
<link rel="stylesheet" href="style.css">
<script src="https://js.stripe.com/clover/stripe.js"></script>
@endsection

@section('content')
<div class="main-inner">
    <div class="top">
        <div class="top-content">
            <div class="top-content__image">
                <img src="{{ asset('storage/' . $item->image) }}" alt="商品画像" width="100%"/>
            </div>
            <div class="top-content__detail">
                <h1 class="top-content__detail-name">{{ $item->name }}</h1>
                <p class="top-content__detail-price">¥{{ $item->price }}</p>
            </div>
        </div>

        <table class="pay-table">
            <tr>
                <td class="pay-table__td">商品代金</td>
                <td class="pay-table__td">¥{{ $item->price }}</td>
            </tr>
            <tr>
                <td>支払方法</td>
                <td>
                    {{-- ▼選択に応じて切り替わる表示ブロック --}}
                    <div class="bl_selectCont" id="1">
                        <div class="bl_selectCont_body">
                            <p>コンビニ支払</p>
                        </div>
                    </div>
                    <div class="bl_selectCont" id="2">
                        <div class="bl_selectCont_body">
                            <p>カード支払い。</p>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <form action="/order" method="post" class="pay-form">
    @csrf
        <div class="    ">
            <div class="center">
                <h2 class="center__title">支払方法</h2>
                <input type="hidden" name="item_id" value="{{ $item->id }}">
                <select name="method" class="pay-form__select" id="js_selectToggle">
                    <option selected hidden>選択してください</option>
                    <option value="1">1. コンビニ支払</option>
                    <option value="2">2. カード支払い</option>
                </select>
            </div>
            <div class="bottum">
                <div class="bottum-header">
                    <h2 class="buttum__title">配送先</h2>
                    <a href="{{ route('item.address', ['item_id' => $item->id]) }}" class="bottum__destination-link">変更する</a>
                </div>
                <div class="bottom__destination">
                    <input type="text" readonly class="bottom__destination--post_code" name="post_code" value="{{ $account->post_code }}">
                    <p>〒</p>
                    <input type="text" readonly class="bottom__destination--address" name="address" value="{{ $account->address }}{{ $account->building }}">
                </div>
            </div>
        </div>
        <input type="submit" class="pay-form__submit" value="購入する">
    </form>
</div>

{{-- ▼スクリプトは最後にまとめて配置 --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectToggle = document.getElementById('js_selectToggle');
    const selectContainers = document.querySelectorAll('.bl_selectCont');

    // 初期状態では全て非表示
    selectContainers.forEach(cont => cont.classList.remove('is_active'));

    if (selectToggle) {
        selectToggle.value = "";
        selectToggle.addEventListener('change', () => {
            const toggleVal = selectToggle.value;
            selectContainers.forEach(selectCont => {
                const isActive = selectCont.id === toggleVal;
                selectCont.classList.toggle('is_active', isActive);
            });
        });
    }
});
</script>
@endsection
