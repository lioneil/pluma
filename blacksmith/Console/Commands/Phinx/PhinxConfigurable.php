<?php

namespace Blacksmith\Console\Commands\Phinx;

use Illuminate\Support\Facades\File;
use Phinx\Config\Config as PhinxConfig;
use Symfony\Component\Console\Question\ChoiceQuestion;

trait PhinxConfigurable
{
    /**
     * Sets the Default Phinx Config
     *
     * @param array $modules
     */
    public function setPhinxConfig($modules = null)
    {
        $modules = is_null($modules) ? get_modules_path(true) : $modules;
        $command = $this->getApplication()->find($this->command);
        $environment = $this->environment;
        $migrations = base_path("database/migrations");
        $seeds = base_path("database/seeds");

        switch (get_class($command)) {
            case 'Phinx\Console\Command\Create':
            case 'Phinx\Console\Command\SeedCreate':
                $name = $this->argument('name');
                if ('null' == $name || null == $name) {
                    $name = $this->ask('Please specify the class name (e.g. CreateQuestsTable, UsersTableSeeder)');
                    $this->input->setArgument('name', $name);
                }

                $question = "Which module do you want to save this <info>$name</info> migration?";
                $module = $this->choice($question, $modules);
                $module = get_module($module);

                $migrations = "$module/database/migrations";
                if (! is_dir($migrations)) {
                    File::makeDirectory($migrations, 0755, true, true);
                }

                $seeds = "$module/database/seeds";
                if (! is_dir($seeds)) {
                    File::makeDirectory($seeds, 0755, true, true);
                }

                break;

            case 'Phinx\Console\Command\Migrate':
                $migrations = array();
                foreach ($modules as $module) {
                    $migrations[] = "$module/database/migrations";
                }
                break;

            case 'Phinx\Console\Command\SeedRun':
                $seeds = array();
                foreach ($modules as $module) {
                    $seeds[] = "$module/database/seeds";
                }
                break;

            default:
                break;
        }

        $connection = config('database.default');
        $driver = config("database.connections.$connection.driver", env('DB_CONNECTION', 'mysql'));
        $host = config("database.connections.$connection.host", env('DB_HOST', '127.0.0.1'));
        $port = config("database.connections.$connection.port", env('DB_PORT', '3306'));
        $database = config("database.connections.$connection.database", env('DB_DATABASE', 'pluma'));
        $username = config("database.connections.$connection.username", env('DB_USERNAME', 'pluma'));
        $password = config("database.connections.$connection.password", env('DB_PASSWORD', 'pluma'));
        $charset = config("database.connections.$connection.charset", env('DB_CHARSET', 'utf8'));

        $config = new PhinxConfig([
            'environments' => [
                'default_migration_table' => config('database.migrations', 'migrations'),
                'default_database'        => $environment,
                $environment              => [
                    'adapter' => $driver,
                    'host' => $host,
                    'name' => $database,
                    'user' => $username,
                    'pass' => $password,
                    'port' => $port,
                    'charset' => $charset,
                ],
            ],
            'paths' => [
                'migrations' => $migrations,
                'seeds'      => $seeds,
            ],
            'templates' => [
                'file' => base_path('blacksmith/templates/migrations/updown-migration.stub'),
            ],
        ]);

        $command->setConfig($config);
    }
}
