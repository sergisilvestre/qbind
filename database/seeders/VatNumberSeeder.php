<?php

namespace Database\Seeders;

use App\Models\VatNumber;
use Illuminate\Database\Seeder;

class VatNumberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 50; $i++) {

            do {
                $vatNumber = 'IT' . str_pad(rand(1, 99999999999), 11, '0', STR_PAD_LEFT);

            } while (VatNumber::where('vat_number', $vatNumber)->exists());

            VatNumber::create(['vat_number' => $vatNumber]);
        }
    }
}
