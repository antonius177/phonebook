<?php
use App\Phone;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class PhonesTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('phones')->delete();

        Phone::create([
            'contact_id' => 5,
            'phone_number' => '081284882905',
        ]);

        Phone::create([
            'contact_id' => 1,
            'phone_number' => '085100576679',
        ]);

        Phone::create([
            'contact_id' => 3,
            'phone_number' => '087880747739',
        ]);

        Phone::create([
            'contact_id' => 2,
            'phone_number' => '085100576679',
        ]);
    }
}