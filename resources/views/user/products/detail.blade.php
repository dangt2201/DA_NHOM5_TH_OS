@extends('user.layouts.app')

@section('body')
    <h3>{{ $product->name }} ({{ number_format($product->price) }})</h3>

    <form action="#" method="POST">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">

        Size: 
        <select name="size">
            @foreach($product->variants->unique('size') as $v)
                <option value="{{ $v->size }}">{{ $v->size }}</option>
            @endforeach
        </select>
        <br><br>

        Màu: 
        <select name="color">
            @foreach($product->variants->unique('color') as $v)
                <option value="{{ $v->color }}">{{ $v->color }}</option>
            @endforeach
        </select>
        <br><br>

        SL: <input type="number" name="quantity" value="1" min="1">
        <br><br>

        <button type="submit">TEST ADD TO CART</button>
    </form>
@endsection