<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $guarded = ['price'];

    const STATUS = [
        0 => "Новый",
        10 => "Подтвержден",
        20 => "Завершен",
    ];
    const STATUS_MAIL_SEND = 20;

    /**
     * связь с товарами в заказе
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderProducts()
    {
        return $this->hasMany('App\OrderProduct');
    }

    /**
     * связь товаров с заказов
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function orderProductsDetail()
    {
        return $this->hasManyThrough('App\Product', 'App\OrderProduct', 'order_id', 'id', 'id', 'product_id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function orderPartner()
    {
        return $this->belongsTo('App\Partner', 'partner_id', 'id');
    }

    /**
     * получение общей стоимости заказа
     *
     * @return mixed
     */
    public function getTotalPrice()
    {
        return $this->orderProducts->sum(function ($orderProduct) {
            return $orderProduct->quantity * $orderProduct->price;
        });
    }


    /**
     * Получение названия статуса по его коду
     *
     * @return mixed
     */
    public function getStatusNameAttribute()
    {
        return self::STATUS[$this->status];
    }

    /**
     * получение статусов заказа, для выпадающего списка
     *
     * @return array
     */
    public function getStatuses()
    {
        return self::STATUS;
    }

    /**
     * для проверки текущего значения статуса заказа, вынесли логику из представления
     *
     * @param $code
     * @return string
     */
    public function getSelectedAttribute($code)
    {
        $out = ($code == $this->status) ? 'selected' : '';
        return $out;
    }


}
