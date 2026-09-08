<?php

namespace App\Services;

use Hashids\Hashids;
use Illuminate\Contracts\Encryption\DecryptException;


class OrgSecureCryptService
{

    // Generate a keyed hash value using the HMAC method using the app_key and org_Id
    private static function getSalt(int $orgId): string
    {
        return hash_hmac('sha256', "org_salt_{$orgId}", config('app.key'));
    }
    /**
     * encode the org_id to unique and short code
     */
    public static function encrypt(int $orgId , int $minLength = 20 ): string
    {
        $hashids = new Hashids(self::getSalt($orgId), $minLength);
        return $hashids->encode($orgId);    }

    /**
     * decoded and verification
     */
    public static function decrypt(string $code, int $targetOrgId, int $minLength = 20): ?int
    {
        try {
            $hashids = new Hashids(self::getSalt($targetOrgId) , $minLength);
            $decoded = $hashids->decode($code);

            return !empty($decoded) ? $decoded[0] : null;

        } catch (DecryptException $e) {
            return null; // فشل التشفير أو التلاعب بالكود
        }
    }
}
