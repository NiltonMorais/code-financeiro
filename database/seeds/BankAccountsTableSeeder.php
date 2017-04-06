<?php

use CodeFin\Repositories\Interfaces\BankRepository;
use CodeFin\Repositories\Interfaces\ClientRepository;
use Illuminate\Database\Seeder;

class BankAccountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $banks = $this->getBanks();
        $clients = $this->getClients();
        $max = 50;
        $bankAccountId = rand(1, $max);

        factory(\CodeFin\Models\BankAccount::class, $max)
            ->make()
            ->each(function ($bankAccount) use ($banks, $bankAccountId, $clients) {
                $bank = $banks->random();
                $client = $clients->random();
                $bankAccount->bank_id = $bank->id;
                $bankAccount->client_id = $client->id;

                $bankAccount->save();

                if ($bankAccountId == $bankAccount->id) {
                    $bankAccount->default = 1;
                    $bankAccount->save();
                }
            });

    }

    private function getBanks()
    {
        /** @var BankRepository $repository */
        $repository = app(BankRepository::class);
        $repository->skipPresenter(true);
        return $repository->all();
    }

      private function getClients()
    {
        /** @var ClientRepository $repository */
        $repository = app(ClientRepository::class);
        $repository->skipPresenter(true);
        return $repository->all();
    }


}
