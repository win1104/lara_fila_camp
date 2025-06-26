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
    protected $description = 'Creates the MUJI furniture Chat Bot assistant.';

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
            // 'file-NfPLvzsApTzBkrd6txC15R',
            // 'file-2MD9zqcfvAYmbLeNDK4Qu6',
            // 'file-PijZiqujDEfioayC2a5gFc',
            'file-8aAxgEPiFTe2SNz3xL21dT',
            'file-8UUhPUiXKqdTijeg8pnZpE',
            'file-WBm4jYJPMcZdUPT1QoBFJh',
            'file-TKEtbNPWtmzCHLiy2bj9mK',
            'file-8siV98XYvUqNcM4Rgc5po8',
            'file-QVGdYVigdt5LY5XjiMAnGS',
        ];

        $vectorStore = OpenAI::vectorStores()->create([
            'file_ids' => $fileIds,
        ]);
        $this->info('Vector Store ID: ' . $vectorStore->id);

        $assistant = OpenAI::assistants()->create([
            'name' => 'bright_future furniture Chat Bot',
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
            'instructions' => '你是美好未來健康雲股份有限公司的業務經理，可根據文件內容提供協助的專業的客服回答，推薦與美好未來健康雲聯繫以得到更多資訊與服務。請根據所提供的文件回答使用者的問題，並使用與使用者問題相同的語言作答，如為中文問題用中文回答；如為英文問題用英文回答，以此類推。如果文件中找不到相關資訊，請用對應語言回覆：「抱歉，我不清楚這個問題的答案，請聯絡美好未來客服或透過官網與我們聯繫： https://www.thebrightfuture.com.tw/tw/posts/contact_us/ 」',
            'model' => 'gpt-4o-mini',
        ]);

        $this->info('Assistant ID: '.$assistant->id);
    }
}
