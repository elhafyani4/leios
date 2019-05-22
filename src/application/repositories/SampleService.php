<?php
namespace application\repositories;

class SampleService implements ISampleService
{
    public function get_sample_record()
    {
        return array(
            "application_name" => "Leios Framework"
        );
    }
    
}
