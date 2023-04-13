<?php

namespace Delgont\MtnMomo\Exception;

use Exception;

class TokenException extends Exception
{
    public static function apiKeyNotSet() : self
    {
        return new self("Momo api user id not set");
    }

    public static function invalidProduct(string $product): self
    {
        if(!in_array($product, ['collection','disbursement'])){
            return new self("The product name {$product} provided does not exit");
        }
    }
}
