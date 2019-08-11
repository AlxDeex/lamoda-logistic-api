<?php

namespace App\Http\Controllers;

use App\Container;
use Illuminate\Http\Request;

class PhotoStudioSetsController extends Controller
{
    /**
     * Return minimal containers, contain all unique products.
     *
     */
    public function index()
    {
        /*
         * Для решения задачи нуно найти множество, состоящее из симетрической разности множеств (контейнеров с товарами),
         * товары которые попадут в итоговое множество будут находится  в нужных нам контейнерах
         */

        $result_set_products = [];
        foreach (Container::with('products')->cursor() as $container) {
            if (empty($result_set_products)) {
                $result_set_products = $container->products->toArray();
                continue;
            }

            $first = array_udiff($result_set_products, $container->products->toArray(), function ($a, $b) {
                return $a['id'] - $b['id'];
            });

            $second = array_udiff($container->products->toArray(), $result_set_products, function ($a, $b) {
                return $a['id'] - $b['id'];
            });

            if (!empty($first) && !empty($second)) {
                $result_set_products = array_merge($first, $second);
            }
        }
        $containers_ids = array_unique(array_column($result_set_products, 'container_id'));
        return Container::with('products')->whereIn('id', $containers_ids)->paginate();
    }
}
