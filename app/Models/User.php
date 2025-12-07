<?php

namespace App\Models;

use Filament\Panel;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\MediaLibrary\InteractsWithMedia;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @method static updateOrCreate(array $array, array $user)
 * @method static where(string $string, string $string1)
 * @property mixed $is_active
 */
class User extends Authenticatable implements HasMedia, FilamentUser
{
    use HasRoles;
    use HasFactory;
    use Notifiable;
    use SoftDeletes;
    use SortableTrait;
    use InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'surname',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')->singleFile();
    }

    /**
     * @param Panel $panel
     * @return bool
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasAnyRole(['super_admin']);
    }
}
