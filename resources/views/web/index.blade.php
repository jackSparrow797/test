@extends('layouts.template')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <h1>Погода в Брянске</h1>
            <p>Текущая температура: {{ $wheather['fact']['temp'] }} &deg;С</p>
            <p>Ощущается: {{ $wheather['fact']['feels_like'] }} &deg;С</p>
            <p>Скорость ветра: {{ $wheather['fact']['wind_speed'] }} м/с</p>
            <p>Давление: {{ $wheather['fact']['pressure_mm'] }} мм рт. ст.</p>
            <p>Влажность воздуха : {{ $wheather['fact']['humidity'] }} %</p>
        </div>
    </div>

@stop