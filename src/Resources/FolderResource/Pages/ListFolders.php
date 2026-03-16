<?php

namespace TomatoPHP\FilamentMediaManager\Resources\FolderResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Support\Facades\Storage;
use TomatoPHP\FilamentMediaManager\Resources\FolderResource;

class ListFolders extends ManageRecords
{
    protected static string $resource = FolderResource::class;

    protected function getHeaderActions(): array
    {

        return [
            Actions\CreateAction::make()
                ->using(function (array $data){
                    $model = config('filament-media-manager.model.folder');

                    $folder =  new $model($data);

                    Storage::disk('s3')->makeDirectory($folder->name);

                    $folder->save();
                    return $folder;
                })
        ];
    }

    public function mount(): void
    {
        parent::mount();

        session()->forget('folder_id');
        session()->forget('folder_password');
    }
}
