<?php namespace Andikarus\SOAGenerator\Commands;

use Andikarus\SOAGenerator\Interfaces\IService;
use Illuminate\Console\Command;

class SOAGeneratorCommand extends Command
{ 
  protected $service;

  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'soa:generate {name} {--a|all}';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Generate SOA template which located under app/Models directory';

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct(IService $service)
  {
    $this->service = $service;
    parent::__construct();
  }

  /**
   * Execute the console command.
   *
   * @return mixed
   */
  public function handle()
  {
    $this->service->setCommandObject($this);
    $this->service->handle();
  }
}
