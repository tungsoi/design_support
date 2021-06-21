<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class FormatProductCode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'format:product-code';

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
        $products = Product::select('id', 'category_id', 'code')->get();

        foreach ($products as $product) {
            $count = Product::where('category_id', $product->category_id)->where('id', '<=', $product->id)->count();
            $category = Category::find($product->category_id)->code;
            $code = Str::upper($category) ."-". str_pad($count, 4, "0", STR_PAD_LEFT);

            Product::find($product->id)->update([
                'code'  =>  $code
            ]);

        }
    }
}
