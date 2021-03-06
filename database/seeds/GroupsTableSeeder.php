<?php
use App\Group;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class GroupsTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('groups')->delete();

        Group::create([
            'user_id' => 1,
            'name' => 'keluarga',
            'description' => 'my family'
        ]);

        Group::create([
            'user_id' => 1,
            'name' => 'teman',
            'description' => 'my friends'
        ]);
    }
}