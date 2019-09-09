@extends('adminlte::page')

@section('title', 'Заказы')

@section('content_header')
    <h1>Заказы</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="tab-content" id="myTabContent">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                ID
                            </div>
                            <div class="col">
                                Партнер
                            </div>
                            <div class="col">
                                Стоимость заказа
                            </div>
                            <div class="col">
                                Состав заказа
                            </div>
                            <div class="col">
                                Статус заказа
                            </div>
                        </div>
                    </div>
                </div>
                @forelse($paginate as $orderItem)
                    @php /**  @var App\Order $orderItem */ @endphp
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <a href="{{ route('orders.edit', $orderItem->id) }}" title="Редактировать заказ">
                                        {!! $orderItem->id !!}
                                    </a>
                                </div>
                                <div class="col">
                                    {{ $orderItem->orderPartner->name }}
                                </div>
                                <div class="col">
                                    {{ $orderItem->getTotalPrice() }} рублей
                                </div>
                                <div class="col">
                                    @forelse($orderItem->orderProductsDetail as $productItem)
                                        <p>{!! $productItem->name !!}</p>
                                    @empty
                                        нет товаров
                                    @endforelse
                                </div>
                                <div class="col">
                                    {!! $orderItem->statusName !!}
                                </div>
                            </div>

                        </div>
                    </div>
                @empty
                    <p>Нет заказов</p>
                @endforelse
            </div>

            @if ($paginate->total() > $paginate->count())
                <div class="row">
                    <div class="col-12">
                        <div class="card my-3">
                            <div class="card-body">
                                <nav aria-label="Page navigation example">
                                    {{ $paginate->links() }}
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
@stop

