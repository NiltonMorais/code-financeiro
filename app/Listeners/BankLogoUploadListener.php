<?php

namespace CodeFin\Listeners;

use CodeFin\Events\BankStoredEvent;
use CodeFin\Models\Bank;
use CodeFin\Repositories\Interfaces\BankRepository;
use Illuminate\Support\Facades\Storage;

class BankLogoUploadListener
{
    /**
     * @var BankRepository
     */
    private $repository;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(BankRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Handle the event.
     *
     * @param  BankStoredEvent $event
     * @return void
     */
    public function handle(BankStoredEvent $event)
    {
        $bank = $event->getBank();
        $logo = $event->getLogo();

        if($logo){
            $file_name = $bank->created_at != $bank->updated_at ? $bank->logo : md5(time().$logo->getClientOriginalName()) . '.' . $logo->guessExtension();
            $destFile = $bank->logos_dir;

            $result = Storage::disk('public')->putFileAs($destFile,$logo,$file_name);

            if($result && $bank->created_at == $bank->updated_at){
                $this->repository->update(['logo'=>$file_name],$bank->id);
            }
        }


    }
}
