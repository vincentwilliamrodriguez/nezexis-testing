<?php

namespace Modules\ClientManagement\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\ClientManagement\Models\Branch;
use Modules\ClientManagement\Models\Location;
use Modules\ClientManagement\Models\MainCompany;
use Modules\ClientManagement\Models\Status;

class ClientManagementDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        MainCompany::truncate();
        Branch::truncate();
        Location::truncate();
        Status::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');


        $defaultStatusValues = [
            'active',
            'for closure',
            'closed',
            'dropped',
        ];

        foreach ($defaultStatusValues as $value) {
            Status::insert([
                'name' => $value
            ]);
        }


        $this->call([
            MainCompanySeeder::class,
            BranchSeeder::class,
            LocationSeeder::class,
        ]);
    }
}
