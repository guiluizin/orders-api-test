<?php

namespace App\Jobs;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ApiOrder implements ShouldQueue
{
    use Queueable;

    private array $payload;

    /**
     * Create a new job instance.
     */
    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $customer = $this->payload['customer'];
        $order = $this->payload['order'];
        $products = $this->payload['products'];
        $shipping = $this->payload['shipping'] ?? null;
        $refund = $this->payload['refund'] ?? null;

        $customerModel = Customer::firstOrCreate(
            ['email' => $customer['email']],
            [
                'name' => $customer['name'],
                'phone' => $customer['phone'],
                'created_at' => $customer['created_at'],
                'updated_at' => $customer['updated_at']
            ]
        );

        $orderModel = $customerModel->orders()->create($order);

        foreach($products as $product) {

            $productModel = Product::firstOrCreate(
                ['name' => $product['name']],
                ['sku' => $product['sku']]
            );

            $orderModel->orderProducts()->create([
                'product_id' => $productModel->id,
                'unit_quantity' => $product['unit_quantity'],
                'package_quantity' => $product['package_quantity'],
                'unit_price' => $product['unit_price'],
                'total_price' => $product['total_price']
            ]);
        }

        if($shipping) {

            $orderModel->shipping()->create($shipping);
        }

        if($refund) {

            $orderModel->refund()->create($refund);
        }
    }
}
