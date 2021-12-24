<?php

namespace ThisIsDevelopment\LaravelBaseDev\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;

abstract class AbstractDomainGeneratorCommand extends GeneratorCommand
{
    protected $hasMultiplePerModel = true;

    public function rootNamespace(): string
    {
        return '\\Domain';
    }

    protected function getStub(): string
    {
        return $this->resolveStubPath(sprintf("/stubs/%s.stub", Str::slug(class_basename($this))));
    }

    protected function resolveStubPath($stub): string
    {
        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
            ? $customPath
            : __DIR__.'/../../assets' . $stub;
    }

    protected function getArguments(): array
    {
        return array_filter([
            ['domain', InputArgument::REQUIRED, 'The name of the domain'],
            $this->type === 'Model' ? null : ['model', InputArgument::REQUIRED, 'The name of the model'],
            ['name', InputArgument::REQUIRED, 'The name of the ' . $this->type],
        ]);
    }

    protected function getNameInput(): string
    {
        return trim($this->argument('name'));
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        return sprintf(
            "%s\\%s%s",
            $rootNamespace,
            Str::plural($this->type),
            $this->hasMultiplePerModel ? '\\' . $this->input->getArgument('model') : ''
        );
    }
}
