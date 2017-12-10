Change all namespaces by command, this command read composer json and change all files on folder by namespace specs...

#### Requirements
PHP \>= 7.x


##### How to use
```
composer require marcosadantas/spacenames
```

```
require __DIR__.'/vendor/autoload.php';

\Spacenames\Core::changeNamespace('AuthExpressive\\', 'App\\', true);
```

This command is for CLI.
