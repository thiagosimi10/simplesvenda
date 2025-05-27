
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $fillable = ['cliente_id', 'status', 'total'];

    public function itens()
    {
        return $this->hasMany(ItemPedido::class);
    }
}
