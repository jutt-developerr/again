<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin\Faq;


class FaqSeeder extends Seeder
{

    protected $faq = [
        ['user_type' => 'User',
            'question' => 'How To Book Ride ',
            'answer' => 'Select Your Drop Location and click On Ride now',
            'active' => 1,
        ],
        ['user_type' => 'User',
            'question' => 'How To Chat With Driver',
            'answer' => 'After Ride Confirm Chat And Call Option Will Show',
            'active' => 1,
        ],
        ['user_type' => 'Driver',
            'question' => 'How To Know About Wallet Balance',
            'answer' => 'Select wallet Option It Shows Your Entire Wallet Details',
            'active' => 1,
        ],
        ['user_type' => 'Driver',
            'question' => 'How To Update Bank Information',
            'answer' => 'Select Update Bank Info Option then change your AC Detalis',
            'active' => 1,
        ],
        ['user_type' => 'Owner',
            'question' => 'How To check About Driver and Vehicle Info',
            'answer' => 'Select Menu Option Manage Driver and Manage Vehicle To Know Detalis ',
            'active' => 1,
        ],
        ['user_type' => 'All',
            'question' => 'How To Add Money To Wallet',
            'answer' => 'Choose Wallet Option To Add Manage Your Wallet Transactions',
            'active' => 1,
        ]
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $created_params = $this->faq;

        $value = FAQ::first();
        if(is_null($value))
        {
            foreach ($created_params as $faq)
            {
                Faq::create($faq);
            }
        }else {
            foreach ($created_params as $faq)
            {
                $value->update($faq);
            }
        }

    }
}
