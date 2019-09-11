@extends('adminlte::page')

@section('title', 'Заказы')

@section('content_header')
    <h1>Заказы</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#last-orders" role="tab"
                       aria-controls="home" aria-selected="true">Просроченные заказы</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#current-orders" role="tab"
                       aria-controls="profile" aria-selected="false">Текущие</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#new-orders" role="tab"
                       aria-controls="contact" aria-selected="false">Новые заказы</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#completed-orders" role="tab"
                       aria-controls="contact" aria-selected="false">Выполненные заказы</a>
                </li>
            </ul>
            <div class="tab-content" id="orders-tabs-outer">
                @foreach($orders as $tab_id => $paginate)
                    <div class="tab-pane fade @if ($loop->first) show active @endif" id="{{ $tab_id }}"
                         role="tabpanel" aria-labelledby="home-tab">
                        @include('admin.order.includes._tab_content', compact('paginate'))
                    </div>
                @endforeach
            </div>

        </div>
    </div>
@stop

