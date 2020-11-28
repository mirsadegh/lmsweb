<?php

namespace Sadegh\User\Models;


use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Sadegh\Course\Models\Course;
use Sadegh\Course\Models\Season;
use Sadegh\Media\Models\Media;
use Sadegh\RolePermissions\Models\Role;
use Sadegh\User\Notifications\ResetPasswordRequestNotification;
use Sadegh\User\Notifications\verifyMailNotification;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;
    use HasRoles;

    const STATUS_ACTIVE = "active";
    const STATUS_INACTIVE = "inactive";
    const STATUS_BAN = "ban";

    public static $statuses = [
        self::STATUS_ACTIVE,
        self::STATUS_INACTIVE,
        self::STATUS_BAN,
    ];

    public static $defaultUser =
        [
          [
              'name'     => 'Admin',
              'email'    => 'admin@gmail.com',
              'password' => 'demo',
              'role'     => Role::ROLE_SUPER_ADMIN,
          ],
        ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'mobile',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendEmailVerificationNotification()
    {
        $this->notify(new verifyMailNotification());
    }

    public function sendResetPasswordRequestNotification()
    {
        $this->notify(new ResetPasswordRequestNotification());
    }


    public function image()
    {
        return $this->belongsTo(Media::class, 'image_id');
    }


    public function courses()
    {
        return $this->hasMany(Course::class,'teacher_id');
    }

    public function seasons()
    {
        return $this->hasMany(Season::class);
    }

    public function profilePath()
    {
        return $this->username ? route('viewProfile',$this->username) : route('viewProfile' ,'username');
    }

    public function getThumbAttribute()
    {
        if ($this->image)
        return '/storage/'. $this->image->files[300];

        return '/panel/img/profile.jpg';
    }

}

