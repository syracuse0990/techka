<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countrySqlPath = public_path('assets/sql/philippine_regions.sql');
        $this->sqlSeeder($countrySqlPath);

        $stateSqlPath = public_path('assets/sql/philippine_barangays.sql');
        $this->sqlSeeder($stateSqlPath);

        $citySqlPath = public_path('assets/sql/philippine_cities.sql');
        $this->sqlSeeder($citySqlPath);

        $citySqlPath = public_path('assets/sql/philippine_provinces.sql');
        $this->sqlSeeder($citySqlPath);
    }

    private function sqlSeeder($sqlPath)
    {

        $sql = file_get_contents($sqlPath);
        $statements = array_filter(array_map('trim', explode(';', $sql)));

        foreach ($statements as $stmt) {
            DB::statement($stmt);
        }
    }
}
