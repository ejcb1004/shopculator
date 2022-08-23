<?php

namespace App\Console;

use App\Models\Product;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Http;

class Kernel extends ConsoleKernel
{
    protected $is_updated = false;
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $response = Http::get('http://localhost/sample-ecommerce/ajax/products.ajax.php')->json()['data'];
            for ($i = 0; $i < count($response); $i++) {
                if (Product::select('product_id')->where('product_id', $response[$i]['product_id'])->exists()) {
                    $recent = Product::where('product_id', $response[$i]['product_id'])->orderBy('created_at', 'DESC')->get()->first()->toArray();
                    if ($recent['price'] != $response[$i]['price']) {
                        Product::create([
                            'product_id'    => $response[$i]['product_id'],
                            'market_id'     => $response[$i]['market_id'],
                            'category_id'   => $response[$i]['category_id'],
                            'product_name'  => $response[$i]['product_name'],
                            'price'         => $response[$i]['price'],
                            'image_path'    => $response[$i]['image_path']
                        ]);
                    } 
                } else {
                    Product::create([
                        'product_id'    => $response[$i]['product_id'],
                        'market_id'     => $response[$i]['market_id'],
                        'category_id'   => $response[$i]['category_id'],
                        'product_name'  => $response[$i]['product_name'],
                        'price'         => $response[$i]['price'],
                        'image_path'    => $response[$i]['image_path']
                    ]);
                }
            }
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
