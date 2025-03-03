<?php

namespace Database\Seeders;

use App\Models\Departement;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DepartementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = Storage::disk('local')->get('benin_departments.json');
        $data = collect(json_decode($json));

        foreach ($data as $item) {
            $departement = Departement::create([
                'name' => $item->name
            ]);

            foreach ($item->communes as $itemCommune) {
                $commune = $departement->communes()->create([
                    'name' => $itemCommune->name,
                    'quartiers' => $itemCommune->quartiers ?? null
                ]);

                collect($itemCommune->arrondissements)->each(function ($arrondissement) use ($commune) {
                    $commune->arrondissements()->create([
                        'name' => $arrondissement
                    ]);
                });
            }
        }
    }
}