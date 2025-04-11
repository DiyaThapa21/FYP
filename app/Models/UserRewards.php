<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRewards extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'reward_point', 'total_expenses', 'type'];
}
