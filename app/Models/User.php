<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Helper;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'last_name',
        'first_name',
        'username',
        'password',
        'physical_id',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [

    ];

    public static function register($user)
    {
        if (empty($user->username)) {
            $accountData = Helper::generateAuthData($user->first_name, $user->last_name);
            $user->username = $accountData['username'];
            $user->password = $accountData['password'];
        }

        $savedUser = self::create([
            'physical_id' => $user->physical_id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'role_id' => $user->role_id,
            'username' => $user->username,
            'password' => $user->password
        ]);

        return $savedUser;
    }

    public function teacherDetail(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne('App\Models\TeacherDetail');
    }

    public function role(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\Role');
    }

    public function getFullNameAttribute(): string
    {
        return $this->first_name. ' ' .$this->last_name;
    }

    public function getPaddedPhysicalIdAttribute(): string
    {
        return sprintf('%04d', $this->physical_id);
    }

    public function getClassesAttribute()
    {
        $classNames = [];

        $classUsers = ClassUser::where('user_id', $this->id)
            ->groupBy('class_id')
            ->get();

        foreach($classUsers as $classUser) {
            array_push($classNames, $classUser->class->name);
        }

        $classNames = implode(', ', $classNames);

        return $classNames;
    }

    public function getTeachersAttribute()
    {
        $teacherNames = [];
        $classUsers = ClassUser::where('user_id', $this->id)
            ->groupBy('class_id')
            ->get();

        foreach ($classUsers as $classUser) {
            $teacher = ClassUser::join('users', 'users.id', '=', 'class_users.user_id')
                ->where('class_id', $classUser->class_id)
                ->where('users.role_id', config('const.roles.teacher'))
                ->first();

            $full_name = $teacher->first_name . ' ' .$teacher->last_name;
            if (!(in_array($full_name, $teacherNames))) {
                array_push($teacherNames, $full_name);
            }
        }

        $teacherNames = implode(', ', $teacherNames);

        return $teacherNames;
    }

    public function scopeFullNameMatch($query, $nameToCheck) {
        if (!empty($nameToCheck)) {
            $query->whereRaw('CONCAT(users.first_name, " ", users.last_name) LIKE ?',
                ['%' . $nameToCheck . '%']);
        }

        return $query;
    }

    public function scopeClassMatch($query, $classToCheck) {
        if (!empty($classToCheck)) {
            $query->where('c_users.class_id', '=', $classToCheck);
        }
    }
}
