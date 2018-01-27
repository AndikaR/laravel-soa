<?php namespace Andikarus\SOAGenerator\Services;
 
use Andikarus\SOAGenerator\Interfaces\IService;

class SOAGeneratorService extends BaseService implements IService
{
  protected $command;
  
  protected $variables = [
    'Name' => 'ucfirst',
    'name' => 'lcfirst'
  ];

  protected $refs = [
    'entities'     => 1,
    'repositories' => 2,
    'services'     => 3
  ];

  const STUB_DIR = [
    'entities'     => __DIR__ . '/../../resources/stubs/entities',
    'repositories' => __DIR__ . '/../../resources/stubs/repositories',
    'services'     => __DIR__ . '/../../resources/stubs/services' 
  ];

  protected $stubs = [
    'entities' => [
      [
        'prefix'  => '',
        'postfix' => '',
        'path'    => self::STUB_DIR['entities'] . '/Entity.stub',
      ]
    ],
    'repositories' => [
      [
        'prefix'  => '',
        'postfix' => 'Repository',
        'path'    => self::STUB_DIR['repositories'] . '/Repository.stub',
      ],
      [
        'prefix'  => 'I',
        'postfix' => '',
        'path'    => self::STUB_DIR['repositories'] . '/RepositoryInterface.stub',
      ],
      [
        'prefix'  => '',
        'postfix' => 'RepositoryServiceProvider',
        'path'    => self::STUB_DIR['repositories'] . '/RepositoryServiceProvider.stub'
      ] 
    ],
    'services' => [
      [
        'prefix'  => '',
        'postfix' => 'Service',
        'path'    => self::STUB_DIR['services'] . '/Service.stub', 
      ],
      [
        'prefix'  => '',
        'postfix' => 'Facade',
        'path'    => self::STUB_DIR['services'] . '/ServiceFacade.stub',
      ],
      [
        'prefix'  => '',
        'postfix' => 'ServiceServiceProvider',
        'path'    => self::STUB_DIR['services'] . '/ServiceServiceProvider.stub',
      ]
    ]
  ];

  public function setCommandObject($command)
  {
    $this->command = $command;
  }

  public function handle()
  {
    $name = $this->command->argument('name');
    $all  = $this->command->option('all');
    $config = (object) config('soagenerator.generator');
    $search = null;

    if (!$all) {
      $prompt = $this->command->ask("Which one do you want to generate?\n\n [0] All \n [1] Entity only\n [2] Repositories only\n [3] Services only\n\n You can select multiple option by adding comma after each option. Ex: 2, 3 for choosing Repositories and Services.\n Press Ctrl + C to cancel.");

      /* Remove unnecessary space */
      $prompt = preg_split('/[\s*,\s*]*,+[\s*,\s*]*/', $prompt);

      /* Remove duplication */
      $prompt = array_values(array_flip(array_flip($prompt)));

      /* Set array for search */
      $search = array_flip($prompt);
      
      /* Search for option 0 (all) */
      if (isset($search[0])) {
        $all = true;
      }
    }   

    foreach ($this->stubs as $key => $stub) {
      if (!$all && !isset($search[$this->refs[$key]])) {
        continue; 
      } 

      foreach ($stub as $detail) {
        $paths = [$config->basePath, $config->paths[$key], ucfirst($name)];

        if ($key === 'entities') {
          array_pop($paths);
        }

        $fname   = $this->getFileName(ucfirst($name), $detail) . '.php';
        $paths[] = $fname;

        $targetPath = $this->joinPaths($paths);
        array_pop($paths);
        $targetDirectory = $this->joinPaths($paths);

        if (file_exists($targetPath)) {
          $this->command->error('File exists! Skipping ' . ucfirst($key) . ': ' . $fname);
          continue;
        }

        $stub = $this->processStub($detail['path'], $name, $this->variables);
        $this->createFileFromStub($targetDirectory, $targetPath, $stub);

        $this->command->info(ucfirst($key) . ': ' . $fname .' has been created.');
      }
    }
  }
}