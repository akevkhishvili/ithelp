<?php

use Illuminate\Database\Seeder;
use App\Models\CaseOptions;

class DatabaseSeeder extends Seeder {

    public function run()
    {
        $this->call('caseoptionsSeeder');

        $this->command->info('caseoptions table seeded!');

    }

}

class caseoptionsSeeder extends Seeder {

    public function run()
    {
        DB::table('caseoptions')->truncate();
        $cases = array('ტექნიკური პრობლემა აუდიტორიაში',
            'აუდიტორიაში ინტერნეტის გათიშვა',
            'თანამშრომლის ტექნიკური პრობლემა',
            'ტექნიკური პრობლემა Mail_თან დაკავშირებით',
            'moodle_თან დაკავშირებული საკითხი');

        foreach ($cases as $case){
            caseOptions::create(
                ['caseName' => $case]
            );
        }
    }
}

