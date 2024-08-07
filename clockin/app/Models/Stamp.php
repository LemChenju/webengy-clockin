<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stamp extends Model
{
    use HasFactory;

    public mixed $user_id;
    /**
     * @var \Illuminate\Support\Carbon|mixed
     */
    protected $fillable = [
        'user_id',
        'stamped_in_at',
        'stamped_out_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
