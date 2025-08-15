<?php

namespace App\Models\Concerns;

use Illuminate\Support\Str;

trait HasUuid
{
    /**
     * Automatically set a UUID on create.
     *
     * Laravel will call this method automatically when the trait is used.
     */
    protected static function bootHasUuid(): void
    {
        static::creating(function ($model): void {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }
}
