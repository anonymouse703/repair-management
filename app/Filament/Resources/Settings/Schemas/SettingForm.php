<?php

namespace App\Filament\Resources\Settings\Schemas;

use App\Enums\Setting\Scope;
use App\Enums\Setting\Type;
use App\Models\Setting;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class SettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
           ->components([
                TextInput::make('label')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (string $operation, $state, Set $set) =>
                        $operation === 'create' ?
                            $set('key', Str::snake($state)) : null
                    ),
                Select::make('scope')
                    ->options(Scope::array())
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                Toggle::make('is_readonly'),
                Select::make('type')
                    ->options(Type::array())
                    ->required()
                    ->live()
                    ->afterStateUpdated(fn ($state, Set $set) =>
                        $state == 'json' ? $set('json_type', 'raw') : null
                    )
                    ->afterStateHydrated(function ($state, ?Setting $setting, Set $set) {
                        if ($state == 'json') {
                            $set('json_type', 'raw');
                            if ($setting) {
                                $set('value', json_encode($setting->value));
                            }
                        }
                    }),
                TextInput::make('key')
                    ->columnSpanFull()
                    ->unique(Setting::class, 'key', ignoreRecord: true)
                    ->required()
                    ->hint(fn (string $operation) =>
                    $operation !== 'create' ?
                        'To avoid complications, key should not be edited.' : null
                    )
                    ->disabled(fn (string $operation) => $operation !== 'create'),
                Group::make()
                    ->schema(fn (Get $get): array => match ($get('type')) {
                        'boolean' => [
                            Toggle::make('value')
                                ->default(0)
                        ],
                        'select' => [
                            Textarea::make('options')
                                ->live()
                                ->placeholder('A comma separated options for your select type..')
                                ->required(),
                            Select::make('value')
                                ->options(function (Get $get) {
                                    $string = $get('options');
                                    $array = array_map(function($item) {
                                        return trim($item);
                                    }, explode(',', $string));

                                    return array_combine($array, $array);
                                })
                                ->required(),
                        ],
                        'integer' => [
                            TextInput::make('value')
                                ->integer()
                                ->required()
                        ],
                        'float' => [
                            TextInput::make('value')
                                ->numeric()
                                ->required()
                        ],
                        'datetime' => [
                            DateTimePicker::make('value')
                                ->required()
                        ],
                        'json' => [
                            Section::make([
                                Radio::make('json_type')
                                    ->hiddenLabel()
                                    ->options([
                                        'form-data' => 'form-data',
                                        'raw' => 'raw'
                                    ])
                                    ->inline()
                                    ->inlineLabel(false)
                                    ->live()
                                    ->afterStateUpdated(function ($state, $record, Set $set, Get $get) {
                                        $value = $record?->value ?? $get('value');
                                        if ($state === 'form-data') {
                                            $set('value', is_string($value) ?
                                                json_decode($value, true) : $value
                                            );
                                        }
                                        if ($state === 'raw') {
                                            $set('value', is_string($value) ? $value : json_encode($value));
                                        }
                                    }),
                                Group::make()
                                    ->schema(fn (Get $get): array => match ($get('json_type')) {
                                        'form-data' => [
                                            KeyValue::make('value')
                                                ->required()
                                        ],
                                        'raw' => [
                                            Textarea::make('value')
                                                ->required()
                                                ->json()
                                        ],
                                        default => [
                                        ]
                                    }),
                            ])

                        ],
                        default => [
                            TextInput::make('value')
                                ->required(),
                        ],
                    })
                    ->columnSpanFull(),
            ]);
    }
}
