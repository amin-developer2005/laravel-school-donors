<?php

namespace App\Filament\Resources\Projects\Pages;

use App\Filament\Resources\Projects\ProjectResource;
use App\Models\Project;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class EditProject extends EditRecord
{
    protected static string $resource = ProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }


    /**
     * @throws ValidationException
     */
    public function validate($rules = null, $messages = [], $attributes = []): array
    {
        $rules['data.space_code'][6] = Rule::unique(Project::class, 'space_code')->ignore($this->record->id);

        return parent::validate($rules, $messages, $attributes);
    }

}
