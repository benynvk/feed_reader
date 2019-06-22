<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use PDO;


class InitializeDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'initializeDatabase';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $database = env('DB_DATABASE', false);

        //Create database
        $pdo = $this->connectPDO(env('DB_HOST'), env('DB_PORT'), env('DB_USERNAME'), env('DB_PASSWORD'));
        $pdo->exec(sprintf('DROP DATABASE IF EXISTS %s;', $database));
        $pdo->exec(sprintf('CREATE DATABASE IF NOT EXISTS %s CHARACTER SET utf8;', $database));

        //Create table
        Schema::create('categories', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('title');
            $table->timestamps();
        });


        Schema::create('feeds', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('title');
            $table->text('description');
            $table->string('link');
            $table->integer('category_id')->nullable()->unsigned();
            $table->string('comments')->nullable();
            $table->timestamp('publish_date')->nullable();
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories');
        });

        $this->info(sprintf('Successfully created %s database', $database));
    }

    /**
     * @param string $host
     * @param integer $port
     * @param string $username
     * @param string $password
     * @return PDO
     */
    private function connectPDO($host, $port, $username, $password)
    {
        return new PDO(sprintf('mysql:host=%s;port=%d;', $host, $port), $username, $password);
    }
}
