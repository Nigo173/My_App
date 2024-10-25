<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabelModel extends Model
{
    protected $table = 'label';
    protected $fillable = [
                            'id',
                            'l_Id',
                            'l_Title',
                            'l_TitleOne',
                            'l_TitleTwo',
                            'l_TitleThree',
                            'l_TitleFour',
                            'created_at',
                            'updated_at'
                            ];
}
