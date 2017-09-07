"# laravel-models" 

## How to use this
Create One folder Called Commands inside App/Console

Drop the ModelsImport in that folder

Go to /app/Console/Kernel.php and add this line:

```
protected $commands = [
   Commands\ModelsImport::class,
];
```

Use composer dumpautoload in order to enable this new class

And then run the command:
```
php artisan models:import databasename
```

This will automatically create all your models under:
app/Models/DatabaseName


Have fun :D
