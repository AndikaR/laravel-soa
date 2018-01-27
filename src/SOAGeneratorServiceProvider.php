<?php namespace Andikarus\SOAGenerator;

use Illuminate\Support\ServiceProvider;
use Andikarus\SOAGenerator\Interfaces\IService;
use Andikarus\SOAGenerator\Services\SOAGeneratorService;

class SOAGeneratorServiceProvider extends ServiceProvider
{
  /**
   * Bootstrap the application services.
   *
   * @return void
   */
  public function boot()
  {
    $this->publishes([
      __DIR__ . '/../resources/config/soagenerator.php' => config_path('soagenerator.php'),
    ]);

    if ($this->app->runningInConsole()) {
      $this->commands([ Commands\SOAGeneratorCommand::class ]);
    }
  }

  /**
   * Register the application services.
   *
   * @return void
   */
  public function register()
  {
    $this->mergeConfigFrom(
      __DIR__ . '/../resources/config/soagenerator.php', 'soagenerator'
    );

    $this->app->bind(IService::class, SOAGeneratorService::class);
  }
}