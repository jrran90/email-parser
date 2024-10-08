<?php

namespace App\Services;

class EmailParserService
{
    public function parse($rawEmail): array|string
    {
        // Split the raw email into headers and body
        $parts = explode("\r\n\r\n", $rawEmail, 2);
        if (count($parts) < 2) {
            return '';
        }

        // Get the body part
        $body = $parts[1];

        $cleanedBody = $this->decodeBody($body);

        return $cleanedBody ?: '';
    }

    private function decodeBody($body): array|string
    {
        $extractedBodies = [];

        // Split the body into individual email segments based on the MIME boundaries
        $segments = preg_split('/--\s*([^\r\n]+)/', $body);
        foreach ($segments as $segment) {
            // Remove headers and extra spaces
            $lines = preg_split('/\r\n|\n|\r/', $segment);

            // Flag to check if we are in the body of the email
            $inBody = false;

            foreach ($lines as $line) {
                // Trim line and skip empty lines
                $cleanedLine = trim($line);
                if (empty($cleanedLine)) {
                    continue;
                }

                // Check if the line starts with "Subject:"
                if (stripos($cleanedLine, 'Subject:') === 0) {
                    // Set the inBody flag to true when we encounter a subject
                    $inBody = true;
                    continue;
                }

                // If we're in the body, collect the line, but ignore any lines starting with "From:", "Sent:", "To:", etc.
                if ($inBody && !preg_match('/^(From:|Sent:|To:|Subject:|Content-Type:|Content-Transfer-Encoding:|<mailto:>)/i', $cleanedLine)) {
                    $extractedBodies[] = $cleanedLine . '\n';
                }
            }
        }

        // Join all extracted bodies with new lines, and ensure each body is separated by double new lines
        return !empty($extractedBodies) ? implode("\n", $extractedBodies) : '';
    }
}
