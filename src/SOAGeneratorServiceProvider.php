<?php namespace Andikarus\SOAGenerator;

use Illuminate\Support\ServiceProvider;
use Andikarus\SOAGenerator\Adapters\SOAGeneratorServiceAdapter;
use Andikarus\SOAGenerator\Commands\SOAGeneratorCommand;
use Andikarus\SOAGenerator\Interfaces\IGenerator;
use Andikarus\SOAGenerator\Interfaces\ICommand;

class SOAGeneratorServiceProvider extends ServiceProvider
{
  /**
   * Indicates if loading of the provider is deferred.
   *
   * @var bool
   */
  protected $defer = true;
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

    $this->app->bind(IGenerator::class, SOAGeneratorServiceAdapter::class);
    //$this->app->bind(ICommand::class, SOAGeneratorCommand::class);
  }
}