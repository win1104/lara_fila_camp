<?php

namespace App\Http\Controllers;

use App\Models\Ai_draw;
use Illuminate\View\View;
// use Illuminate\Http\Response;
use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class AiDrawController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        // return response('Ai_draw index');
        return view('ai_draw.index', [
            'ai_draws' => Ai_draw::with('user')->latest()->get(),
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


        // 圖片模型
        $result = OpenAI::images()->create([
            "model" => "dall-e-2",
            // "prompt" => "老虎媽媽和四隻小老虎的全家福",
            // "prompt" => "汪汪隊立大功的所有成員大合照",
            // "prompt" => "A cute baby sea otter",
            "prompt" => $my_question,
            "n" => 1,
            "size" => "256x256",
            // "response_format" => "b64_json"  // 使用 base64 編碼而不是 URL
        ]);

        // // 獲取 base64 編碼的圖片數據
        // $imageData = $result->data[0]->b64_json;
        // // 創建可以在 HTML 中使用的 data URL
        // $dataUrl = 'data:image/png;base64,' . $imageData;
        // return response(['data_url' => $dataUrl]);


        // 獲取 OpenAI 生成的圖片 URL
        $openaiImageUrl = $result->data[0]->url;
        // 下載圖片內容
        $imageContent = file_get_contents($openaiImageUrl);
        // 生成唯一文件名
        $fileName = 'dalle_images/' . Str::uuid() . '.png';
        // 保存到你的存儲系統
        Storage::disk('public')->put($fileName, $imageContent);
        // 返回可公開訪問的 URL
        $publicUrl = Storage::disk('public')->url($fileName);
        // return response(['url' => $publicUrl]);


        // gpt 回答
        $validated['message'] = $publicUrl;
        $request->user()->ai_draws()->create($validated);

        return redirect()->route('openai.index', ['locale' => app()->getLocale()]);


    }

    /**
     * Display the specified resource.
     */
    public function show(Ai_draw $ai_draw)
    {
        // return view('Ai_draw.index', [
        //     'Ai_draws' => 'show at test',
        // ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ai_draw $ai_draw)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ai_draw $ai_draw)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ai_draw $ai_draw)
    {
        //
    }
}
