<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Operation;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('Firstname')->string()->required(),
                TextInput::make('surname')->string()->required(),
                TextInput::make('Email')->email()->required(),
                TextInput::make('password')->password()->required()
                    ->visibleOn(Operation::Create),
            ]);
    }
}
