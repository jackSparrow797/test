@extends('adminlte::page')

@section('title', 'Редактирование заказа')

@section('content_header')
    <h1>Редактировать заказ №{{ $order->id }}</h1>
@stop

@section('content')

    @include('admin.includes.form.messages')

    <form action="{{ route('orders.update', $order->id) }}" method="post">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <div class="form-group">
            <label for="">Email</label>
            <input class="form-control" type="text" name="client_email" placeholder="Email"
                   value="{!! old('client_email', optional($order)->client_email) !!}" required>
        </div>
        <div class="form-group">
            <label for="partner_id">Партнер</label>
            <select class="form-control" name="partner_id" id="partner_id">
                @foreach($partners as $partnerItem)
                    <option {{ $partnerItem->getSelectedAttribute(old('partner_id', optional($order)->partner_id)) }} value="{{ $partnerItem->id }}">{{ $partnerItem->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="">Товары</label>
            @forelse($order->orderProductsDetail as $productItem)
                <p><b>{!! $productItem->name !!}</b> * <b>{{ $productItem->quantity }}</b> шт</p>
            @empty
                нет товаров
            @endforelse
        </div>
        <div class="form-group">
            <label for="status">Статус заказа</label>
            <select class="form-control" name="status" id="status">
                @foreach($order->getStatuses() as $code => $orderName)
                    <option {{ $order->getSelectedAttribute($code) }} value="{{ $code }}">{{ $orderName }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="">Стоимость заказа:</label>
            <p class="text-success">{{ $order->getTotalPrice() }} руб.</p>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-success" value="Сохранить">
        </div>
    </form>
@stop

