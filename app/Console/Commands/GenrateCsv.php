<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Response;
use File;
use App\Models\User;
use Faker\Factory as Faker;
use Symfony\Component\Console\Command\Command as SymfonyCommand;

class GenrateCsv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'csv:generate {rows}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make the request to create a csv file';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->faker = Faker::create();
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $numOfRows = $this->argument('rows');
        if(!$numOfRows) {
            $this->info("Num of rows need to specify.");
            return 1;
        }
        if(!is_numeric($numOfRows)) {
            $this->info("Num of rows should only integer.");
            return 1;
        }
        $headers = array(
            'Content-Type' => 'text/csv'
          );
          if (!File::exists(public_path()."/files")) {
              File::makeDirectory(public_path() . "/files");
          }
          $filename =  public_path("files/download.csv");
          $handle = fopen($filename, 'w');
          fputcsv($handle, [
              "id",
              "name",
              "email",
              "class",
              "school",
              "total-score",
              "address",
              "phone"
          ]);
          $x = 1;
          while($x <= $numOfRows) {
              fputcsv($handle, [
                  $this->faker->uuid(),
                  $this->faker->name(),
                  $this->faker->email(),
                  $this->faker->text(),
                  $this->faker->city(),
                  $this->faker->randomDigit(),
                  $this->faker->country(),
                  $this->faker->phoneNumber(),
              ]);
            $x++;
          }
          fclose($handle);
          Response::download($filename, "download.csv", $headers);
          $this->info("Command Run Successfully.");
          return SymfonyCommand::SUCCESS;
    }
}
