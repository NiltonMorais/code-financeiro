<?php

use CodeFin\Models\Bank;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Storage;

class CreateBankLogoDefault extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $file_name = env("BANK_LOGO_DEFAULT");
        $logo = new \Illuminate\Http\UploadedFile(
            storage_path('app/files/banks/logos/'.$file_name),
            $file_name
        );
        $destFile = Bank::LOGOS_DIR;

        Storage::disk('public')->putFileAs($destFile,$logo,$file_name);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $file_name = env("BANK_LOGO_DEFAULT");
        $filePath = Bank::LOGOS_DIR.'/'.$file_name;
        Storage::disk('public')->delete($filePath);
        echo "** Imagem $file_name deletada\n";
    }
}
