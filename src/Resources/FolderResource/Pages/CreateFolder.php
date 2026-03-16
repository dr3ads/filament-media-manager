<?php

namespace TomatoPHP\FilamentMediaManager\Resources\FolderResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use TomatoPHP\FilamentMediaManager\Resources\FolderResource;

class CreateFolder extends CreateRecord
{
    protected static string $resource = FolderResource::class;

    protected function handleRecordCreation(array $data): Model
    {

        $record = new ($this->getModel())($data);

        if ($parentRecord = $this->getParentRecord()) {
            return $this->associateRecordWithParent($record, $parentRecord);
        }

        $record->save();

        return $record;
    }

}
