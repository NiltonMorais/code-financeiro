<?php

use CodeFin\Repositories\Interfaces\BillReceiveRepository;
use Illuminate\Database\Seeder;

class BillReceivesTableSeeder extends Seeder
{
    use \CodeFin\Repositories\Traits\GetClientsTrait;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clients = $this->getClients();

        $repository = app(BillReceiveRepository::class);

        factory(\CodeFin\Models\BillReceive::class, 200)
            ->make()
            ->each(function ($model) use ($clients, $repository) {
                $client = $clients->random();
                \Landlord::addTenant($client);
                $bankAccount = $client->bankAccounts->random();
                $category = $client->categoryRevenues->random();
                $model->client_id = $client->id;
                $model->bank_account_id = $bankAccount->id;
                $model->category_id = $category->id;
                $data = $model->toArray();
                $repository->create($data);
            });
    }

}
