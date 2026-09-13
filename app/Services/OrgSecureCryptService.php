<?php

namespace App\Services;

use Hashids\Hashids;
use Illuminate\Contracts\Encryption\DecryptException;


class OrgSecureCryptService
{

    // Generate a keyed hash value using the HMAC method using the app_key and org_Id
    private static function getHashids(): Hashids
    {
        // استخدام مفتاح النظام السري كـ Salt موحد لجميع المنظمات
        $salt = hash_hmac('sha256', 'organization_public_tokens', config('app.key'));
        return new Hashids($salt, 20);
    }
    /**
     * encode the org_id to unique and short code
     */
    public static function encrypt(int $orgId): string
    {
        return self::getHashids()->encode($orgId);
    }

    /**
     * decoded and verification
     */
    public static function decrypt(string $code): ?int
    {
        try {
            $decoded = self::getHashids()->decode($code);

            return !empty($decoded) ? $decoded[0] : null;

        } catch (DecryptException $e) {
            return null; // فشل التشفير أو التلاعب بالكود
        }
    }
}
