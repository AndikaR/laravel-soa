<?php namespace Andikarus\SOAGenerator\Services;

use Andikarus\SOAGenerator\Interfaces\ICommand;
use Andikarus\SOAGenerator\Interfaces\IAdapter;

class SOAGeneratorService extends BaseService implements IGenerator
{
  protected $arguments;
  protected $options;

  protected $adapter;
  protected $commands;
  
  protected $variables = [
    'Name' => 'ucfirst',
    'name' => 'lcfirst'
  ];

  protected $stubs = [
    'entities' => [
      [
        'prefix'  => '',
        'postfix' => '',
        'path'    => __DIR__ . '/../../../resources/stubs/entities/Entity.stub',
      ]
    ],
    'repositories' => [
      [
        'prefix'  => '',
        'postfix' => 'Repository',
        'path'    => __DIR__ . '/../../../resources/stubs/repositories/Repository.stub',
      ],
      [
        'prefix'  => 'I',
        'postfix' => '',
        'path'    => __DIR__ . '/../../../resources/stubs/repositories/RepositoryInterface.stub',
      ],
      [
        'prefix'  => '',
        'postfix' => 'RepositoryServiceProvider',
        'path'    => __DIR__ .'/../../../resources/stubs/repositories/RepositoryServiceProvider.stub'
      ] 
    ],
    'services' => [
      [
        'prefix'  => '',
        'postfix' => 'Service',
        'path'    => __DIR__ . '/../../../resources/stubs/services/Service.stub', 
      ],
      [
        'prefix'  => '',
        'postfix' => 'Facade',
        'path'    => __DIR__ . '/../../../resources/stubs/services/ServiceFacade.stub',
      ],
      [
        'prefix'  => '',
        'postfix' => 'ServiceServiceProvider',
        'path'    => __DIR__ . '/../../../resources/stubs/services/ServiceServiceProvider.stub',
      ]
    ]
  ];

  public function __construct(ICommand $commands, IAdapter $adapter)
  {
    $this->commands = $commands;
    $this->adapter  = $adapter;
  }

  // public function setArguments($arguments)
  // {
  //   $this->arguments = $arguments;
  // }

  // public function setOptions($options)
  // {
  //   $this->options = $options;
  // }

  public function handle()
  {
    $this->commands->output('wasdfgg');
    //dd(json_encode(['babubyaysas']));
    // $name = $this->argument('name');
    // $all  = ((bool) $services !== (bool) $repositories) ? false : true;
    // $config = (object) config('soagenerator.generator');

    // foreach ($this->stubs as $key => $stub) {
    //   if (!$all && $services && $key !== 'services') continue;
    //   if (!$all && $repositories && $key !== 'repositories') continue; 

    //   foreach ($stub as $detail) {
    //     $params = [$config->basePath, $config->paths[$key], ucfirst($name)];

    //     if ($key === 'entities') {
    //       array_pop($params);
    //     }

    //     $fname = $this->getFileName($name, $detail) . '.php';
    //     $params[] = $fname;
    //     $targetPath = $this->joinPaths($params);

    //     if ($this->fileExists($targetPath)) continue;

    //     $stub = $this->processStub($detail['path'], $name, $this->variables);
    //     $this->createFileFromStub($targetPath, $stub);

    //     $this->info($fname .' has been created.');
    //   }
    // }
  }
}