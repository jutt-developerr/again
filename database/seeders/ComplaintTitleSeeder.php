<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin\ComplaintTitle;

class ComplaintTitleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    protected $complaint_title = [
    ['user_type' => 'User',
    'title' => 'Driver Rash Driving',
    'complaint_type' => 'request_help',
    'active' => 1,
    ],
    ['user_type' => 'User',
    'title' => 'Vehicle Not Clean',
    'complaint_type' => 'general',
    'active' => 1,
    ],
    ['user_type' => 'Driver',
    'title' => 'User Not Receive Calls',
    'complaint_type' => 'general',
    'active' => 1,
    ],
    ['user_type' => 'Driver',
    'title' => 'User Not In PickUp Point',
    'complaint_type' => 'request_help',
    'active' => 1,
    ]
    ];


    public function run()
    {
     
     $created_params = $this->complaint_title;

     $value = ComplaintTitle::first();


     if(is_null($value))
     {
       foreach ($created_params as $title) 
       {
        ComplaintTitle::create($title);
       }
     }else {
       foreach ($created_params as $title) 
       {
         $value->update($title);
       }
    }
  }
}
