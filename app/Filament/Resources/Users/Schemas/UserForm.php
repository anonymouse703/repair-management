<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Enums\User\Role;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('username'),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                Select::make('role')
                    ->options(Role::class)
                    ->default('staff')
                    ->required(),
                TextInput::make('password')
                    ->password()
                    ->default(fn() => Str::password(
                        length: 12,
                        letters: true,
                        numbers: true,
                        symbols: true,
                        spaces: false
                    ))
                    ->minLength(8)
                    ->dehydrateStateUsing(fn(string $state): string => Hash::make($state))
                    ->dehydrated(fn(?string $state): bool => filled($state))
                    ->required(fn(string $operation): bool => $operation === 'create')
                    ->revealable()
                    ->rule(
                        Password::min(8)
                            ->letters()
                            ->numbers()
                            ->symbols()
                            ->mixedCase()
                    )
                    ->inlineSuffix()
                    ->copyable(copyMessage: 'Copied!', copyMessageDuration: 1500),
            ]);
    }
}
