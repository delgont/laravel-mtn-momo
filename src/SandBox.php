<?php

namespace Delgont\MtnMomo;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Delgont\MtnMomo\Models\Momo;
use Delgont\MtnMomo\Models\Option;


class SandBox 
{
    /**
     * The momo product.
     * @var string
     */
    protected $product = 'collection';
    protected $subscriptionKey = null;

    protected $base_url = null;


    public function __construct()
    {
         $this->base_url = config('momo.sandbox.base_url');
    }

    /**
     * Set the momo product to collection.
     * @var string
     */
    public function collection()
    {
        $this->product = 'collection';
        $this->subscriptionKey = config('momo.collection_subscription_key');
        return $this;
    }

    public function disbursement()
    {
        $this->product = 'disbursement';
        return $this;
    }

    public function product($product)
    {
        $this->product = $product;
        return $this;
    }

    public function getProduct()
    {
        return $this->product;
    }


    public function createApiUser(string $xReferenceId, string $product = null)
    {
        //replace this with repository pattern
        $momo = Momo::{$product ?? $this->product}()->first();

        if (!Str::isUuid($xReferenceId)) {
         # Validate uuid exception
        }
        $subscriptionKey = ($product) ? config('momo.sandbox.'.$product.'.primary_key') : config('momo.sandbox.collection.primary_key');

        $response = Http::withOptions(['verify' => false])->withHeaders([
         'X-Reference-Id' => $xReferenceId,
         'Ocp-Apim-Subscription-Key' => $subscriptionKey
        ])->withBody(json_encode([
         "providerCallbackHost" => "https://webhook.site/031fdc1a-f3da-428f-b080-52d7b0f1e474"
        ]), 'application/json')->post($this->base_url.'apiuser');

        $status = $response->status();

        switch ($status) {
         case '201':
          # code...
          ($momo) ? Option::updateOrCreate(['momo_id' => $momo->id], ['key' => 'api-user-x-reference-id', 'value' => $xReferenceId]) : '';
          return 'Api user with reference id '.$xReferenceId.' has been created succefully';
          break;

         case '409':
          # code...
          return 'Conflict, duplicated reference id';
          break;
         default:
          # code...
          break;
        }

    }

    public function getApiUser(string $product = null)
    {
        $momo = Momo::{$product ?? $this->product}()->first();
        $apiUserXReferenceId = Option::where('key', 'api-user-x-reference-id')->where('momo_id', $momo->id)->first();

        $subscriptionKey = ($product) ? config('momo.sandbox.'.$product.'.primary_key') : config('momo.sandbox.collection.primary_key');

        return $response = Http::withOptions(['verify' => false])->withHeaders([
         'Ocp-Apim-Subscription-Key' => $subscriptionKey
        ])->get($this->base_url.'apiuser'.'/'.$apiUserXReferenceId->value);

    }


    public function createApiKey(string $product = null)
    {
        $momo = Momo::{($product) ? $product : $this->product}()->first();
        return $apiUserXReferenceId = Option::where('key', 'api-user-x-reference-id')->where('momo_id', $momo->id)->first();

        $subscriptionKey = ($product) ? config('momo.sandbox.'.$product.'.primary_key') : config('momo.sandbox.collection.primary_key');

        return $response = Http::withOptions(['verify' => false])->withHeaders([
         'Ocp-Apim-Subscription-Key' => $subscriptionKey
        ])->post($this->base_url.'apiuser'.'/'.$apiUserXReferenceId->value.'/apikey');
    }
}
