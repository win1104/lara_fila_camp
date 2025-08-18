<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserDetail extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'slug',
        'type',
        'sn',
        'pid',
        'firstname',
        'lastname',
        'gender',
        'birthday',
        'phone',
        'mobile',
        'fax',
        'fb_id',
        'line_id',
        'website',
        'country',
        'city',
        'district',
        'zip',
        'address',
        'company',
        'company_no',
        'position',
        'job_title',
        'education',
        'note',
        'verify',
        'verify_code',
        'frozen',
        'check',
        'login_count',
        'expired',
    ];

    protected $casts = [
        'birthday' => 'date',
        'verify' => 'boolean',
        'frozen' => 'boolean',
        'check' => 'boolean',
        'login_count' => 'integer',
        'expired' => 'datetime',
    ];

    /**
     * @return 屬於一對一的關係
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
