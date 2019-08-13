<?php

namespace App\Console\Commands;

use App\Container;
use App\Product;
use Illuminate\Console\Command;
use Faker;

class GenContainers extends Command
{
    const BULK_INSERT_CHUNK = 200;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'containers:generate 
    {--count=1000 : count containers} 
    {--size=10 : count products in container}
    {--unique=100 : max count unique products}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate containers with products';

    protected $count = 1000;
    protected $unique = 100;
    protected $size = 10;
    protected $products = [];

    protected $productFaker;
    protected $containerFaker;

    protected $bulkInserts = [
        'containers' => [],
        'products' => []
    ];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->productFaker = Faker\Factory::create();
        $this->containerFaker = Faker\Factory::create();

    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        \DB::table('products')->delete();
        \DB::table('containers')->delete();
        if (!$this->count = (int)$this->option('count')) {
            $this->warn('Not correct option: count');
        }
        if (!$this->unique = (int)$this->option('unique')) {
            $this->warn('Not correct option: unique');
        }
        if (!$this->size = (int)$this->option('size')) {
            $this->warn('Not correct option: size');
        }

        $this->generateProducts();

        for ($i = 0; $i < $this->count; $i++) {
            $container_id = $this->containerFaker->unique()->numberBetween(1);
            $container = [
                'id' => $container_id,
                'name' => $this->containerFaker->unique()->uuid,
            ];
            $this->bulkInserts['containers'][] = $container;
            for ($j = 0; $j < $this->size; $j++) {
                $id = $this->productFaker->numberBetween(0, $this->unique - 1);
                $product = $this->products[$id];
                $product['container_id'] = $container_id;
                $this->bulkInserts['products'][] = $product;
            }
            $this->info('conteainer ' . ($i + 1) . ' generated with id: ' . $container_id);
            if (count($this->bulkInserts['containers']) > self::BULK_INSERT_CHUNK
                || count($this->bulkInserts['products']) > self::BULK_INSERT_CHUNK) {
                $this->write();
            }
        }
        $this->write();

    }

    protected function write()
    {
        try {
            Container::insert($this->bulkInserts['containers']);
            Product::insert($this->bulkInserts['products']);
        } catch (\Exception $e) {
            $this->warn($e->getMessage());
            return false;
        }
        $this->bulkInserts = ['containers' => [], 'products' => []];
        return true;
    }

    protected function generateProducts()
    {
        for ($i = 0; $i < $this->unique; $i++) {
            $this->products[$i] = [
                'id' => $this->productFaker->unique()->numberBetween(1),
                'name' => $this->productFaker->unique()->city,
            ];
        }
    }
}
