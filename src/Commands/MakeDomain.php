<?php

namespace ThisIsDevelopment\LaravelBaseDev\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class MakeDomain extends Command
{
    protected $name = 'make:domain';

    protected $description = 'Create a new domain-model class';

    public function handle()
    {
        // model
        if ($this->wantsOneOf(['all', 'model'])) {
            $this->createModel();
        }

        // exception
        if ($this->wantsOneOf(['all', 'exception'])) {
            $this->createException();
        }

        // dtos
        if ($this->wantsOneOf(['all', 'dtos', 'create-dto'])) {
            $this->createDto('create');
        }
        if ($this->wantsOneOf(['all', 'dtos', 'update-dto'])) {
            $this->createDto('update');
        }

        // repository interface
        if ($this->wantsOneOf(['all', 'repository'])) {
            $this->createRepositoryInterface();
        }

        // actions
        if ($this->wantsOneOf(['all', 'actions', 'create-action'])) {
            $this->createAction('create');
        }
        if ($this->wantsOneOf(['all', 'actions', 'update-action'])) {
            $this->createAction('update');
        }
        if ($this->wantsOneOf(['all', 'actions', 'delete-action'])) {
            $this->createAction('delete');
        }

        // events
        if ($this->wantsOneOf(['all', 'events', 'abstract-event'])) {
            $this->createAbstractEvent();
        }
        if ($this->wantsOneOf(['all', 'events', 'creating-event'])) {
            $this->createEvent('creating');
        }
        if ($this->wantsOneOf(['all', 'events', 'created-event'])) {
            $this->createEvent('created');
        }
        if ($this->wantsOneOf(['all', 'events', 'updating-event'])) {
            $this->createEvent('updating');
        }
        if ($this->wantsOneOf(['all', 'events', 'updated-event'])) {
            $this->createEvent('updated');
        }
        if ($this->wantsOneOf(['all', 'events', 'deleting-event'])) {
            $this->createEvent('deleting');
        }
        if ($this->wantsOneOf(['all', 'events', 'deleted-event'])) {
            $this->createEvent('deleted');
        }

        return null;
    }

    private function wantsOneOf(array|string $options): bool
    {
        return in_array(true, array_filter((array)$options, fn ($opt) => $this->option($opt)));
    }

    protected function getOptions(): array
    {
        return [
            ['force', 'f', InputOption::VALUE_NONE, 'force generation when class already exists'],
            ['all', 'a', InputOption::VALUE_NONE, 'Generate all related files'],

            ['model', null, InputOption::VALUE_NONE, 'Generate model'],
            ['repository', null, InputOption::VALUE_NONE, 'Generate repository interface'],
            ['exception', null, InputOption::VALUE_NONE, 'Generate exception'],

            ['actions', null, InputOption::VALUE_NONE, 'Generate all actions'],
            ['create-action', null, InputOption::VALUE_NONE, 'Generate create-action'],
            ['update-action', null, InputOption::VALUE_NONE, 'Generate update-action'],
            ['delete-action', null, InputOption::VALUE_NONE, 'Generate delete-action'],

            ['events', null, InputOption::VALUE_NONE, 'Generate all common events'],
            ['abstract-event', null, InputOption::VALUE_NONE, 'Generate abstract-event'],
            ['creating-event', null, InputOption::VALUE_NONE, 'Generate creating-event'],
            ['created-event', null, InputOption::VALUE_NONE, 'Generate created-event'],
            ['updating-event', null, InputOption::VALUE_NONE, 'Generate updating-event'],
            ['updated-event', null, InputOption::VALUE_NONE, 'Generate updated-event'],
            ['deleting-event', null, InputOption::VALUE_NONE, 'Generate deleting-event'],
            ['deleted-event', null, InputOption::VALUE_NONE, 'Generate deleted-event'],

            ['dtos', null, InputOption::VALUE_NONE, 'Generate all dtos'],
            ['create-dto', null, InputOption::VALUE_NONE, 'Generate create-dto'],
            ['update-dto', null, InputOption::VALUE_NONE, 'Generate update-dto'],
        ];
    }

    protected function getArguments(): array
    {
        return array_filter([
            ['domain', InputArgument::REQUIRED, 'The name of the domain'],
            ['model', InputArgument::REQUIRED, 'The name of the model'],
        ]);
    }

    private function createModel(): int
    {
        return $this->call(MakeDomainModel::class, [
            'domain' => $this->argument('domain'),
            'model' => $this->argument('model'),
            '--force' => $this->option('force'),
        ]);
    }

    private function createException(): int
    {
        return $this->call(MakeDomainException::class, [
            'domain' => $this->argument('domain'),
            'model' => $this->argument('model'),
            '--force' => $this->option('force'),
        ]);
    }

    private function createDto(string $type): int
    {
        return $this->call(MakeDomainDto::class, [
            'domain' => $this->argument('domain'),
            'model' => $this->argument('model'),
            'type' => $type,
            '--force' => $this->option('force'),
        ]);
    }

    private function createRepositoryInterface(): int
    {
        return $this->call(MakeDomainRepositoryInterface::class, [
            'domain' => $this->argument('domain'),
            'model' => $this->argument('model'),
            '--force' => $this->option('force'),
        ]);
    }

    private function createAction(string $type): int
    {
        return
            $this->call(MakeDomainAction::class, [
                'domain' => $this->argument('domain'),
                'model' => $this->argument('model'),
                'type' => $type,
                '--force' => $this->option('force'),
            ]);
    }

    private function createAbstractEvent(): int
    {
        return $this->call(MakeDomainAbstractEvent::class, [
            'domain' => $this->argument('domain'),
            'model' => $this->argument('model'),
            '--force' => $this->option('force'),
        ]);
    }

    private function createEvent(string $event): int
    {
        return $this->call(MakeDomainEvent::class, [
            'domain' => $this->argument('domain'),
            'model' => $this->argument('model'),
            'type' => $event,
            '--force' => $this->option('force'),
        ]);
    }
}
