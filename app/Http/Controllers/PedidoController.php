
<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\ItemPedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    public function index()
    {
        return Pedido::with(['itens'])->get();
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $pedido = Pedido::create([
                'cliente_id' => $request->cliente_id,
                'status' => 'pendente',
                'total' => $request->total,
            ]);

            foreach ($request->itens as $item) {
                ItemPedido::create([
                    'pedido_id' => $pedido->id,
                    'produto_id' => $item['produto_id'],
                    'quantidade' => $item['quantidade'],
                    'preco_unitario' => $item['preco_unitario'],
                ]);
            }

            DB::commit();
            return $pedido->load('itens');

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Erro ao salvar pedido.'], 500);
        }
    }
}
