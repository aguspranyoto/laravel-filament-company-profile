<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class CompanySetting extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'company_name',
        'phone',
        'email',
        'address',
        'footer_description',
        'facebook_url',
        'linkedin_url',
        'twitter_url',
    ];

    public static function instance(): static
    {
        return static::firstOrCreate([], [
            'company_name' => 'Zeroxe Consulting',
        ]);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')
            ->singleFile();
    }
}
