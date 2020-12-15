<?php
/**
 * Created by PhpStorm.
 * User: ermolaev
 * Date: 10.12.2020
 * Time: 16:07
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';

    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
    ];

    public function getStatus(){
        return $this->session != null? 'In system':'Is not in system';
    }
}