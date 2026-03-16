<?php

namespace TomatoPHP\FilamentMediaManager\Resources\Actions;

use App\Models\Media;
use Filament\Actions;
use Filament\Forms;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Artisan;
use TomatoPHP\FilamentMediaManager\Models\Folder;

class RegenerateConversionAction
{
    public static function make(int $folder_id): Actions\Action
    {
        return Actions\Action::make('regenerate_conversions')
            ->mountUsing(function () use ($folder_id) {
                session()->put('folder_id', $folder_id);
            })
            ->hiddenLabel()
            ->icon('heroicon-o-arrow-path-rounded-square')
            ->requiresConfirmation()
            ->action(function (array $data) use ($folder_id) {
                $model = config('filament-media-manager.model.folder');

                $folder = $model::find($folder_id);

                if ($folder) {
                    $media = Media::where('collection_name', $folder->collection)->pluck('id')->toArray();

                   Artisan::call('media-library:regenerate --force --ids='. implode(',', $media));

                }

                Notification::make()->title('Folder media conversion regenerated.')->send();
            });
    }
}
