<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    /**
     * для проверки текущего значения статуса заказа, вынесли логику из представления
     *
     * @param $partner_id
     * @return string
     */
    public function getSelectedAttribute($partner_id)
    {
        $out = ($partner_id == $this->id) ? 'selected' : '';
        return $out;
    }
}
