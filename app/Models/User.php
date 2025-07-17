<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserLevel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


/**
 *
 *
 * @property int                             $id
 * @property string                          $name
 * @property string                          $email
 * @property bool                            $is_admin
 * @property UserLevel                       $user_level
 * @property int|null                        $email_verified_at
 * @property string                          $password
 * @property string|null                     $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed                      $created_diff Created at diff for human-readable format
 * @property-read \App\Models\TFactory|null  $use_factory
 * @property-read int|null                   $notifications_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int,
 *                \Illuminate\Notifications\DatabaseNotification> $notifications
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIsAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUserLevel($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'birth_date',
        'name',
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

    protected $casts = [
        'is_admin' => 'boolean',
        'user_level' => UserLevel::class,
        'email_verified_at' => 'timestamp',
        'password' => 'hashed',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
//    protected function casts(): array
//    {
//        return [
//            'is_admin' => 'boolean',
//            'email_verified_at' => 'date:m/d/Y',
//            'password' => 'hashed',
//        ];
//    }

    /**
     * @return Attribute
     */
    protected function createdDiff(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->created_at->diffForHumans(),
        );
    }

    //Accessors Old Syntax
//    public function getCreatedDiffAttribute(): string
//    {
//        return $this->created_at->diffForHumans();
//    }

    protected function firstName(): Attribute
    {
        return Attribute::make(
            set: fn($value) => ucfirst($value),
        );
    }

    protected function birthDate(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Carbon::parse($value)->format('m/d/Y'),
            set: fn($value) => Carbon::parse($value)->format('Y-m-d')
        );
    }
}
