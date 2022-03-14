<?php

declare(strict_types=1);

namespace ThisIsDevelopment\LaravelBaseDev\Helpers;

use Illuminate\Support\Str;

class FqnHelper
{
    public function __construct(
        protected string $rootNamespace,
        string $domain,
        string $model
    ) {
        $this->domain = Str::studly(trim($domain));
        $this->model = Str::studly(trim($model));
    }

    public function getDomain(): string
    {
        return $this->domain;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function modelFqn(): string
    {
        return $this->fqn(
            'model',
            $this->model,
        );
    }

    public function exceptionFqn(): string
    {
        return $this->fqn(
            'exception',
            Str::studly("{$this->model}_exception"),
        );
    }

    public function eventFqn(string $event): string
    {
        return $this->fqn(
            'event',
            Str::studly("{$this->model}_{$event}_Event"),
            hasMultiplePerModel: true
        );
    }


    public function actionFqn(string $action): string
    {
        return $this->fqn(
            'action',
            Str::studly("{$action}_{$this->model}_Action"),
            hasMultiplePerModel: true
        );
    }

    public function dtoFqn(string $prefix = ''): string
    {
        return $this->fqn(
            'dto',
            Str::studly(ltrim("{$prefix}_{$this->model}_dto", '_')),
            hasMultiplePerModel: true
        );
    }

    public function repositoryInterfaceFqn(): string
    {
        return $this->fqn(
            'repositories',
            Str::studly("{$this->model}_repository_interface")
        );
    }

    public function baseClass(string $fqn): string
    {
        return class_basename($fqn);
    }

    public function asVariable(string $fqn): string
    {
        return Str::camel($this->baseClass($fqn));
    }


    public function getModelNamespace(string $type, bool $hasMultiplePerModel = false): string
    {
        return implode('\\', array_filter([
            trim($this->rootNamespace, '\\'),
            $this->domain,
            Str::plural(Str::studly($type)),
            $hasMultiplePerModel ? $this->model : ''
        ]));
    }

    public function fqn(string $type, string $className, bool $hasMultiplePerModel = false): string
    {
        return implode('\\', array_map(fn ($e) => trim($e, '\\'), array_filter([
            $this->getModelNamespace($type, $hasMultiplePerModel),
            Str::studly($className),
        ])));
    }
}
