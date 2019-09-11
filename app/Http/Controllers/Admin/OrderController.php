<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\OrderRequest;
use App\Partner;
use App\Repositories\Admin\OrderRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{

    private $orderRepository;

    public function __construct()
    {
        $this->orderRepository = app(OrderRepository::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginate = $this->orderRepository->getAllOrdersWithPaginate();
        return view('admin.order.index', compact('paginate'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = $this->orderRepository->getEdit($id);
        if (empty($order)) {
            return abort(404);
        }
        $partners = Partner::select(['id', 'name'])
            ->get();
        return view('admin.order.edit', compact('order', 'partners'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Admin\OrderRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(OrderRequest $request, $id)
    {
        $validated = $request->validated();

        $order = $this->orderRepository->getEdit($id);
        if (empty($order)) {
            return back()->withErrors(['message' => "Заказ №$id не найден"])
                ->withInput();
        }
        $result = $order->update($validated);
        if ($result) {
            return redirect()->route('orders.edit', $id)
                ->with(['success' => 'Сохранено!']);
        } else {
            return back()->withErrors(['message' => "Ошибка при сохранении!"])
                ->withInput();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
