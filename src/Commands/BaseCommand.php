<?php namespace Andikarus\SOAGenerator\Commands;

use Illuminate\Console\Command;

class BaseCommand extends Command
{
  /* Join array of path */
  protected function joinPaths($paths)
  {
    return str_replace("\\", "/", implode("/", $paths));
  }

  /* Get file name with prefix and postfix */
  protected function getFileName($name, $detail)
  {
    return $detail['prefix'] . ucfirst($name) . $detail['postfix'];
  }

  /* Check if file exist */
  protected function fileExists($targetPath)
  {
    if (file_exists($targetPath)) {
      $this->info('File exists! Skipping current file.');
      return true;
    }

    return false;
  }

  /* Get target directory which will be written */
  protected function getTargetDirectoryPath($targetPath)
  {
    $explodedPath = explode("/", $targetPath);
    $fileName = array_pop($explodedPath);
    
    return implode("/", $explodedPath);
  }

  /* Process stub by loading file and replace defined variables inside stub files */
  protected function processStub($path, $name, $variables)
  {
    $stub = file_get_contents($path);
    $stub = $this->replaceVariables($stub, $name, $variables);

    return $stub;
  }

  /* Create file from stub to target path */
  protected function createFileFromStub($targetPath, $stub)
  {
    $targetDirectory = $this->getTargetDirectoryPath($targetPath);

    if (!file_exists($targetDirectory)) {
      \File::makeDirectory($targetDirectory, 0755, true);
    }

    file_put_contents($targetPath, $stub);
  }

  /* Replace variable placeholder inside stub file */
  protected function replaceVariables($stub, $name, $variables)
  {
    if ($stub) {
      foreach ($variables as $variable => $action) {
        if ($action) {
          $value = $action($name);
        } else {
          $value = $variable;
        }        
        
        $stub = str_replace('{{ ' . $variable . ' }}', $value, $stub);
      }
    }

    return $stub;
  }
}