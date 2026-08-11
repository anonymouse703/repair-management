<?php

namespace App\Models;

use App\Cache\Setting\SettingByKey;
use App\Casts\TimestampAsCarbonObject;
use App\Enums\Setting\Scope;
use App\Enums\Setting\Type;
use App\Models\Traits\GeneratesCreatedTs;
use App\Observers\SettingObserver;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([SettingObserver::class])]
class Setting extends Model
{
    use GeneratesCreatedTs;

    protected $primaryKey = 'key';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'key',
        'value',
        'scope',
        'label',
        'description',
        'type',
        'options',
        'is_readonly',
    ];

    protected $casts = [
        'scope' => Scope::class,
        'type' => Type::class,
        'is_readonly' => 'boolean',
        'created_ts' => TimestampAsCarbonObject::class,
    ];

    /*
    |--------------------------------------------------------------------------
    | Attributes
    |--------------------------------------------------------------------------
    */

    public function optionsArray(): Attribute
    {
        return Attribute::make(
            get: fn () => is_null($this->options) ? null : preg_split("/[\ \n\,]+/", $this->options)
        );
    }

    protected function value(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->castByType($value),
        );
    }

    protected function castByType($value): bool|int|Carbon|string|array|float
    {
        return match ($this->type) {
            Type::Integer => (int) $value,
            Type::Float => (float) $value,
            Type::Boolean => (bool) $value,
            Type::DateTime => Carbon::parse($value),
            Type::Text, Type::Select => (string) $value,
            Type::JSON => json_decode($value, true),
            default => throw new \Exception('Invalid type')
        };
    }

    /*
    |--------------------------------------------------------------------------
    | Custom Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Flushes the model cache.
     */
    public function clearCache(): void
    {
        SettingByKey::forget($this->key);
    }

    public static function getValueValidationRules(string|Type $settingType): array
    {
        if (! ($settingType instanceof Type)) {
            $settingType = Type::tryFrom($settingType);
        }

        return match ($settingType) {
            Type::Boolean => ['required', 'boolean'],
            Type::Integer, Type::Float => ['required', 'numeric'],
            Type::JSON => ['required', 'json'],
            Type::Text, Type::Select => ['required', 'string'],
            default => ['required']
        };
    }
}
