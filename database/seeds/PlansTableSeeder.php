<?php

use Illuminate\Database\Seeder;

class PlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\CodeFin\Models\Plan::class)->create([
            'name' => 'Plano Empresarial',
            'description' => 'Plano Empresarial para CodeFinanceiro',
            'value' => 40.00,
            'code'  => 'plan_business'
        ]);
    }
}
