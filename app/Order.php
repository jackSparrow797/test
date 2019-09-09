<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const STATUS = [
        0 => "Новый",
        10 => "Подтвержден",
        20 => "Завершен",
    ];

    /**
     * связь с товарами в заказе
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderProducts()
    {
        return $this->hasMany('App\OrderProduct');
    }

    public function orderProductsDetail()
    {
        return $this->hasManyThrough('App\Product', 'App\OrderProduct', 'order_id', 'id', 'id', 'product_id');
    }

    /**
     * связь с партнерами
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function orderPartner()
    {
        return $this->hasOne('App\Partner', 'id', 'partner_id');
    }

    /**
     * получение общей стоимости заказа
     *
     * @return mixed
     */
    public function getTotalPrice() {
        return $this->orderProducts->sum(function($orderProduct) {
            return $orderProduct->quantity * $orderProduct->price;
        });
    }


    public function getStatusNameAttribute()
    {
        return self::STATUS[$this->status];
    }



}
