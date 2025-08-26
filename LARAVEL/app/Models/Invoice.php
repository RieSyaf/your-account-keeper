<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $primaryKey = 'invoice_id'; // Custom primary key

    protected $fillable = [
        'user_id',
        'invoice_num',
        'date',
        'due_date',
        'sender_name',
        'sender_add',
        'receiver_add',
        'phone_num',
        'email',
        'website',
        'bank_name',
        'account_num',
        'total_price',
        'template',
        'payment_status',
    ];

    public function items()
    {
        return $this->hasMany(Item::class, 'invoice_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function updateOverduePendingInvoices($userId)
    {
        self::where('user_id', $userId)
            ->where('payment_status', 'pending')
            ->where('due_date', '<', now())
            ->update(['payment_status' => 'unpaid']);
    }

}

