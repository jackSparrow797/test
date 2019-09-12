@php /**  @var App\Order $orderItem */ @endphp
<div class="card">
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
            <div class="col">
                {!! $orderItem->delivery_dt !!}
            </div>
        </div>

    </div>
</div>