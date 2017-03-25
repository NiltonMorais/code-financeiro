<?php

use CodeFin\Repositories\Interfaces\BankRepository;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBanksData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /** @var BankRepository $repository */
        $repository = app(BankRepository::class);

        foreach($this->getData() as $bankArray){
            $repository->create($bankArray);
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /** @var BankRepository $repository */
        $repository = app(BankRepository::class);

        $filePath = storage_path('/app/public/banks/images/');

        $banks = $repository->all();

        foreach($banks as $bank){
            if(File::exists($filePath.$bank->logo)){
                File::delete($filePath.$bank->logo);
                echo "** Imagem do '$bank->name' deletada: ".$bank->logo."\n";
            }
            $bank->delete();
        }
    }

    public function getData()
    {
        return [
            [
                'name' => 'Bradesco',
                'logo' => new \Illuminate\Http\UploadedFile(
                    storage_path('app/files/banks/logos/bradesco.JPG'),
                    'bradesco.JPG'
                )
            ],
            [
                'name' => 'Banco do Brasil',
                'logo' => new \Illuminate\Http\UploadedFile(
                    storage_path('app/files/banks/logos/brasil.gif'),
                    'brasil.gif'
                )
            ],
            [
                'name' => 'Caixa',
                'logo' => new \Illuminate\Http\UploadedFile(
                    storage_path('app/files/banks/logos/caixa.png'),
                    'caixa.png'
                )
            ],
            [
                'name' => 'Itaú',
                'logo' => new \Illuminate\Http\UploadedFile(
                    storage_path('app/files/banks/logos/itau.jpg'),
                    'itau.jpg'
                )
            ],
            [
                'name' => 'Santander',
                'logo' => new \Illuminate\Http\UploadedFile(
                    storage_path('app/files/banks/logos/santander.png'),
                    'santander.png'
                )
            ],
        ];
    }
}
