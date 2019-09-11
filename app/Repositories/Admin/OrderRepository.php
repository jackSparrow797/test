<?php


namespace App\Repositories\Admin;


use App\Order as Model;
use App\Order;
use App\Product;
use App\Repositories\CoreRepository;

class OrderRepository extends CoreRepository
{
    /**
     * @return mixed|string
     */
    protected function getModelClass()
    {
        return Model::class;
    }

    /**
     * Метод, для получения
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
     * получение данных для отображения на странице списка элментов
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllOrdersWithPaginate()
    {
        $selectFields = ['id', 'status', 'partner_id'];
        $with = ['orderProducts:id,price,quantity,product_id,order_id', 'orderPartner:id,name', 'orderProductsDetail:name'];
        $out = $this->startConditions()
            ->with($with)
            ->select($selectFields)
            ->paginate(15);
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
            /** @var Product $product*/
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