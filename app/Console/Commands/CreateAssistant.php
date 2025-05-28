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
    protected $signature = 'create-assistant {--file-ids=* : The file IDs to use for the assistant}';

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
        // 定義所有要使用的文件 ID
        // $fileIds = [
        //     'file-NfPLvzsApTzBkrd6txC15R',  // MP3_200 使用手冊
        //     'file-2MD9zqcfvAYmbLeNDK4Qu6',  // 小兒爆炸傷實務手冊
        //     'file-PijZiqujDEfioayC2a5gFc'   // BlastInjuriesManual
        // ];
        $fileIds = $this->option('file-ids') ?: [
            'file-NfPLvzsApTzBkrd6txC15R',
            'file-2MD9zqcfvAYmbLeNDK4Qu6',
            'file-PijZiqujDEfioayC2a5gFc',
        ];

        $vectorStore = OpenAI::vectorStores()->create([
            'file_ids' => $fileIds,
        ]);
        $this->info('Vector Store ID: ' . $vectorStore->id);

        $assistant = OpenAI::assistants()->create([
            'name' => 'MP3_200 Chat Bot',
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
            'instructions' => '你是一位根據文件內容提供協助的客服助理。請根據所提供的文件回答使用者的問題，並使用與使用者問題相同的語言作答。如果文件中找不到相關資訊，請用對應語言回覆：「抱歉，我不清楚這個問題的答案。」',
            'model' => 'gpt-4o-mini',
        ]);

        $this->info('Assistant ID: '.$assistant->id);
    }
}
