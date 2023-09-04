<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Action extends Model
{

    protected $fillable = [
        'project_marking', 
        'project_excel', 
        'project_pricing', 
        'project_quality_assurance'
    ];
    use HasFactory;
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
