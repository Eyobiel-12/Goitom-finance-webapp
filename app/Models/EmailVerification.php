<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

final class EmailVerification extends Model
{
    protected $fillable = [
        'email',
        'otp_code',
        'expires_at',
        'is_used',
    ];

    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
            'is_used' => 'boolean',
        ];
    }

    public function isValid(): bool
    {
        return !$this->is_used && $this->expires_at->isFuture();
    }

    public function markAsUsed(): void
    {
        $this->update(['is_used' => true]);
    }

    public static function generateForEmail(string $email): self
    {
        // Mark old verifications as used
        self::where('email', $email)->where('is_used', false)->update(['is_used' => true]);

        // Generate 6-digit OTP
        $otp = str_pad((string) rand(100000, 999999), 6, '0', STR_PAD_LEFT);

        return self::create([
            'email' => $email,
            'otp_code' => $otp,
            'expires_at' => Carbon::now()->addMinutes(10),
        ]);
    }
}

