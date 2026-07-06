<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class SeoSetting extends Model
{
    use HasFactory;

    protected $table = 'seo_settings';

    protected $fillable = [
        'seoable_type',
        'seoable_id',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical_url',
        'og_title',
        'og_description',
        'og_image',
        'og_type',
        'twitter_card',
        'twitter_title',
        'twitter_description',
        'twitter_image',
        'robots_directive',
        'structured_data',
        'focus_keyword',
        'seo_score',
        'is_active',
    ];

    protected $casts = [
        'meta_keywords' => 'array',
        'structured_data' => 'array',
        'is_active' => 'boolean',
        'seo_score' => 'decimal:2',
    ];

    public function seoable(): MorphTo
    {
        return $this->morphTo();
    }

    public static function getForModel(Model $model): ?self
    {
        return self::where('seoable_type', get_class($model))
            ->where('seoable_id', $model->id)
            ->first();
    }

    public static function createOrUpdateFor(Model $model, array $data): self
    {
        $setting = self::getForModel($model);

        if ($setting) {
            $setting->update($data);
        } else {
            $data['seoable_type'] = get_class($model);
            $data['seoable_id'] = $model->id;
            $setting = self::create($data);
        }

        return $setting;
    }
}
