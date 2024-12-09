<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $categories = [
            'Painkillers',
            'Antibiotics',
            'Vitamins and Supplements',
            'Cough and Cold',
            'Antidepressants',
            'Antihistamines',
            'Cardiovascular Medicines',
            'Diabetes Care',
            'Dermatologicals (Skin Care)',
            'Eye Drops and Ointments',
            'Gastrointestinal Medicines',
            'Antifungal Medications',
            'Anti-Inflammatory Drugs',
            'Respiratory Medicines',
            'Pediatric Medicines',
            'Women\'s Health',
            'Men\'s Health',
            'Allergy Relief',
            'Herbal Remedies',
            'First Aid Supplies',
        ];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }
}
