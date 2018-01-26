<?php namespace Andikarus\SOAGenerator\Interfaces;

interface ICommand
{
  public function getArguments();
  public function getOptions();
  public function output($message, $type = 'info');
}