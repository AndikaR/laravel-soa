<?php namespace Andikarus\SOAGenerator\Interfaces; 
 
interface IService 
{
  public function setCommandObject($command);
  public function handle(); 
}