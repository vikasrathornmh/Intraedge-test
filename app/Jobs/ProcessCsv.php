<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Exception;
use File;
use App\Models\Student;
use Illuminate\Support\Facades\Event;
use App\Events\jobCompleted;
use Auth;

class ProcessCsv implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Student::query()->truncate();
       // Import CSV to Database
       $filepath = public_path("files/download.csv");
       if (!File::exists($filepath)) {
            throw new Exception('Csv not found.');
       }
       // Reading file
       $file = fopen($filepath,"r");

       $importData_arr = array();
       $i = 0;
       $data = [];
       while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
          $num = count($filedata );
          
          // Skip first row (Remove below comment if you want to skip the first row)
          if($i == 0){
             $i++;
             continue; 
          }
          for ($c=0; $c < $num; $c++) {
             $importData_arr[$i][] = $filedata [$c];
          }
          $i++;
       }
       fclose($file);

       // Insert to MySQL database
       foreach($importData_arr as $importData){

         $insertData = array(
            "uuid"=>$importData[0],
            "name"=>$importData[1],
            "email"=>$importData[2],
            "class"=>$importData[3],
            "school"=>$importData[4],
            "total_score"=>$importData[5],
            "address"=>$importData[6],
            "phone"=>$importData[7],
        );
        $data[] = $insertData;
        }
        Student::insert($data);
        event(new jobCompleted(Auth::user()));
    }
}
