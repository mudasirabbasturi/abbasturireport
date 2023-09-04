<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employee\Action;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_title',
        'project_address',
        'project_client_name',
        'project_client_notes',
        'project_pricing',
        'project_area',
        'project_commercial_residential',
        'project_line_items_pricing',
        'project_floor_number',
        'project_main_scope',
        'project_scope_details',
        'project_template',
        'project_onside_link',
        'project_ofside_link',
        'project_due_date',
        'project_steps',
        'project_notes_onside',
        'project_notes_offside',
        'project_budget',
        'project_deduction',
        'project_total_price',
        'project_status',
    ];

    protected $casts = [
        'project_due_date' => 'datetime'
    ];

    public function actions() {
        return $this->hasMany(Action::class);
    }
}
