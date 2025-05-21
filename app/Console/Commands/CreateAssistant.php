<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use OpenAI\Laravel\Facades\OpenAI;

class CreateAssistant extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create-assistant {file_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates the MP3_200_User_Manual_V1.0_TW assistant.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $fileId = $this->argument('file_id');

        $vectorStore = OpenAI::vectorStores()->create([
            'file_ids' => ['file-NfPLvzsApTzBkrd6txC15R'],
        ]);
        $this->info('Vector Store ID: ' . $vectorStore->id);

        $assistant = OpenAI::assistants()->create([
            'name' => 'MP3_200 Chat Bot',
            // 'file_ids' => [
            //     $this->argument('file_id'),
            // ],
            'tools' => [
                [
                    'type' => 'file_search',
                ],
            ],
            'tool_resources' => [
                'file_search' => [
                    'vector_store_ids' => [$vectorStore->id],
                ],
            ],
            'instructions' => '你是MP3_200攜帶式印表機的使用手冊助理，請你根據文件內容，回答使用者提出的問題。無相關問題一律回答「很抱歉，這問題的解答我不清楚。」',
            'model' => 'gpt-4o-mini',
        ]);

        $this->info('Assistant ID: '.$assistant->id);
    }
}
