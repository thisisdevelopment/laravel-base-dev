# thisisdevelopment/laravel-base-dev

Base dev dependencies for thisisdevelopment/laravel-base
This package should only be added as dev-dependency

Currently this installs the following dependencies
- squizlabs/php_codesniffer
- barryvdh/laravel-debugbar
- barryvdh/laravel-ide-helper
- thisisdevelopment/laravel-test-snapshot

Besides the dependencies this package also includes a `vendor/bin/dev` script
which is a helper script to manage a project's docker compose setup

# Domain Boilerplate Code Generation
A few Artisan commands are available for automatic domain code generation. These can be used to setup a new domain more quickly. 

| command                                             | description                                                                    |
|-----------------------------------------------------|--------------------------------------------------------------------------------|
| `make:domain {domain} {model}`                      | main entry to create entire domain                                             |
| `make:domain-abstract-event {domain} {model}`       | generates common event super class                                             |
| `make:domain-event {domain} {model} {type}`         | generate specific event (used by actions)                                      |
| `make:domain-action {domain} {model} {type}`        | generate specific action                                                       |
| `make:domain-dto {domain} {model} {type}`           | generate DTO to be used for either insterting or updating models in repository |
| `make:domain-model {domain} {model}`                | generate the Eloquent model                                                    |
| `make:domain-exception {domain} {model}`            | generate the generic exception                                                 |
| `make:domain-repository-interface {domain} {model}` | generate the repository interface                                              |

## Force option
```
  -f, --force           force generation when class already exists
```
All commands allow you to pass the `--force` option. using this option you can overwrite existing files in your domain. This might be required when upgrading current installments with newer definitions. By default this option is `false`, and commands will fail by saying that the file already exists.

## `make:domain`
This is the main entry point for generating everything. It takes a number of (optional) arguments:
```
  -a, --all             Generate all related files
      --model           generate model
      --repository      generate repository interface
      --exception       generate exception
      --actions         generate all actions
      --create-action   generate create-action
      --update-action   generate update-action
      --delete-action   generate delete-action
      --events          generate model
      --abstract-event  generate abstract-event
      --creating-event  generate creating-event
      --created-event   generate created-event
      --updating-event  generate updating-event
      --updated-event   generate updated-event
      --deleting-event  generate deleting-event
      --deleted-event   generate deleted-event
      --dtos            generate all dtos
      --create-dto      generate create-dto
      --update-dto      generate update-dto
```

This means you can either pass `--all` to generate everything in 1 command, or specify what class you want to generate specifically by using one or more of the other options. 

E.g. to generate only 2 specific actions and a repository for the `Bar` model in the `Foo` domain, run the following command:
``` shell
$ ./artisan make:domain Foo Bar --repository --create-action --delete-action
```

Please beware that all generated code has some expectations about other classes being available. e.g. the `Action`-classes all assume the existance of the `RepositoryInterface`, the `Model` and both the appropriate `Dto` and `Event` classes. This means you can run this command for a single class, but you might need to modify the code afterwards. 

The actions, events and dtos created by `make:domain` are limited to `create(d)`,`udpate(d)` and `delete(d)`. You can create more types, but you'll have to call the `make:domain-* {domain} {model} {type}` manually. e.g.
``` shell
$ ./artisan make:domain-action Foo Bar update-email
$ ./artisan make:domain-event Foo Bar update-email
$ ./artisan make:domain-dto Foo Bar update-email
```

This will generate `Bar\UpdateEmailBarAction`, `Bar\BarUpdateEmailEvent`, and `Bar\UpdateEmailBarDto` classes. 

Running the entire suite will result in the following generated files:
```
app/Domain/{domain}/
  Actions/
    {model}/
      Create{model}Action
      Delete{model}Action
      Update{model}Action
  Dtos/
    {model}/
      Create{model}Dto
      Update{model}Dto
  Events/
    {model}/
      Abstract{model}Event
      {model}CreatingEvent
      {model}CreatedEvent
      {model}UpdatingEvent
      {model}UpdatedEvent
      {model}DeletingEvent
      {model}DeletedEvent
  Exceptions/
    {model}Exception
  Models/
    {model}
  Repositories/
    {model}RepositoryInterface
```
