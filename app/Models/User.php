<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
// use App\Models\Chat;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'email',
        'avatar',
        'password',
        'status',
    ];

    // public function getRouteKeyName(): string
    // {
    //     return 'slug';
    // }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * @return 一對多的關係
     */
    public function chirps(): HasMany
    {
        return $this->hasMany(Chirp::class);
    }

    /**
     * @return 一對多的關係
     */
    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    /**
     * @return 一對多的關係
     */
    public function chats(): HasMany
    {
        return $this->hasMany(Chat::class);
    }

    /**
     * @return 一對多的關係
     */
    public function ai_draws(): HasMany
    {
        return $this->hasMany(Ai_draw::class);
    }

    /**
     * @return 一對多的關係
     */
    public function chat_assistants(): HasMany
    {
        return $this->hasMany(Chat_assistant::class);
    }

    /**
     * @return 一對一的關係
     */
    public function userDetail(): HasOne
    {
        // return $this->hasOne(UserDetail::class);
        return $this->hasOne(UserDetail::class, 'user_id');
    }

    /**
     * @return 多對多的關係
     */
    public function userTags(): BelongsToMany
    {
        return $this->belongsToMany(UserTag::class, 'user_tag_relations', 'user_slug', 'user_tag_slug', 'slug', 'slug')
            ->withTimestamps();
    }

    /**
     * @return 多對多的關係 - User Categories
     */
    public function userCategories(): BelongsToMany
    {
        return $this->belongsToMany(UserCategory::class, 'user_relation', 'user_slug', 'user_category_slug', 'slug', 'slug')
            ->withTimestamps();
            // ->withPivot('locale')
            // ->using(function ($attributes) {
            //     $attributes['locale'] = app()->getLocale();
            //     return $attributes;
            // });
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->slug)) {
                do {
                    $slug = Str::random(8);
                } while (self::where('slug', $slug)->exists());

                $model->slug = $slug;
            }
        });
    }
}
