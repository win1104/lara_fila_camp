<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Livewire\Attributes\Layout;
use OpenAI\Laravel\Facades\OpenAI;
use OpenAI\Responses\Threads\Runs\ThreadRunResponse;
use App\Models\Chat_assistant;

class DocBot extends Component
{
    public string $question = '';
    // public  $chats = [];
    public array $tempChats = [];

    public ?string $answer = null;
    public ?string $erro = null;
    public bool $open = false;
    public int $formKey = 0;


    // #[Layout('layouts.assistant')]
    public function ask()
    {
        // 顯示使用者剛剛輸入的訊息（立即出現在畫面上）
        $this->tempChats[] = [
            'type' => 'user',
            'content' => $this->question,
            'timestamp' => now()->format('H:i'),
        ];

        // 顯示「助手思考中」loading 泡泡
        $this->tempChats[] = [
            'type' => 'assistant',
            'content' => '...',
            'loading' => true,
            'timestamp' => now()->format('H:i'),
        ];

        $userQues = $this->question;

        $threadRun = $this->createAndRunThread();

        // $this->loadAnswer($threadRun);
        $this->loadAnswer($threadRun, $userQues);
        // $this->dispatch('scrollToBottom');
        $this->question = '';
        $this->formKey++; // 讓 form 重新渲染

    }

    private function createAndRunThread(): ThreadRunResponse
    {
        return OpenAI::threads()->createAndRun([
            // 'assistant_id' => 'asst_jKi5NvszoIqw1Wiww2feZLWR',
            'assistant_id' => 'asst_Xq6By9KlVhYz8FBa73BArt2S',
            // 'assistant_id' => 'asst_BiYDmF1gGPeGd59wDV0TMDJD',
            // 'user' => 'bright_future',
            'thread' => [
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => $this->question,
                    ],
                ],
            ],
        ]);
    }

    // private function loadAnswer(ThreadRunResponse $threadRun)
    private function loadAnswer(ThreadRunResponse $threadRun, string $originalQuestion)
    {
        while(in_array($threadRun->status, ['queued', 'in_progress'])) {
            $threadRun = OpenAI::threads()->runs()->retrieve(
                threadId: $threadRun->threadId,
                runId: $threadRun->id,
            );
        }

        if ($threadRun->status !== 'completed') {
            $this->error = 'Request failed, please try again';
            return;
        }

        $messageList = OpenAI::threads()->messages()->list(
            threadId: $threadRun->threadId,
        );


        $this->answer = $messageList->data[0]->content[0]->text->value;
        Chat_assistant::create([
            'user_id' => auth()->id(),
            'title' => $originalQuestion,
            'message' => $this->answer,
        ]);

        // 移除 loading 泡泡
        array_pop($this->tempChats);
        // 加入實際助手回覆
        $this->tempChats[] = [
            'type' => 'assistant',
            'content' => $this->answer,
            'timestamp' => now()->format('H:i'),
        ];
    }

    public function toggle()
    {
        $this->open = !$this->open;
        if ($this->open) {
            $this->dispatch('scrollToBottom');
        }
    }

    #[Layout('layouts.app')]
    public function render()
    {
        // return view('layouts.assistant');

        // return view('assistant.index', [
        //     'chats' => Chat_assistant::with('user')->latest()->get(),
        //     'tempChats' => $this->tempChats,
        // ]);

        return view('livewire.doc-bot', [
            'chats' => Chat_assistant::with('user')->latest()->get(),
            'tempChats' => $this->tempChats,
        ]);
    }
}
