<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Chat_assistant;
use OpenAI\Laravel\Facades\OpenAI;
use OpenAI\Responses\Threads\Runs\ThreadRunResponse;

class ChatWidget extends Component
{
    public bool $open = false;
    public $chats;
    public array $tempChats = [];
    public string $question = '';
    public ?string $answer = null;
    public ?string $error = null;
    public int $formKey = 0;

    public function mount($chats = [])
    {
        $this->chats = Chat_assistant::with('user')->latest()->take(5)->get()->reverse();
        // $this->chats = Chat_assistant::where('client', $this->client)->with('user')->latest()->take(5)->get()->reverse();
    }

    public function toggle()
   {
       $this->open = !$this->open;
       $this->dispatch('scrollToBottom');

    }

    public function ask()
    {
        $this->tempChats[] = [
            'type' => 'user',
            'content' => $this->question,
            'timestamp' => now()->format('H:i'),
        ];

        $this->tempChats[] = [
            'type' => 'assistant',
            'content' => '...',
            'loading' => true,
            'timestamp' => now()->format('H:i'),
        ];

        $userQues = $this->question;
        $threadRun = $this->createAndRunThread();
        $this->loadAnswer($threadRun, $userQues);
        $this->question = '';
        $this->formKey++;
    }

    private function createAndRunThread(): ThreadRunResponse
    {
        return OpenAI::threads()->createAndRun([
            // 'assistant_id' => 'asst_jKi5NvszoIqw1Wiww2feZLWR',
            'assistant_id' => 'asst_Xq6By9KlVhYz8FBa73BArt2S',
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

    private function loadAnswer(ThreadRunResponse $threadRun, string $originalQuestion)
    {
        while (in_array($threadRun->status, ['queued', 'in_progress'])) {
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

        array_pop($this->tempChats);
        $this->tempChats[] = [
            'type' => 'assistant',
            'content' => $this->answer,
            'timestamp' => now()->format('H:i'),
        ];

        // 重新撈最後五筆，確保畫面更新
        $this->chats = Chat_assistant::with('user')->latest()->take(5)->get()->reverse();
        $this->dispatch('scrollToBottom');
    }

    public function render()
    {
        return view('livewire.chat-widget');
    }
}
