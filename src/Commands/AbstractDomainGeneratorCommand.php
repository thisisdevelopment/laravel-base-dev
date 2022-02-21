<?php

namespace ThisIsDevelopment\LaravelBaseDev\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use ThisIsDevelopment\LaravelBaseDev\Helpers\FqnHelper;

abstract class AbstractDomainGeneratorCommand extends GeneratorCommand
{
    public const ROOT_NAMESPACE_DEFAULT = 'ThisIsDevelopment\Domain';

    /**
     * Root namespace of the class to be generated.
     *
     * @var string
     **/
    protected string $rootNamespace = self::ROOT_NAMESPACE_DEFAULT;

    /**
     * Optional stub path override
     *
     * @var string
     **/
    protected ?string $stub = null;

    /**
     * FQN Helper class for easy fqn/classname generation based on
     * current domain/model
     *
     * @var FqnHelper
     **/
    private FqnHelper $fqnHelper;

    public function handle(): bool|null
    {
        // if type is not set, automatically set it to the full class
        // FQN for more descriptive console output
        $this->type = $this->type ?: $this->getClassFqn();

        // let parent handle actual command
        return parent::handle();
    }

    public function rootNamespace(): string
    {
        return $this->rootNamespace;
    }

    /** Stub related **/
    protected function getStub(): string
    {
        return $this->resolveStubPath(
            $this->getStubName()
        );
    }

    protected function getStubName(): string
    {
        return $this->stub ?: $this->generateStubName();
    }

    protected function generateStubName(): string
    {
        return "stubs/" . Str::kebab(
            str_replace('Make', '', class_basename($this))
        ) . '.stub';
    }

    protected function resolveStubPath($stub): string
    {
        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
            ? $customPath
            : __DIR__ . '/../../assets/' . ltrim($stub, '/');
    }

    protected function getPath($name)
    {
        return implode('/', [
            $this->laravel->basePath('app'),
            'Domain',
            ...explode('\\', trim(str_replace($this->rootNamespace(), '', $name), '\\'))
        ]) . '.php';
    }

    /**
     * @inheritdoc
     *
     * The desired classname will be determined by the
     * getClassFqn() method instead of by a command argument
     **/
    protected function getNameInput(): string
    {
        return $this->getClassFqn();
    }

    protected function fqnHelper(): FqnHelper
    {
        return $this->fqnHelper
            ?? $this->fqnHelper = new FqnHelper(
                $this->rootNamespace(),
                $this->argument('domain'),
                $this->argument('model')
            );
    }

    protected function getOptions(): array
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'force generation when class already exists']
        ];
    }

    protected function getArguments(): array
    {
        return array_filter([
            ['domain', InputArgument::REQUIRED, 'The name of the domain'],
            ['model', InputArgument::REQUIRED, 'The name of the model'],
        ]);
    }

    protected function buildClass($name)
    {
        $file = $this->files->get($this->getStub());

        foreach ($this->getVariables() as $key => $value) {
            // `str_replace`...? Yeah i know, but this is how laravel
            // also does it themselves and i did not want to deviate
            // to much...  a nice improvement might be using Blade or
            // Mustache instead, which will also greatly improve
            // flexibility
            $file = str_replace($this->convertKey($key), $value, $file);
        }

        return $file;
    }

    /**
     * Allow a variaty of key naming by generating a list of possible
     * writing options for given key.
     *
     * The keys generated are based slightly on the names used by laravels own generator
     *
     * @return string[]
     **/
    private function convertKey($key): array
    {
        return [
            sprintf('{{ %s }}', $key),
            sprintf('{{ %s}}', $key),
            sprintf('{{%s }}', $key),
            sprintf('{{%s}}', $key),
            Str::studly("dummy_{$key}"),
        ];
    }

    /**
     * The FQN of the class to be generated.
     *
     * @return string
     **/
    abstract protected function getClassFqn(): string;

    /**
     * provide list of variables to replace in stubs in the form of an associative array.
     *
     **/
    protected function getVariables(): array
    {
        return [];
    }
}
