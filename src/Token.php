<?php

namespace Delgont\MtnMomo;

use Delgont\MtnMomo\Concerns\Products;

use Illuminate\Support\Facades\Http;

use Delgont\MtnMomo\Exception\TokenException;

class Token
{
    use Products;

    protected $product = 'collection';
    protected $subscriptionKey = null;
    protected $userKey = null;
    protected $userId = null;



    public function __construct(string $product = null)
    {
        $this->product = $product;
        $this->userKey = config('momo.api_key');
        $this->userId = config('momo.api_user_id');
    }

    public function setSubscriptionKey(string $subscriptionKey)
    {
        $this->subscriptionKey = $subscriptionKey;
        return $this;
    }

    public function setProduct(string $product)
    {
        if(!$product){
            throw TokenException::invalidProduct();
        }

        $this->product = $product;
        return $this;
    }

    public function createAccessToken()
    {
        $response = Http::withBasicAuth($this->userId, $this->userKey)->withOptions(['verify' => false])->withHeaders([
            'Ocp-Apim-Subscription-Key' => $this->subscriptionKey
           ])->post(config('momo.base_url').$this->product.'/token');
        
        return $response->status();
    }
}
