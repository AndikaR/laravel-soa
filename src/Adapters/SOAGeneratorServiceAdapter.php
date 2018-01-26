<?php namespace Andikarus\SOAGenerator\Adapters;

use Andikarus\SOAGenerator\Services\SOAGeneratorService;
use Andikarus\SOAGenerator\Interfaces\IGenerator;

class SOAGeneratorServiceAdapter extends SOAGeneratorService implements IGenerator
{
  public function handle()
  {
    return parent::handle();
  }
}