<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FotoDashboard extends Model
{
    protected $table = 'foto_dashboard';
    protected $fillable = ['nama', 'path', 'urutan'];
}