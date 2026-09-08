<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    protected $table = 'media';

    protected $fillable = [
        'filename',
        'path',
        'disk',
        'mime_type',
        'size',
        'alt',
    ];

    public function url(): string
    {
        if (str_starts_with($this->path, 'images/')) {
            return asset($this->path);
        }

        return Storage::disk($this->disk)->url($this->path);
    }

    public function contentPath(): string
    {
        return $this->path;
    }
}
