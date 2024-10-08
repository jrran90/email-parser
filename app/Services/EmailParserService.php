<?php

namespace App\Services;

class EmailParserService
{
    public function parse($rawEmail): array|string|null
    {
        // Split the raw email into headers and body
        list(, $body) = explode("\r\n\r\n", $rawEmail, 2);

        // Decode and clean the body
        return $this->decodeBody($body);
    }

    private function decodeBody($body): array|string|null
    {
        // Decode quoted-printable and base64 encoded content if necessary
        if (str_contains($body, 'Content-Transfer-Encoding: base64')) {
            $body = base64_decode($body);
        } elseif (str_contains($body, 'Content-Transfer-Encoding: quoted-printable')) {
            $body = quoted_printable_decode($body);
        }

        // Strip HTML tags if the body is HTML
        $body = strip_tags($body);

        // Retain only printable characters
        return preg_replace('/[^\P{C}\p{Z}]+/u', '', $body);
    }
}
