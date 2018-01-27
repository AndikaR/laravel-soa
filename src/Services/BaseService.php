<?php namespace Andikarus\SOAGenerator\Services;
 
abstract class BaseService
{
  /* Join array of path */
  protected function joinPaths($paths)
  {
    return str_replace("\\", "/", implode("/", $paths));
  }
 
  /* Get file name with prefix and postfix */
  protected function getFileName($name, $detail)
  {
    $newName = '';

    if ($detail && isset($detail['prefix'])) {
      $newName .= $detail['prefix'];
    }

    $newName .= $name;

    if ($detail && isset($detail['postfix'])) {
      $newName .= $detail['postfix'];
    }

    return $newName;
  }

  /* Create file from stub to target path */
  protected function createFileFromStub($targetDirectory, $targetPath, $stub)
  {
    if (!file_exists($targetDirectory)) {
      \File::makeDirectory($targetDirectory, 0755, true);
    }

    file_put_contents($targetPath, $stub);
  }
 
  /* Process stub by loading file and replace defined variables inside stub files */
  protected function processStub($path, $name, $variables)
  {
    $stub = file_get_contents($path);
    $stub = $this->replaceVariables($stub, $name, $variables);
 
    return $stub;
  }

  /* Replace variable placeholder inside stub file */
  protected function replaceVariables($stub, $name, $variables)
  {
    if ($stub) {
      foreach ($variables as $variable => $action) {
        if ($action) {
          $value = $action($name);
        } else {
          $value = $name;
        }        
        
        $stub = str_replace('{{ ' . $variable . ' }}', $value, $stub);
      }
    }

    return $stub;
  }
}