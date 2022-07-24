<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    public function reduceByOne($id){
        $this->items[$id]['qty']--;
        $this->items[$id]['price']-= $this->items[$id]['item']['sell_price'];
        $this->totalQty --;
        $this->totalPrice -= $this->items[$id]['item']['sell_price'];
        if ($this->items[$id]['qty'] <= 0) {
            unset($this->items[$id]);
        }
}
