<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\View\View;
// use Illuminate\Http\Response;
use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;


class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        // return response('Chat index');
        // return view('chat.index', [
        //     'chats' => Chat::with('user')->latest()->get(),
        // ]);
        return view('chat.index', [
            'chats' => Chat::latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'=> 'required|string|max:255',
        ]);
        $my_question = $validated['title'];


        // 對話模型
        $result = OpenAI::chat()->create([
            'model' => 'gpt-4o-mini',
            // 'store' => true, //會將對話存入 OpenAI 的資料庫
            'messages' => [
                ['role' => 'system', 'content' => '你是一個專業的醫療顧問，負責回答關於健康的問題'],
                // ['role' => 'user', 'content' => '我的血壓為 150/95 mmHg，我是否有高血壓？'],
                // ['role' => 'user', 'content' => '對於類風溼性關結炎的病人，有哪些因子會影響藥物治療的療效？'],
                // ['role' => 'user', 'content' => '我的總膽固醇值為 400 mg/dl，正常嗎？'],
                ['role' => 'user', 'content' => $my_question],
                ['role' => 'assistant', 'content' => '正常血壓值應等於或小於 120/80 mmHg'],
            ],
        ]);

        // gpt 回答
        // $validated['message'] = $result->choices[0]->message->content;
        // $request->user()->chats()->create($validated);
        Chat::create([
        'title' => $my_question,
        'message' => $result->choices[0]->message->content,
    ]);

        return redirect()->route('gpt.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Chat $chat)
    {
        // return view('chat.index', [
        //     'chats' => 'show at test',
        // ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chat $chat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chat $chat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chat $chat)
    {
        //
    }
}
