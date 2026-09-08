<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentEntry extends Model
{
    protected $fillable = [
        'page',
        'key',
        'type',
        'value',
    ];

    public function decodedValue(): mixed
    {
        if ($this->type === 'json') {
            return json_decode($this->value ?? '[]', true) ?? [];
        }

        return $this->value ?? '';
    }
}
