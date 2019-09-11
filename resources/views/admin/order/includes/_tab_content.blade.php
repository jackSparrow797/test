@include('admin.order.includes._order_row_header')
@forelse($paginate as $orderItem)
    @include('admin.order.includes._order_row')
@empty
    <p>Нет заказов</p>
@endforelse
@include('admin.includes.paginate.simple', compact('paginate'))

