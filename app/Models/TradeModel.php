<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TradeModel extends Model
{
    protected $table = 'trade';
    protected $fillable = [
                            't_Id',
                            't_aId',
                            't_aName',
                            't_lId',
                            't_lTitle',
                            't_mId',
                            't_mCardId',
                            't_mName'
                            // 't_Content',
                            // 't_Money',
                            // 't_PayDateTime',
                            // 't_Remark'
                            ];

}
