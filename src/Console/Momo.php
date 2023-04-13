<?php

namespace Delgont\MtnMomo\Console;

use Illuminate\Console\Command;

use App\User;

use Faker\Generator as Faker;
use Illuminate\Support\Str;

use Delgont\MtnMomo\Models\Momo as MomoProduct;


class Momo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'momo';

    protected $product_attributes = ['id', 'product', 'primary_key', 'secondary_key'];

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate users ';


      /**
     * User model attributes use to display users on console
     *
     * @var array
     */
    private $attributes = ['id', 'name', 'email', 'created_at'];


    /**
     * 
     *
     * @var Faker
     */
    private $faker;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Faker $faker)
    {
        $this->faker = $faker;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->products();
    }


    private function products()
    {
        $this->info('Momo Products');
        $products = MomoProduct::all($this->product_attributes);

        $this->table($this->product_attributes, $products);
    }
}
