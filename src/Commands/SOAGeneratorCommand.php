<?php namespace Andikarus\SOAGenerator\Commands;

class SOAGeneratorCommand extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'soa:generate {name} {--s|services} {--r|repositories}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate SOA template which located under app/Models directory';

    protected $stubs = [
      'entities' => [
        [
          'prefix'  => '',
          'postfix' => '',
          'path'    => __DIR__ . '/../../resources/stubs/entities/Entity.stub',
        ]
      ],
      'repositories' => [
        [
          'prefix'  => '',
          'postfix' => 'Repository',
          'path'    => __DIR__ . '/../../resources/stubs/repositories/Repository.stub',
        ],
        [
          'prefix'  => 'I',
          'postfix' => '',
          'path'    => __DIR__ . '/../../resources/stubs/repositories/RepositoryInterface.stub',
        ],
        [
          'prefix'  => '',
          'postfix' => 'RepositoryServiceProvider',
          'path'    => __DIR__ .'/../../resources/stubs/repositories/RepositoryServiceProvider.stub'
        ] 
      ],
      'services' => [
        [
          'prefix'  => '',
          'postfix' => 'Service',
          'path'    => __DIR__ . '/../../resources/stubs/services/Service.stub', 
        ],
        [
          'prefix'  => '',
          'postfix' => 'Facade',
          'path'    => __DIR__ . '/../../resources/stubs/services/ServiceFacade.stub',
        ],
        [
          'prefix'  => '',
          'postfix' => 'ServiceServiceProvider',
          'path'    => __DIR__ . '/../../resources/stubs/services/ServiceServiceProvider.stub',
        ]
      ]
    ];

    protected $variables = [
      'Name' => 'ucfirst',
      'name' => 'lcfirst'
    ];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
      parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
      $services = $this->option('services');
      $repositories = $this->option('repositories');

      $name = $this->argument('name');
      $all  = ((bool) $services !== (bool) $repositories) ? false : true;
      $config = (object) config('soagenerator.generator');

      foreach ($this->stubs as $key => $stub) {
        if (!$all && $services && $key !== 'services') continue;
        if (!$all && $repositories && $key !== 'repositories') continue; 

        foreach ($stub as $detail) {
          $params = [$config->basePath, $config->paths[$key], ucfirst($name)];

          if ($key === 'entities') {
            array_pop($params);
          }

          $fname = $this->getFileName($name, $detail) . '.php';
          $params[] = $fname;
          $targetPath = $this->joinPaths($params);

          if ($this->fileExists($targetPath)) continue;

          $stub = $this->processStub($detail['path'], $name, $this->variables);
          $this->createFileFromStub($targetPath, $stub);

          $this->info($fname .' has been created.');
        }
      }
    }
}
