<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->call('UserTableSeeder');

        $this->command->info('UserTableSeeder table seeded!');
    }
}
class UserTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();

        User::create(
            ['name' => 'ithelp', 'status' => 'CaseBoardTV', 'supportteam_id' => '1', 'email' => 'ithelp@cu.edu.ge', 'password' => bcrypt('123456')]
        );
    }

}
