<?php namespace Andikarus\SOAGenerator\Commands;

class SOAGeneratorCommand extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'soa:generate {name} {--services} {--repositories}';

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
          'postfix' => 'Repositry',
          'path'    => __DIR__ . '/../../resources/stubs/entities/Entity.stub',
        ]
      ],
      'resources' => [
        [
          'prefix'  => '',
          'postfix' => 'Repositry',
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
      $services = $this->argument('services');
      $repositories = $this->argument('repositories');

      $name = $this->argument('name');
      $all  = ((bool) $service !== (bool) $repository) ? false : true;

      foreach ($this->stubs as $key => $stub) {
        if (!$all && $services && $key !== 'services') continue;
        if (!$all && $repositories && $key !== 'repositories') continue; 

        foreach ($stub as $repository => $detail) {
          $targetPath = $this->getTargetFilePath($name, $repository, $detail);

          if (!$this->checkFile($targetPath)) continue;

          $stub = $this->processStub($detail['path'], $name, $variables);
          $this->createFileFromStub($targetPath, $stub);
          
          $fileName = $this->getFileName($name, $detail);

          $this->info($fileName .' has been created.');
        }
      }
    }
}
