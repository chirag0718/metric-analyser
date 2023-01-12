<?php

namespace App\Http\Controllers;

use App\Services\OutputGenerator;
use Exception;
use Illuminate\Http\Request;

class MetricAnalyserController extends Controller
{
    public function processData(OutputGenerator $outputGenerator)
    {
        try {
            // Read all json files from input folders
            // This input folder can be set in configuration or env
            $input_folder = public_path('/inputs');
            if (!is_dir($input_folder)) {
                throw new Exception("Input folder not found.");
            }
            // This output folder can be set in configuration or env
            $output_folder = public_path('outputs/');
            if (!is_dir($output_folder)) {
                throw new Exception("Output folder not found.");
            }
            $json_files = glob("$input_folder/*.json");
            if (empty($json_files)) {
                throw new Exception("No JSON files found in input folder.");
            }

            foreach ($json_files as $json_file) {

                // Here we can skip if needs but just taking json file for now
                $path_parts  = pathinfo($json_file);
                if (trim($path_parts['extension']) != 'json') {
                    throw new Exception("File is not json: " . $json_file);
                }
                if (!file_exists($json_file)) {
                    throw new Exception("File not found: " . $json_file);
                }
                $dataset = file_get_contents($json_file);
                $outputs = $outputGenerator->generate($dataset);
                file_put_contents(public_path('outputs/' . $path_parts['filename'] . '.output'), $outputs);
                echo 'outputs/' . $path_parts['filename'] . '.output ----success';
                echo "<br>";
            }
        } catch (Exception $e) {
            // log the error message and return an error message to the user
            error_log($e->getMessage());
            return "An error occurred while processing the data. Please try again later.";
        }
    }
}
