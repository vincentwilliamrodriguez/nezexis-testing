<?php

namespace Modules\ClientManagement\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\ClientManagement\Models\MainCompany;

class MainCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MainCompany::factory()->firstCompany()->create();
        MainCompany::factory()->count(3)->create();
    }
}
