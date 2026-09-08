<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormSubmission extends Model
{
    protected $fillable = [
        'form_type',
        'name',
        'email',
        'phone',
        'clinic',
        'reason',
        'body_area',
        'preferred_date',
        'preferred_time',
        'terms_accepted',
        'status',
        'source_page',
        'ip_address',
        'user_agent',
    ];

    protected function casts(): array
    {
        return [
            'terms_accepted' => 'boolean',
        ];
    }

    public function markAsRead(): void
    {
        if ($this->status === 'new') {
            $this->update(['status' => 'read']);
        }
    }
}
