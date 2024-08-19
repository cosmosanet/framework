<?php
namespace Framework\Token;

class JWT
{
    public function jwtGen(array $header, array $payload, $secret): string
    {
        $headerEncoded = $this->base64UrlEncode(json_encode($header));
        $payloadEncoded = $this->base64UrlEncode(json_encode($payload));
        $jwt = $headerEncoded . '.' . $payloadEncoded . '.' . $this->getHS256Signature($payloadEncoded, $payloadEncoded, $secret);

        return $jwt;
    }

    public function jwtVerify(string $jwt, $secret)
    {
        list($headerEncoded, $payloadEncoded, $signatureEncoded) = explode('.', $jwt);
        $signatureVerified = $this->getHS256Signature($payloadEncoded, $payloadEncoded, $secret);
        if ($signatureVerified !== $signatureEncoded) {
            return false;
        }
        $payload = json_decode($this->base64UrlDecode($payloadEncoded), true);
        if (isset($payload['rt']) && $payload['rt'] < time()) {
            return false;
        }

        return $payload;
    }

    public function getSecret(int $bytesCount = 32)
    {
        return $this->base64UrlEncode(random_bytes($bytesCount));
    }

    private function getHS256Signature(string $headerEncoded, string $payloadEncoded, $secret)
    {
        $signatureInput = $headerEncoded . '.' . $payloadEncoded;
        $signature = hash_hmac('sha256', $signatureInput, $secret, true);
        
        return $this->base64UrlEncode($signature);
    }

    private function base64UrlEncode($data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private function base64UrlDecode($data): string
    {
        return base64_decode(strtr($data, '-_', '+/'));
    }

}