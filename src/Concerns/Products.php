<?php

namespace Delgont\MtnMomo\Concerns;


trait Products
{
    protected $product = 'collection';
    protected $subscriptionKey = null;

    public function collection()
    {
        $this->product = 'collection';
        $this->subscriptionKey = config('momo.'.$this->product.'_subscription_key');
        return $this;
    }

    public function disbursement()
    {
        $this->product = 'disbursement';
        return $this;
    }
    
}
