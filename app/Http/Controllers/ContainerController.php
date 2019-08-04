<?php

namespace App\Http\Controllers;

use App\Container;
use App\Http\Requests\ContainerRequest;
use App\Product;
use phpDocumentor\Reflection\Types\Integer;

class ContainerController extends Controller
{
    /**
     * Get containers
     */
    public function index()
    {
        return Container::with('products')->paginate();
    }

    /**
     * Add new containers
     * @param ContainerRequest $request
     * @return \Illuminate\Http\Response
     */
    public function add(ContainerRequest $request)
    {
        $validated_data = $request->validated();
        $container = Container::create($validated_data);

        foreach ($validated_data['products'] as $product_data) {
            $product_data['container_id'] = $container->id;
            Product::create($product_data);
        }
        return response()->json(['message' => "Container {$container->id} will added"], 200);
    }

    /**
     * Display the specified resource.
     * @param $container_id
     * @return \Illuminate\Http\Response
     */
    public function show($container_id)
    {
        if ($container = Container::with('products')->find($container_id)) {
            return response()->json($container, 200);
        } else {
            return response()->json(['message' => "Container {$container_id} not found"], 404);
        }
    }
}
