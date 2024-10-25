<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminsModel extends Model
{
    protected $table = 'admins';
    protected $fillable = [
                            'a_Id',
                            'a_PassWord',
                            'a_Name',
                            'a_Permissions',
                            'a_Level',
                            'a_Mac',
                            'a_State',
                            'created_at',
                            'updated_at'
                            ];
}
