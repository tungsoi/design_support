<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class CheckDuplicateCodeProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'duplicate:code';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $products = Product::all();
        try{
            foreach ($products as $key => $product){
                Product::find($product->id)->update([
                    'code' => $product->code . '-' . $product->id
                ]);
            }
            return 'Success';
        }catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
