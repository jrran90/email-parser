<?php

namespace App\Console\Commands;

use App\Models\SuccessfulEmail;
use App\Services\EmailParserService;
use Illuminate\Console\Command;

class ParseEmails extends Command
{
    protected $signature = 'app:parse-emails';
    protected $description = 'Parse raw email';

    protected EmailParserService $emailParserService;

    public function __construct(EmailParserService $emailParserService)
    {
        parent::__construct();
        $this->emailParserService = $emailParserService;
    }

    public function handle(): void
    {
        // Note: This can be further optimized using background processing i.e., creating Job, but as of this moment,
        // this will suffice.
        // Fetch unprocessed emails
        SuccessfulEmail::query()
            ->whereNull('raw_text')
            ->orWhere('raw_text', '')
            ->chunk(50, function ($emails) {
                foreach ($emails as $email) {
                    $parsedBody = $this->emailParserService->parse($email->email);

                    if ($parsedBody === null) {
                        $this->info('Skipping email with ID: ' . $email->id . ' - no body content found.');
                        continue;
                    }

                    $email->raw_text = $parsedBody;
                    $email->save();

                    $this->info('Parsed email: ' . $email->id);
                }
            });
    }
}
