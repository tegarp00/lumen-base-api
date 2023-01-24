<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Auth\Authorizable;

class Admin extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    use HasFactory;
    public $guarded = ["id"];
    protected $table = "admin";

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($admin) {
            $hash = Hash::make($admin->password);
            $admin->password = $hash;
        });

        self::updating(function($admin) {
            if($admin->isDirty(["password"])) {
                $hash = Hash::make($admin->password);
                $admin->password = $hash;
            }
        });
    }
}
