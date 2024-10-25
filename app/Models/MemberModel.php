<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberModel extends Model
{
    protected $table = 'member';
    protected $fillable = [
                            'm_Id',
                            'm_CardId',
                            'm_Name',
                            'm_Birthday',
                            'm_Address',
                            'm_Email',
                            'm_Phone',
                            'm_Img',
                            'm_Remark',
                            'created_at',
                            'updated_at'
                            ];
}
