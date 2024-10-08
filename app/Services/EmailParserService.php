<?php

namespace App\Services;

class EmailParserService
{
    public function parse(string $email): string
    {
        $decodedEmailContent = html_entity_decode($email);
        $rawText = strip_tags($decodedEmailContent);

        // Keep only printable characters
        return preg_replace('/[^\P{C}\n]+/u', '', $rawText);
    }
}
