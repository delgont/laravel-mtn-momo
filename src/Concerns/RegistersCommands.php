<?php

namespace Delgont\MtnMomo\Concerns;

/**
 * Commands
 */

use Delgont\MtnMomo\Console\Momo;
use Delgont\MtnMomo\Console\InitCommand;


trait RegistersCommands
{
    private function registerCommands() : void
    {
        $this->commands([
            Momo::class,
            InitCommand::class
        ]);
    }
}