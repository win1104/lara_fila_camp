<?php

namespace App\Livewire;

use Livewire\Component;
use OpenAI\Laravel\Facades\OpenAI;
use OpenAI\Responses\Threads\Runs\ThreadRunResponse;
use App\Models\Chat_assistant;

class DocBot extends Component
{
    public string $question = '';
    // public  $chats = [];
    public ?string $answer = null;
    public ?string $erro = null;
    public bool $open = false;
    public int $formKey = 0;


    // #[Layout('layouts.assistant')]
    public function ask()
    {
        $threadRun = $this->createAndRunThread();

        $this->loadAnswer($threadRun);
        $this->dispatch('scrollToBottom');
        $this->question = '';
        $this->formKey++; // 讓 form 重新渲染

    }

    private function createAndRunThread(): ThreadRunResponse
    {
        return OpenAI::threads()->createAndRun([
            'assistant_id' => 'asst_u3WSsSUr1rr2NTpK3WbR492P',
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

    private function loadAnswer(ThreadRunResponse $threadRun)
    {
        while(in_array($threadRun->status, ['queued', 'in_progress'])) {
            $threadRun = OpenAI::threads()->runs()->retrieve(
                threadId: $threadRun->threadId,
                runId: $threadRun->id,
            );
        }

        if ($threadRun->status !== 'completed') {
            $this->error = 'Request failed, please try again';
        }

        $messageList = OpenAI::threads()->messages()->list(
            threadId: $threadRun->threadId,
        );


        $this->answer = $messageList->data[0]->content[0]->text->value;
        Chat_assistant::create([
            'user_id' => auth()->id(),
            'title' => $this->question,
            'message' => $this->answer,
        ]);
    }

    public function toggle()
    {
        $this->open = !$this->open;
        if ($this->open) {
            $this->dispatch('scrollToBottom');
        }
    }

    public function render()
    {
        // $chats = Chat_assistant::latest()->get();
        // return view('livewire.doc-bot', [
        //     'chats' => $this->chats,
        // ]);
        return view('assistant.index', [
            'chats' => Chat_assistant::with('user')->get(),
            // 'chats' => $this->chats,
        ]);
    }
}
