<div>
    {{-- 首頁Banner --}}
    <div class="relative">
        <img src="{{ asset('bg_aibanner.png') }}" class="absolute inset-0 object-cover w-full h-full" alt="" />
        <div class="relative  bg-opacity-75">
            {{-- <div class="px-4 py-16 mx-auto sm:max-w-xl md:max-w-full lg:max-w-screen-xl md:px-24 lg:px-8 lg:py-20"> --}}
            <div class="max-w-[1600px] mx-auto px-8 py-28 lg:px-32">
                <div class="mb-10  sm:text-left md:my-28">
                    <div class="flex justify-between items-center flex-wrap md:flex-nowrap gap-8">
                        <div>
                            <h2
                                class="mb-8 font-sans text-2xl font-black leading-none text-white sm:text-5xl">
                                將您的知識庫化為 AI 銷售力
                            </h2>
                            <p class="text-xl text-white font-thin max-w-[500px] md:text-3xl">
                                讓您的網站不只是網站，更是專業化的工具！
                            </p>
                        </div>
                        <div>
                            <img src="{{ asset('ai_dialogue.png') }}" alt="">
                        </div>
                    </div>
                </div>
                <div class="grid gap-8 row-gap-5 sm:grid-cols-2 lg:grid-cols-3">
                    <div class="flex flex-col justify-between p-5 rounded-3xl shadow-sm"
                        style="background-color:rgb(251 251 251 / 20%);">
                        <div>
                            <div class="flex items-center w-16 h-8 mb-5 rounded-full">
                                <img src="{{ asset('nobg_ai.png') }}" alt="">
                            </div>
                            <h3 class="mb-3 font-black leading-5 text-white">超越客服，打造沉浸式品牌體驗</h3>
                            <p class="mb-3 text-base text-white">
                                AI 客服助理能即時解決客戶問題，減少等待時間，也減少人工客服壓力，讓客服人員專注於複雜問題
                            </p>
                        </div>
                    </div>
                    <div class="flex flex-col justify-between p-5 rounded-3xl shadow-sm"
                        style="background-color:rgb(251 251 251 / 20%);">
                        <div>
                            <div class="flex items-center w-16 h-8 mb-5 rounded-full">
                                <img src="{{ asset('Communication - Chat_Circle_Check.png') }}" alt="">
                            </div>
                            <h3 class="mb-3 font-black leading-5 text-white">告別制式化回應，讓每個對話都獨特</h3>
                            <p class="mb-3 text-base text-white">
                            透過對話，理解客戶需求，AI 客服助理提供個性化建議
                            </p>
                        </div>
                    </div>
                    <div class="flex flex-col justify-between p-5 rounded-3xl shadow-sm"
                        style="background-color:rgb(251 251 251 / 20%);">
                        <div>
                            <div class="flex items-center w-16 h-8 mb-5 rounded-full">
                                <img src="{{ asset('User - User_Voice.png') }}" alt="">
                            </div>
                            <h3 class="mb-3 font-black leading-5 text-white">您的客戶，值得最智能的即時服務</h3>
                            <p class="mb-3 text-base text-white">
                                提升客戶滿意度、品牌忠誠度
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 經歷 --}}
    <section class="text-gray-600 body-font">
        <div class="max-w-[1600px] mx-auto px-5 py-32 lg:px-32">
            <div class="flex flex-col text-center w-full mb-12">
                <p class="text-3xl font-black title-font mb-4 text-gray-900">將您的知識庫化為 AI 銷售力</p>
                <p class="mx-auto text-lg max-w-lg">混合無限智慧 GPT AI 客服助理將您的企業知識庫，轉化為 24/7 的智能銷售員與企業知識的活化的媒介</p>
            </div>
            <div class="flex flex-wrap md:flex-nowrap">
                <div class="p-4 w-full md:w-1/3">
                    <div class="h-full border-2 border-gray-200 border-opacity-60 rounded-lg overflow-hidden">
                        <img class="h-56 w-full object-cover object-center" src="{{ asset('ai_sales.png') }}"
                            alt="blog">
                        <div class="p-6">
                            <p class="title-font text-xl font-black text-gray-900 mb-3">將您的企業知識庫，轉化為 24/7 的智能銷售員</p>
                            <p class="leading-relaxed mb-3">將企業內部散落的產品資料、服務說明、FAQ 等，整合到 AI 機器人中</p>
                        </div>
                    </div>
                </div>
                <div class="p-4 w-full md:w-1/3">
                    <div class="h-full border-2 border-gray-200 border-opacity-60 rounded-lg overflow-hidden">
                        <img class="h-56 w-full object-cover object-center" src="{{ asset('ai_assets.png') }}"
                            alt="blog">
                        <div class="p-6">
                            <p class="title-font text-xl font-black text-gray-900 mb-3">AI 智慧助理：您最寶貴的企業知識庫與知識資產</p>
                            <p class="leading-relaxed mb-3">機器人成為企業知識的「活化」媒介，讓知識能隨時被客戶存取和理解</p>
                        </div>
                    </div>
                </div>
                <div class="p-4 w-full md:w-1/3">
                    <div class="h-full border-2 border-gray-200 border-opacity-60 rounded-lg overflow-hidden">
                        <img class="h-56 w-full object-cover object-center" src="{{ asset('ai_sales.png') }}"
                            alt="blog">
                        <div class="p-6">
                            <p class="title-font text-xl font-black text-gray-900 mb-3">不止是聊天，更是您的智慧知識管理與推廣平台</p>
                            <p class="leading-relaxed mb-3">賦能員工，讓 AI 智慧助理也能快速查詢企業知識</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 業務DNA --}}
    <section class="text-gray-600 body-font bg-[#EBF0FE]">
        <div class="max-w-[1600px] mx-auto px-5 py-40 lg:px-32 flex md:flex-row flex-col items-center justify-center gap-14">
            <div class="md:w-1/2 flex flex-col md:items-start md:text-left mb-16 md:mb-0 items-center text-center max-w-lg">
                    <h2 class="title-font sm:text-3xl text-2xl mb-8 font-black text-gray-900">深入您的業務DNA，打造最懂您的 AI 聊天機器人</h2>
                    <p class="mb-20 font-medium text-lg">將 AI 模型和技術整合到您的網站或雲端系統中，從需求分析、數據準備、模型訓練，提供完整的 AI 聊天應用解決方案s</p>
                    <div class="flex justify-center">
                        <button
                            class="inline-flex text-white bg-[#9BBF3E] rounded-full border-0 py-2 px-10 focus:outline-none hover:bg-[#8cb02f] text-lg">更多訊息</button>
                    </div>
            </div>
            {{-- <div class="lg:max-w-lg lg:w-full md:w-1/2 w-5/6"> --}}
            <div class="md:w-7/12 w-5/6">
                <img class="object-cover object-center rounded" alt="hero" src="{{ asset('emphasize.png') }}" alt="">
            </div>
        </div>
    </section>

    {{-- 可量化的商業價值 --}}
    <section class="body-font bg-[#0D256D]">
        <div class="max-w-[1600px] mx-auto px-5 py-24 lg:px-32">
            <div class="">
                <div class="max-w-lg mb-6 sm:mx-auto text-center md:mb-10 lg:max-w-xl">
                    <h2 class="text-white font-black mb-6 text-3xl">
                        可量化的商業價值
                    </h2>
                    <p class="text-base text-white md:text-lg">
                        導入 GPT AI 客服助理不僅是流程優化，更是驅動成長的引擎。數據顯示，企業在客服成本、客戶轉換率及整體銷售額上均獲得顯著改善。
                    </p>
                </div>
                <div class="grid gap-6 row-gap-5 lg:grid-cols-3">
                    <div class="bg-white p-6 rounded-xl shadow-lg">
                        <h3 class="font-bold text-center mb-4">客服成本結構變化</h3>
                        <div class="relative w-full h-[400px] max-h-[400px] mr-auto ml-auto">
                            <canvas id="costChart"></canvas>
                        </div>
                        <p class="text-sm text-slate-600 mt-4 text-center">透過 AI 協同作業，大幅降低重複性問題的人力成本，讓人力專注於更高價值的客戶服務。</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-lg">
                        <h3 class="font-bold text-center mb-4">客戶互動渠道轉換率</h3>
                        <div class="relative w-full h-[400px] max-h-[400px] mr-auto ml-auto">
                            <canvas id="conversionChart"></canvas>
                        </div>
                        <p class="text-sm text-slate-600 mt-4 text-center">GPT Assistant 提供 24/7 即時、個人化的互動，有效提升訪客轉換為潛在客戶或完成購買的機率。</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-lg md:col-span-2 lg:col-span-1">
                        <h3 class="font-bold text-center mb-4">導入後月銷售額增長趨勢</h3>
                        <div class="relative w-full h-[400px] max-h-[400px] mr-auto ml-auto">
                            <canvas id="salesChart"></canvas>
                        </div>
                        <p class="text-sm text-slate-600 mt-4 text-center">智能推薦與不間斷的銷售引導，直接反映在持續上揚的月銷售額曲線上。</p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="text-gray-600 body-font bg-[#EBF0FE]">
        {{-- <div class="max-w-[1280px] px-5 py-32 mx-auto flex flex-wrap flex-col"> --}}
        <div class="max-w-[1600px] mx-auto px-5 py-32 lg:px-32 flex flex-wrap flex-col">
            <h2 class="text-center title-font sm:text-4xl text-3xl mb-5 md:-mb-2.5 font-black" style="color:#162945;">混合無限創意，激發無窮想像</h2>
            {{-- <div class="flex items-center justify-between mb-14"> --}}

                <div class="flex items-center space-x-4 justify-end mb-6">
                    <button wire:click="previousSlide"
                        class="flex items-center justify-center w-[54px] h-[54px] shadow-md p-2 rounded-full bg-white hover:bg-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button wire:click="nextSlide"
                        class="flex items-center justify-center w-[54px] h-[54px] shadow-md p-2 rounded-full bg-white hover:bg-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            {{-- </div> --}}
            <div class="flex flex-wrap">
                <div class="p-4 md:w-1/2 w-full">
                    <div class="h-full bg-white p-11 rounded-3xl">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="block w-5 h-5 text-[#0C256D] mb-4"
                            viewBox="0 0 975.036 975.036">
                            <path
                                d="M925.036 57.197h-304c-27.6 0-50 22.4-50 50v304c0 27.601 22.4 50 50 50h145.5c-1.9 79.601-20.4 143.3-55.4 191.2-27.6 37.8-69.399 69.1-125.3 93.8-25.7 11.3-36.8 41.7-24.8 67.101l36 76c11.6 24.399 40.3 35.1 65.1 24.399 66.2-28.6 122.101-64.8 167.7-108.8 55.601-53.7 93.7-114.3 114.3-181.9 20.601-67.6 30.9-159.8 30.9-276.8v-239c0-27.599-22.401-50-50-50zM106.036 913.497c65.4-28.5 121-64.699 166.9-108.6 56.1-53.7 94.4-114.1 115-181.2 20.6-67.1 30.899-159.6 30.899-277.5v-239c0-27.6-22.399-50-50-50h-304c-27.6 0-50 22.4-50 50v304c0 27.601 22.4 50 50 50h145.5c-1.9 79.601-20.4 143.3-55.4 191.2-27.6 37.8-69.4 69.1-125.3 93.8-25.7 11.3-36.8 41.7-24.8 67.101l35.9 75.8c11.601 24.399 40.501 35.2 65.301 24.399z">
                            </path>
                        </svg>
                        <p class="leading-relaxed mb-6">我們相信許多事情成功的開端，建立在彼此良好的溝通與互動上。</br>
                        我們會花許多時間與客戶討論、溝通每個製作環節，只為了做出「對的」品牌網站。</p>
                        <a class="inline-flex items-center">
                            <img alt="testimonial" src="{{ asset('avatar_up.png') }}"
                                class="w-12 h-12 rounded-full flex-shrink-0 object-cover object-center">
                            <span class="flex-grow flex flex-col pl-4">
                                <span class="title-font font-medium text-gray-900">Richard</span>
                                <span class="text-gray-500 text-sm">圓桌會議有限公司 執行長</span>
                            </span>
                        </a>
                    </div>
                </div>
                <div class="p-4 md:w-1/2 w-full">
                    <div class="h-full bg-white p-11 rounded-3xl">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="block w-5 h-5 text-[#0C256D] mb-4"
                            viewBox="0 0 975.036 975.036">
                            <path
                                d="M925.036 57.197h-304c-27.6 0-50 22.4-50 50v304c0 27.601 22.4 50 50 50h145.5c-1.9 79.601-20.4 143.3-55.4 191.2-27.6 37.8-69.399 69.1-125.3 93.8-25.7 11.3-36.8 41.7-24.8 67.101l36 76c11.6 24.399 40.3 35.1 65.1 24.399 66.2-28.6 122.101-64.8 167.7-108.8 55.601-53.7 93.7-114.3 114.3-181.9 20.601-67.6 30.9-159.8 30.9-276.8v-239c0-27.599-22.401-50-50-50zM106.036 913.497c65.4-28.5 121-64.699 166.9-108.6 56.1-53.7 94.4-114.1 115-181.2 20.6-67.1 30.899-159.6 30.899-277.5v-239c0-27.6-22.399-50-50-50h-304c-27.6 0-50 22.4-50 50v304c0 27.601 22.4 50 50 50h145.5c-1.9 79.601-20.4 143.3-55.4 191.2-27.6 37.8-69.4 69.1-125.3 93.8-25.7 11.3-36.8 41.7-24.8 67.101l35.9 75.8c11.601 24.399 40.501 35.2 65.301 24.399z">
                            </path>
                        </svg>
                        <p class="leading-relaxed mb-6">我們相信許多事情成功的開端，建立在彼此良好的溝通與互動上。
                        我們會花許多時間與客戶討論、溝通每個製作環節，只為了做出「對的」品牌網站。</p>
                        <a class="inline-flex items-center">
                            <img alt="testimonial" src="{{ asset('avatar_toystory.png') }}"
                                class="w-12 h-12 rounded-full flex-shrink-0 object-cover object-center">
                            <span class="flex-grow flex flex-col pl-4">
                                <span class="title-font font-medium text-gray-900">Judith</span>
                                <span class="text-gray-500 text-sm">Edimax 訊舟科技 行銷經理</span>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="relative bg-gray-100 py-24 overflow-hidden">
        <!-- 背景圖 -->
        <div class="absolute inset-0 bg-fixed bg-center" style="background-image:url('/unsplash3.jpg');">
            <div class="absolute inset-0 bg-[#0C256D] mix-blend-color"></div>
        </div>

        <!-- 內容 -->
        <div class="max-w-[1600px] mx-auto px-5 lg:px-32">
            <div class="relative px-4 text-left">
                <h2 class="title-font sm:text-4xl text-3xl mb-4 font-sans font-black text-white">聯絡我們</h2>

                <div class="flex justify-between items-end flex-wrap md:flex-nowrap gap-8">
                    <p class="leading-relaxed text-white">請將您的想法、疑問、需求與我們分享，也許我們能給您一些意見、咨詢或協助</p>
                    <button
                        class="inline-flex text-white bg-[#9BBF3E] rounded-full border-0 py-2 px-10 focus:outline-none hover:bg-[#8cb02f] text-lg">更多訊息</button>
                </div>
            </div>
        </div>
    </section>


    {{-- 首頁footer --}}
    <footer class="text-gray-600 body-font bg-gray-100">
        <div
            class="border-b-2 border-gray-300 max-w-[1600px] px-5 lg:px-32 pt-20 pb-14 mx-auto flex md:items-center lg:items-start md:flex-row md:flex-nowrap flex-wrap flex-col">
            <div class=" flex-shrink-0 md:mx-0 mx-auto text-center md:text-right md:mt-0 mt-10">
                <a class="flex title-font font-medium items-center md:justify-end justify-center text-gray-900">
                    <img src="{{ asset('logo_black.png') }}" alt="maxweb Logo" role="img">
                </a>
                <p class="mt-2 mb-6 text-lg text-gray-900">混合無限智慧科技有限公司</p>
                <p class="mt-2 text-base text-gray-900">Mail：service@maxweb.com.tw</p>
                <p class="mt-2 text-base text-gray-900">234023 新北市和區大新街79號1樓</p>
                <p class="mt-2 text-base text-gray-900">02-23973221</p>
            </div>
            <div class="gap-10 flex-grow flex flex-wrap -mb-10 md:text-left text-center order-first">
                <div class="">
                    <h2 class="title-font font-medium text-gray-900 tracking-widest text-xl mb-3">服務</h2>
                    <nav class="list-none mb-10 text-sm leading-6">
                        <li>
                            <a class="text-gray-500 hover:text-gray-800">專業客製化網站</a>
                        </li>
                        <li>
                            <a class="text-gray-500 hover:text-gray-800">無障礙網站</a>
                        </li>
                        <li>
                            <a class="text-gray-500 hover:text-gray-800">FHIR 醫療系統</a>
                        </li>
                        <li>
                            <a class="text-gray-500 hover:text-gray-800">地理資訊系統</a>
                        </li>
                        <li>
                            <a class="text-gray-500 hover:text-gray-800">AI 助理</a>
                        </li>
                    </nav>
                </div>
                <div class="px-4">
                    <h2 class="title-font font-medium text-gray-900 tracking-widest text-xl mb-3"> 作品</h2>
                </div>
                <div class="px-4">
                    <h2 class="title-font font-medium text-gray-900 tracking-widest text-xl mb-3">新聞</h2>
                    <nav class="list-none mb-10 text-sm leading-6">
                        <li>
                            <a class="text-gray-500 hover:text-gray-800">系統</a>
                        </li>
                        <li>
                            <a class="text-gray-500 hover:text-gray-800">資安</a>
                        </li>
                        <li>
                            <a class="text-gray-500 hover:text-gray-800">技術</a>
                        </li>
                        <li>
                            <a class="text-gray-500 hover:text-gray-800">FHIR</a>
                        </li>
                    </nav>
                </div>
                <div class="px-4">
                    <h2 class="title-font font-medium text-gray-900 tracking-widest text-xl mb-3">關於</h2>
                </div>
            </div>
        </div>
        <div class="">
            <div class="items-center max-w-[1280px] mx-auto py-8 px-5 flex flex-wrap flex-col sm:flex-row">
                <p class="text-gray-900 text-sm text-center sm:text-left">Copyright © 2025 MaxWeb Tech
                    <a href="https://twitter.com/knyttneve" rel="noopener noreferrer" class="text-gray-500 ml-12"
                        target="_blank">Privacy Policy</a>
                </p>
                <span class="inline-flex sm:ml-auto sm:mt-0 mt-2 justify-center sm:justify-start">
                    <a class="text-gray-500" title="點擊前往Line">
                        <img src="{{ asset('line-svgrepo-com.png') }}" alt="" role="img">
                    </a>
                    <a class="ml-3 text-gray-500">
                        <img src="{{ asset('icon_facebook.png') }}" alt="" role="img">
                    </a>
                    <a class="ml-3 text-gray-500">
                        <img src="{{ asset('icon_youtube.png') }}" alt="" role="img">
                    </a>
                </span>
            </div>
        </div>
    </footer>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // Helper function for label wrapping
            const wrapLabel = (label, maxLength = 16) => {
                if (label.length <= maxLength) {
                    return label;
                }
                const words = label.split(' ');
                const lines = [];
                let currentLine = '';
                for (const word of words) {
                    if ((currentLine + ' ' + word).length > maxLength && currentLine.length > 0) {
                        lines.push(currentLine);
                        currentLine = word;
                    } else {
                        if (currentLine.length > 0) {
                            currentLine += ' ' + word;
                        } else {
                            currentLine = word;
                        }
                    }
                }
                lines.push(currentLine);
                return lines;
            };

            // Shared tooltip configuration
            const tooltipConfig = {
                plugins: {
                    tooltip: {
                        callbacks: {
                            title: function (tooltipItems) {
                                const item = tooltipItems[0];
                                let label = item.chart.data.labels[item.dataIndex];
                                if (Array.isArray(label)) {
                                    return label.join(' ');
                                }
                                return label;
                            }
                        }
                    }
                }
            };

            // Chart 1: Cost Structure Donut Chart
            const costCtx = document.getElementById('costChart').getContext('2d');
            new Chart(costCtx, {
                type: 'doughnut',
                data: {
                    labels: ['人力成本', 'AI 系統與維護'],
                    datasets: [{
                        label: '導入前',
                        data: [95, 5],
                        backgroundColor: ['#118AB2', '#06D6A0'],
                        borderColor: '#ffffff',
                        borderWidth: 2,
                    }, {
                        label: '導入後',
                        data: [60, 40],
                        backgroundColor: ['#118AB2', '#06D6A0'],
                        borderColor: '#ffffff',
                        borderWidth: 2,
                        hidden: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        ...tooltipConfig.plugins,
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: '導入 AI 前後成本比較',
                        }
                    }
                }
            });

            // Chart 2: Conversion Rate Bar Chart
            const conversionCtx = document.getElementById('conversionChart').getContext('2d');
            new Chart(conversionCtx, {
                type: 'bar',
                data: {
                    labels: ['傳統線上客服', '電子郵件行銷', wrapLabel('GPT Assistants 智能助理')],
                    datasets: [{
                        label: '轉換率 (%)',
                        data: [2.5, 1.8, 8.5],
                        backgroundColor: [
                            '#FFD166',
                            '#118AB2',
                            '#06D6A0'
                        ],
                        borderColor: [
                            '#FFD166',
                            '#118AB2',
                            '#06D6A0'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function (value) {
                                    return value + '%'
                                }
                            }
                        }
                    },
                    plugins: {
                        ...tooltipConfig.plugins,
                        legend: {
                            display: false,
                        },
                    }
                }
            });

            // Chart 3: Sales Growth Line Chart
            const salesCtx = document.getElementById('salesChart').getContext('2d');
            new Chart(salesCtx, {
                type: 'line',
                data: {
                    labels: ['第一月', '第二月', '第三月', '第四月', '第五月', '第六月'],
                    datasets: [{
                        label: '導入後月銷售額 (萬元)',
                        data: [120, 135, 160, 185, 220, 250],
                        fill: true,
                        backgroundColor: 'rgba(6, 214, 160, 0.2)',
                        borderColor: '#06D6A0',
                        tension: 0.3
                    },
                    {
                        label: '導入前平均月銷售額 (萬元)',
                        data: [115, 115, 115, 115, 115, 115],
                        fill: false,
                        borderColor: '#FF6B6B',
                        borderDash: [5, 5],
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: false
                        }
                    },
                    plugins: {
                        ...tooltipConfig.plugins,
                    }
                }
            });
        });
    </script>
@endpush