<?php

use CodeFin\Repositories\ClientRepositoryEloquent;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clientRepository = app(ClientRepositoryEloquent::class);
        $clients = $clientRepository->all();

        factory(\CodeFin\Models\User::class,1)
            ->states('admin')->create([
                'name' => 'Admin',
                'email'=>'admin@user.com'
            ]);

        foreach(range(1,50) as $value){
            factory(\CodeFin\Models\User::class,1)
                ->create([
                    'name' => "Client da silva n$value",
                    'email'=> "client$value@user.com"
                ])->each(function($user)use($clients){
                    $client = $clients->random();
                    $user->client()->associate($client);
                    $user->save();
                });
        }
    }
}
