<?php

namespace Delgont\MtnMomo\Auth;


class Auth
{
    
    public function createAccessToken(string $permissionName, string $guardName)
    {
        return new static("A `{$permissionName}` permission already exists for guard `{$guardName}`.");
    }
}
