<?php

namespace App\Console\Commands;

use App\Jobs\ApiOrder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SixApiRunner extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'six:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Read Six API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('API Reader has started.');
        
        $this->handleConnection();

        $this->info('API Reader has been executed.');
    }

    private function handleConnection() {

        try {

            $request = Http::timeout(30)
                ->get('https://dev-crm.ogruposix.com/candidato-teste-pratico-backend-dashboard/test-orders');

            if(!$request->successful()) {

                throw new HttpException($request->status(), 'Failed to connect.');
            }

            $json = $request->json();

            foreach($json['orders'] as $value) {

                $order = $value['order'];

                $products = [];

                foreach($order['line_items'] as $product) {

                    if($product['sku'] !== 'PRIORITY+INSUREDSHIPPING!') {

                        preg_match('/^[^ ]+/', $product['variant_title'], $matches); // get package quantity

                        $package = $matches[0] ?? null;

                        $upsell = str_contains($product['title'], 'Upsell');

                        $name = ''; // init name

                        if($upsell) {

                            $name = explode(' - ', $product['title'])[0]; // get first value
                        
                        } else {

                            $name = $product['title']; // get default
                        }

                        $products[] = [
                            'name' => $name,
                            'sku' => $product['sku'],
                            'unit_quantity' => $product['quantity'],
                            'package_quantity' => $package,
                            'price' => (float) $product['price'],
                            'upsell' => $upsell,
                        ];
                    }  
                }

                $payload = [
                    'order' => [
                        'number' => $order['number'],
                        'usd_total_price' => (float) str_replace(',', '', $order['local_currency_amount']),
                        'brl_total_price' => (float) str_replace(',', '', $order['current_total_price']),
                        'payment_status' => $order['payment_status'],
                        'payment_brand' => $order['payment_brand'],
                        'fulfillment_status' => $order['fulfillment_status'],
                        'address_street' => $order['billing_address']['address1'],
                        'address_zip' => $order['billing_address']['zip'],
                        'address_city' => $order['billing_address']['city'],
                        'address_province' => $order['billing_address']['province'],
                        'address_country' => $order['billing_address']['country'],
                        'processed_at' => $order['processed_at'],
                        'created_at' => $order['created_at'],
                        'updated_at' => $order['updated_at'],
                    ],
                    'customer' => [
                        'name' => "{$order['customer']['first_name']} {$order['customer']['last_name']}",
                        'email' => $order['customer']['email'],
                        'phone' => $order['customer']['phone'],
                        'created_at' => $order['customer']['created_at'],
                        'updated_at' => $order['customer']['updated_at'],
                    ],
                    'products' => $products
                ];

                if(!empty($order['fulfillments'])) {

                    $payload['shipping'] = [
                        'carrier' => $order['fulfillments'][0]['tracking_company'],
                        'tracking' => $order['fulfillments'][0]['tracking_number'],
                        'created_at' => $order['fulfillments'][0]['created_at'],
                        'updated_at' => $order['fulfillments'][0]['updated_at'],
                    ];
                }

                if(!empty($order['refunds'])) {

                    $payload['refund'] = [
                        'note' => $order['refunds'][0]['note'],
                        'total_amount' => $order['refunds'][0]['total_amount'],
                        'processed_at' => $order['refunds'][0]['created_at'],
                        'created_at' => $order['refunds'][0]['created_at'],
                        'updated_at' => $order['refunds'][0]['updated_at'],
                    ];
                }

                ApiOrder::dispatch($payload);
            }
            
        } catch(HttpException $error) {

            $this->error($error->getMessage());

            Log::channel('api-error')->error($error->getMessage());
        }
    }
}
