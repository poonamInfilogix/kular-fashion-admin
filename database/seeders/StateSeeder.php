<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\State;

class StateSeeder extends Seeder
{
    public function run()
    {
        $states = [
            // England
            ['name' => 'Greater London', 'country_id' => '184'],
            ['name' => 'West Midlands', 'country_id' => '184'],
            ['name' => 'Greater Manchester', 'country_id' => '184'],
            ['name' => 'Merseyside', 'country_id' => '184'],
            ['name' => 'South Yorkshire', 'country_id' => '184'],
            ['name' => 'Tyne and Wear', 'country_id' => '184'],
            ['name' => 'West Yorkshire', 'country_id' => '184'],
            ['name' => 'Lancashire', 'country_id' => '184'],
            ['name' => 'Kent', 'country_id' => '184'],
            ['name' => 'Surrey', 'country_id' => '184'],
            ['name' => 'Essex', 'country_id' => '184'],
            ['name' => 'Hampshire', 'country_id' => '184'],
            ['name' => 'Dorset', 'country_id' => '184'],
            ['name' => 'Suffolk', 'country_id' => '184'],
            ['name' => 'Norfolk', 'country_id' => '184'],
            ['name' => 'Devon', 'country_id' => '184'],
            ['name' => 'Cornwall', 'country_id' => '184'],
            ['name' => 'Gloucestershire', 'country_id' => '184'],
            ['name' => 'Oxfordshire', 'country_id' => '184'],
            ['name' => 'Berkshire', 'country_id' => '184'],
            ['name' => 'Buckinghamshire', 'country_id' => '184'],
            ['name' => 'Bedfordshire', 'country_id' => '184'],
            ['name' => 'Hertfordshire', 'country_id' => '184'],
            ['name' => 'Cambridgeshire', 'country_id' => '184'],
            ['name' => 'Lincolnshire', 'country_id' => '184'],
            ['name' => 'Nottinghamshire', 'country_id' => '184'],
            ['name' => 'Derbyshire', 'country_id' => '184'],
            ['name' => 'Leicestershire', 'country_id' => '184'],
            ['name' => 'Staffordshire', 'country_id' => '184'],
            ['name' => 'Warwickshire', 'country_id' => '184'],
            ['name' => 'Worcestershire', 'country_id' => '184'],
            ['name' => 'Shropshire', 'country_id' => '184'],
            ['name' => 'Herefordshire', 'country_id' => '184'],
            ['name' => 'North Yorkshire', 'country_id' => '184'],
            ['name' => 'East Riding of Yorkshire', 'country_id' => '184'],
            ['name' => 'South Yorkshire', 'country_id' => '184'],
            ['name' => 'Tyne and Wear', 'country_id' => '184'],
            ['name' => 'Cheshire', 'country_id' => '184'],
            ['name' => 'Merseyside', 'country_id' => '184'],
        
            // Scotland
            ['name' => 'Central Scotland', 'country_id' => '184'],
            ['name' => 'Dumfries and Galloway', 'country_id' => '184'],
            ['name' => 'Edinburgh', 'country_id' => '184'],
            ['name' => 'Fife', 'country_id' => '184'],
            ['name' => 'Glasgow', 'country_id' => '184'],
            ['name' => 'Highland', 'country_id' => '184'],
            ['name' => 'Lanarkshire', 'country_id' => '184'],
            ['name' => 'Lothian', 'country_id' => '184'],
            ['name' => 'North Ayrshire', 'country_id' => '184'],
            ['name' => 'South Ayrshire', 'country_id' => '184'],
            ['name' => 'Tayside', 'country_id' => '184'],
            ['name' => 'West Dunbartonshire', 'country_id' => '184'],
            ['name' => 'East Dunbartonshire', 'country_id' => '184'],
            ['name' => 'Stirling', 'country_id' => '184'],
            ['name' => 'Perth and Kinross', 'country_id' => '184'],
        
            // Wales
            ['name' => 'North Wales', 'country_id' => '184'],
            ['name' => 'South Wales', 'country_id' => '184'],
            ['name' => 'Mid Wales', 'country_id' => '184'],
            ['name' => 'West Wales', 'country_id' => '184'],
            ['name' => 'Powys', 'country_id' => '184'],
            ['name' => 'Gwynedd', 'country_id' => '184'],
            ['name' => 'Anglesey', 'country_id' => '184'],
            ['name' => 'Conwy', 'country_id' => '184'],
            ['name' => 'Denbighshire', 'country_id' => '184'],
            ['name' => 'Flintshire', 'country_id' => '184'],
            ['name' => 'Wrexham', 'country_id' => '184'],
            ['name' => 'Ceredigion', 'country_id' => '184'],
            ['name' => 'Pembrokeshire', 'country_id' => '184'],
            ['name' => 'Carmarthenshire', 'country_id' => '184'],
            ['name' => 'Neath Port Talbot', 'country_id' => '184'],
            ['name' => 'Swansea', 'country_id' => '184'],
            ['name' => 'Cardiff', 'country_id' => '184'],
            ['name' => 'Vale of Glamorgan', 'country_id' => '184'],
        
            // Northern Ireland
            ['name' => 'Antrim', 'country_id' => '184'],
            ['name' => 'Armagh', 'country_id' => '184'],
            ['name' => 'Down', 'country_id' => '184'],
            ['name' => 'Fermanagh', 'country_id' => '184'],
            ['name' => 'Londonderry', 'country_id' => '184'],
            ['name' => 'Tyrone', 'country_id' => '184'],

            //India
            ['name' => 'Andhra Pradesh', 'country_id' => '76'],
            ['name' => 'Arunachal Pradesh', 'country_id' => '76'],
            ['name' => 'Assam', 'country_id' => '76'],
            ['name' => 'Bihar', 'country_id' => '76'],
            ['name' => 'Chhattisgarh', 'country_id' => '76'],
            ['name' => 'Goa', 'country_id' => '76'],
            ['name' => 'Gujarat', 'country_id' => '76'],
            ['name' => 'Haryana', 'country_id' => '76'],
            ['name' => 'Himachal Pradesh', 'country_id' => '76'],
            ['name' => 'Jharkhand', 'country_id' => '76'],
            ['name' => 'Karnataka', 'country_id' => '76'],
            ['name' => 'Kerala', 'country_id' => '76'],
            ['name' => 'Madhya Pradesh', 'country_id' => '76'],
            ['name' => 'Maharashtra', 'country_id' => '76'],
            ['name' => 'Manipur', 'country_id' => '76'],
            ['name' => 'Meghalaya', 'country_id' => '76'],
            ['name' => 'Mizoram', 'country_id' => '76'],
            ['name' => 'Nagaland', 'country_id' => '76'],
            ['name' => 'Odisha', 'country_id' => '76'],
            ['name' => 'Punjab', 'country_id' => '76'],
            ['name' => 'Rajasthan', 'country_id' => '76'],
            ['name' => 'Sikkim', 'country_id' => '76'],
            ['name' => 'Tamil Nadu', 'country_id' => '76'],
            ['name' => 'Telangana', 'country_id' => '76'],
            ['name' => 'Tripura', 'country_id' => '76'],
            ['name' => 'Uttar Pradesh', 'country_id' => '76'],
            ['name' => 'Uttarakhand', 'country_id' => '76'],
            ['name' => 'West Bengal', 'country_id' => '76'],
            ['name' => 'Andaman and Nicobar Islands', 'country_id' => '76'],
            ['name' => 'Chandigarh', 'country_id' => '76'],
            ['name' => 'Dadra and Nagar Haveli and Daman and Diu', 'country_id' => '76'],
            ['name' => 'Lakshadweep', 'country_id' => '76'],
            ['name' => 'Delhi', 'country_id' => '76'],
            ['name' => 'Puducherry', 'country_id' => '76'],
            ['name' => 'Ladakh', 'country_id' => '76'],
            ['name' => 'Jammu and Kashmir', 'country_id' => '76'],
        ];

        foreach ($states as $state) {
            State::create($state);
        }
    }
}
