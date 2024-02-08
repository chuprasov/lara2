<?php

namespace Domain\Auth\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Panel;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'remember_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function socials()
    {
        return $this->hasMany(UserSocial::class);
    }

    public function avatar(): Attribute
    {
        return Attribute::make(
            get: fn () => 'https://ui-avatars.com/api/?background=0D8ABC&color=fff&name=' . $this->name
        );
    }

    private function getSocialId(string $socialName): ?string
    {
        $social = $this->hasMany(UserSocial::class)->where('social_name', $socialName)->first();

        $socialId = null;

        if ($social) {
            $socialId = $social->getAttribute('social_id');
        }

        return $socialId;
    }

    private function setSocialId(string $socialName, string $id): void
    {
        $this->socials()->updateOrCreate([
            'social_name' => $socialName,
        ], [
            'social_name' => $socialName,
            'social_id' => $id,
        ]);
    }

    public function getGithubIdAttribute()
    {
        return $this->getSocialId('github');
    }

    public function setGithubIdAttribute(string $id)
    {
        $this->setSocialId('github', $id);
    }

    public function getGoogleIdAttribute()
    {
        return $this->getSocialId('google');
    }

    public function setGoogleIdAttribute(string $id)
    {
        $this->setSocialId('google', $id);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        if (! app()->isProduction()) {
            return true;
        }

        $email = env('MAIL_FROM_ADDRESS');

        $domain = substr($email, strpos($email, '@') + 1);

        return str_ends_with($this->email, '@'.$domain) && $this->hasVerifiedEmail();

    }
}
