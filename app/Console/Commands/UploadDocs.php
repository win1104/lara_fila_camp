<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use OpenAI\Laravel\Facades\OpenAI;

class UploadDocs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'upload-docs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Uploads the docs to OpenAI';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $uploadedFile = OpenAI::files()->upload([
            'file' => Storage::disk('local')->readStream('bright_future/美好未來QA最終版.pdf'),
            'purpose' => 'assistants',
        ]);

        $this->info('File ID: '.$uploadedFile->id);
    }
}
