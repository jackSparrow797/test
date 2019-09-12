<?php


namespace App\Repositories\Admin;


use App\Order as Model;
use App\Order;
use App\Product;
use App\Repositories\CoreRepository;
use Carbon\Carbon;


class OrderRepository extends CoreRepository
{
    const WITH = [
        'orderProducts:id,price,quantity,product_id,order_id',
        'orderPartner:id,name',
        'orderProductsDetail:name'
    ];
    const SELECT = ['id', 'status', 'partner_id', 'delivery_dt'];


    /**
     * @return mixed|string
     */
    protected function getModelClass()
    {
        return Model::class;
    }

    /**
     * Метод, для получения заказа для редактирования
     *
     * @param $id
     * @return mixed
     */
    public function getEdit($id)
    {
        return $this->startConditions()
            ->select(['id', 'status', 'partner_id', 'client_email'])
            ->with('orderProductsDetail:name,quantity')
            ->find($id);
    }

    /**
     * получение данных для табов
     *
     * @return mixed
     */
    public function getAllTabsOrders()
    {
        $out['last-orders'] = $this->getLastOrdersWithPaginate();
        $out['current-orders'] = $this->getCurrentOrdersWithPaginate();
        $out['new-orders'] = $this->getNewOrdersWithPaginate();
        $out['completed-orders'] = $this->getCompletedOrdersWithPaginate();
        return $out;
    }


    /**
     * @return mixed
     */
    public function getLastOrdersWithPaginate()
    {
        $selectFields = self::SELECT;
        $with = self::WITH;
        $where = [
            ['status', '=', 10],
            ['delivery_dt', '<', Carbon::now()]
        ];
        $out = $this->startConditions()
            ->where($where)
            ->orderBy('delivery_dt', 'desc')
            ->with($with)
            ->select($selectFields)
            ->paginate(50);
        return $out;
    }

    /**
     * @return mixed
     */
    public function getCurrentOrdersWithPaginate()
    {
        $selectFields = self::SELECT;
        $with = self::WITH;
        $where = [
            ['status', '=', 10],
            ['delivery_dt', '>', Carbon::now()],
            ['delivery_dt', '<', Carbon::now()->addHours(24)],
        ];
        $out = $this->startConditions()
            ->where($where)
            ->orderBy('delivery_dt', 'asc')
            ->with($with)
            ->select($selectFields)
            ->paginate(50);
        return $out;
    }

    /**
     * @return mixed
     */
    public function getNewOrdersWithPaginate()
    {
        $selectFields = self::SELECT;
        $with = self::WITH;
        $where = [
            ['status', '=', 0],
            ['delivery_dt', '>', Carbon::now()]
        ];
        $out = $this->startConditions()
            ->where($where)
            ->orderBy('delivery_dt', 'asc')
            ->with($with)
            ->select($selectFields)
            ->paginate(50);
        return $out;
    }
    /**
     * @return mixed
     */
    public function getCompletedOrdersWithPaginate()
    {
        $selectFields = self::SELECT;
        $with = self::WITH;
        $where = [
            ['status', '=', 20]
        ];
        $out = $this->startConditions()
            ->where($where)
            ->whereDate('delivery_dt', Carbon::today())
            ->orderBy('delivery_dt', 'desc')
            ->with($with)
            ->select($selectFields)
            ->paginate(50);
        return $out;
    }


    /**
     * @param Order $order
     * @return array
     */
    public function getVendorEmailForProduct(Order $order)
    {
        $out = [];
        $relation = ['vendor:id,email'];
        $ordersProducts = $order
            ->orderProductsDetail()
            ->with($relation)
            ->get();
        foreach ($ordersProducts as $product) {
            /** @var Product $product */
            $out[] = $product->vendor->email;
        }
        return $out;
    }

    /**
     * @param Order $order
     * @return mixed
     */
    public function getPartnerEmailForOrder(Order $order)
    {
        $partner = $order->orderPartner()
            ->first(['id', 'email']);
        return $partner->email;
    }


}