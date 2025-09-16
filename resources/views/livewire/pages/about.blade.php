<div>
    {{-- 首頁Banner --}}
    <div class="relative mt-24">

        {{-- <div class="relative w-full h-[500px] rounded-xl overflow-hidden"> --}}
        <div class="relative w-full h-[900px] rounded-xl overflow-hidden">
        <div class="swiper mySwiper absolute inset-0 w-full h-full">
            <div class="swiper-wrapper">
                <!-- 圖片 -->
                <div class="swiper-slide flex items-center justify-center bg-black">
                    <img src="{{ asset('20231226_034242-image(2500x1700-crop).jpg') }}" class="absolute inset-0 object-cover w-full h-full" alt="" />
                </div>

                <div class="swiper-slide flex items-center justify-center bg-black">
                    <img src="{{ asset('20240402_104934-image(2500x1700-crop).jpg') }}"
                        class="absolute inset-0 object-cover w-full h-full" alt="" />
                </div>

                <div class="swiper-slide flex items-center justify-center bg-black"><iframe
                        src="https://player.vimeo.com/video/1118028899?badge=0&amp;backstage=1&amp;player_id=0&amp;app_id=58479&amp;autoplay=1&amp;muted=1&amp;background=1"
                        frameborder="0" allow="autoplay; fullscreen; picture-in-picture; clipboard-write; encrypted-media; web-share"
                        referrerpolicy="strict-origin-when-cross-origin" style="width:100%;height:100%;"
                        title="牛頭牌 凝聚家的味道 ｜阿嬤的幸福懷舊古早滋味 - BUFFALO牛頭牌炊具 (1080p, h264)"></iframe></div>
                <script src="https://player.vimeo.com/api/player.js"></script>

                <!-- 自家影片 (mp4) -->
                <div class="swiper-slide flex items-center justify-center bg-black">
                    <video autoplay loop muted class="object-cover w-full h-full">
                        <source src="{{ asset('golden_gate_bridge.mp4') }}" type="video/mp4">
                        <source src="{{ asset('golden_gate_bridge.webm') }}" type="video/webm">
                        Your browser does not support the video tag.
                    </video>
                </div>


            </div>

            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>

        {{-- <img src="{{ asset('bg_aibanner.png') }}" class="absolute inset-0 object-cover w-full h-full" alt="" /> --}}
        {{-- <video autoplay loop muted class="absolute inset-0 object-cover w-full h-full">
            <source src="{{ asset('golden_gate_bridge.mp4') }}" type="video/mp4">
            <source src="{{ asset('golden_gate_bridge.webm') }}" type="video/webm">
            Your browser does not support the video tag.
        </video> --}}
        <div class="absolute inset-0 bg-[#0d256dd1]"></div>
        <div class="relative">
                <div class="max-w-[1600px] mx-auto px-8 py-28 lg:px-32">
                    <div class="mb-10  sm:text-left md:my-28">
                        <div class="flex justify-between items-center flex-wrap md:flex-nowrap gap-8">
                            <div>
                                <h2 class="mb-8 font-sans text-2xl font-black leading-none text-white sm:text-5xl">
                                    混合無限創意，激發無窮想像
                                </h2>
                                <p class="text-xl text-white font-thin max-w-[500px] md:text-3xl">
                                    客戶與作品是我們成長的磐石、經年累淬煉的軌跡
                                </p>
                            </div>
                            {{-- <div>
                                <img src="{{ asset('ai_dialogue.png') }}" alt="">
                            </div> --}}
                        </div>
                    </div>
                    <div class="grid gap-8 row-gap-5 sm:grid-cols-2 lg:grid-cols-3">
                        <div class="flex flex-col justify-between p-5 rounded-3xl shadow-sm"
                            style="background-color:rgb(251 251 251 / 20%);">
                            <div>
                                <div class="flex items-center w-16 h-8 mb-5 rounded-full">
                                    <img src="{{ asset('nobg_ai.png') }}" alt="">
                                </div>
                                <h3 class="mb-3 font-black leading-5 text-white">深度溝通的重要性！</h3>
                                <p class="mb-3 text-base text-white">
                                    我們相信成功的開端，建立在彼此良好的溝通與互動上。我們會花許多時間與客戶討論、溝通每個製作環節，只為了做出「對的」品牌網站。
                                </p>
                            </div>
                        </div>
                        <div class="flex flex-col justify-between p-5 rounded-3xl shadow-sm"
                            style="background-color:rgb(251 251 251 / 20%);">
                            <div>
                                <div class="flex items-center w-16 h-8 mb-5 rounded-full">
                                    <img src="{{ asset('Communication - Chat_Circle_Check.png') }}" alt="">
                                </div>
                                <h3 class="mb-3 font-black leading-5 text-white">操作容易的網站後端系統</h3>
                                <p class="mb-3 text-base text-white">
                                    在完成每個專案之後，我們會提供客戶簡單、好操作的網站後端系統，及不限次數，完全免費的面對面教學，以確保客戶能完全上手為止。
                                </p>
                            </div>
                        </div>
                        <div class="flex flex-col justify-between p-5 rounded-3xl shadow-sm"
                            style="background-color:rgb(251 251 251 / 20%);">
                            <div>
                                <div class="flex items-center w-16 h-8 mb-5 rounded-full">
                                    <img src="{{ asset('User - User_Voice.png') }}" alt="">
                                </div>
                                <h3 class="mb-3 font-black leading-5 text-white">完善的網站維護 (MaxWeb Care)</h3>
                                <p class="mb-3 text-base text-white">
                                    在完成每個專案之後，我們會提供客戶簡單、好操作的網站後端系統，及不限次數，完全免費的面對面教學，以確保客戶能完全上手為止。
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

        {{-- 品牌介紹 --}}
        <section class="text-gray-600 body-font">
            <div class="max-w-[1600px] mx-auto px-5 pt-16 lg:px-32">
                <div class="flex flex-col text-center w-full mb-12">
                    <p class="text-3xl font-black title-font mb-4 text-gray-900">混合無限多媒體</p>
                    <p class="mx-auto text-lg max-w-6xl">在數位浪潮席捲而來的今天，一個出色的網站不僅是企業的門面，更是連接世界的橋樑。我們致力於打造兼具美學與功能的網站，我們深信每個品牌都有其獨特的 DNA，而我們的使命，就是透過精準的網站設計，將您的品牌故事完美呈現。</p>
                </div>
                <div class="ml-16">
                    <img src="{{ asset('index_r6_c3.png') }}" class="mx-auto" alt="" />
                </div>
            </div>
        </section>

        {{-- <div style="padding:56.25% 0 0 0;position:relative;"><iframe
                src="https://player.vimeo.com/video/761577999?badge=0&amp;autoplay=0&amp;background=0&amp;player_id=0&amp;app_id=58479"
                frameborder="0" allow="autoplay; fullscreen; picture-in-picture; clipboard-write; encrypted-media; web-share"
                referrerpolicy="strict-origin-when-cross-origin" style="position:absolute;top:0;left:0;width:100%;height:100%;"
                title="A guitar in the bucket"></iframe></div>
        <script src="https://player.vimeo.com/api/player.js"></script> --}}

        <div style="padding:75% 0 0 0;position:relative;"><iframe
                src="https://player.vimeo.com/video/1118045211?badge=0&amp;autoplay=1&amp;background=1&amp;controls=0&amp;player_id=0&amp;app_id=58479"
                frameborder="0" allow="autoplay; fullscreen; picture-in-picture; clipboard-write; encrypted-media; web-share"
                referrerpolicy="strict-origin-when-cross-origin" style="position:absolute;top:0;left:0;width:100%;height:100%;"
                title="【牛頭牌厲害電鍋】我的輕鬆生活_30秒 - BUFFALO牛頭牌炊具 (1080p, h264) (1)"></iframe></div>
        <script src="https://player.vimeo.com/api/player.js"></script>

        {{-- 創意的累積 --}}
        <section class="sec_5 relative text-white font-light py-16">
            <div class="absolute overflow-hidden w-full h-full top-0 left-0">
                <video autoplay autostart data-video-ratio="0.6175" id="bk-video" loop muted
                    poster="{{ asset('working_space.jpg') }}" preload
                    class="w-full h-full object-cover">
                    <source src="{{ asset('working_space.webm') }}" type="video/webm">
                    <source src="{{ asset('working_space.mp4') }}" type="video/mp4">
                </video>
                <div class="absolute inset-0" style="background: #0d256e52 url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAMAAAACCAYAAACddGYaAAAAD0lEQVQIW2NkQABjRmQOAAM+AGkQsDBSAAAAAElFTkSuQmCC) repeat;"></div>
            </div>
            <div>
            <div class="relative max-w-4xl mx-auto text-center">
                <h2 class="text-3xl mb-6">創意的累積</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8" id="counter-section">
                    <div class="p-8">
                        <div class="flex justify-center">
                            <img src="{{ asset('service_icon.png') }}" title="">
                        </div>
                        <p class="text-6xl my-12 counter" data-target="15">0</p>
                        <p class="text-lg">我們的客戶</p>
                    </div>
                    <div class="p-8">
                        <div class="flex justify-center">
                            <img src="{{ asset('service_icon.png') }}" title="">
                        </div>
                        <p class="text-6xl my-12 counter" data-target="60">0</p>
                        <p class="text-lg">我們的作品</p>
                    </div>
                    <div class="p-8">
                        <div class="flex justify-center">
                            <img src="{{ asset('service_icon.png') }}" title="">
                        </div>
                        <p class="text-6xl my-12 counter" data-target="3">0</p>
                        <p class="text-lg">公司的歷史</p>
                    </div>
                </div>
            </div>
            </div>
        </section>

        {{-- 服務無限 --}}
        <section class="text-gray-500 body-font" style="background-color:#EBF0FE;">
            <div class="max-w-[1600px] mx-auto px-8 py-16 lg:px-32">
                <div class="flex flex-wrap w-full mb-16 flex-col items-center text-center">
                    <p class="sm:text-4xl text-3xl font-black title-font mb-5 text-gray-800">混合無限，服務無限</p>
                    <p class="max-w-5xl text-[#58626B] font-semibold">從概念發想到上線維護，我們提供一站式的解決方案，讓您無需煩惱繁瑣技術，專注於您的核心業務。我們結合創新思維與尖端技術，確保您的網站不僅視覺吸睛，更能提供流暢的使用體驗，讓您的網站成為強大的商業工具，在競爭激烈的市場中脫穎而出。</p>
                </div>
                <div class="flex flex-wrap -m-4">
                    <div class="xl:w-1/4 md:w-1/3">
                        <div class="p-6">
                            <div class="w-8 h-8 inline-flex items-center justify-center text-[#146CDF]">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M16 8L10 10L8 16L14 14L16 8Z" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                            <h2 class="text-xl text-gray-900 font-black title-font mb-3">網站設計與規劃</h2>
                            <p class="text-base text-[#58626B] font-semibold">網站不只是資訊的陳列，更是品牌形象與用戶體驗的整合。我們深入理解您的業務目標與品牌精神，從網站架構、視覺設計到用戶介面 (UI) 和用戶體驗 (UX)，提供客製化的網站設計與規劃服務，確保每個細節都完美契合您的需求。</p>
                        </div>
                    </div>
                    <div class="xl:w-1/4 md:w-1/3">
                        <div class="p-6">
                            <div class="w-8 h-8 inline-flex items-center justify-center text-[#146CDF]">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M12 12C12 11.4477 12.4477 11 13 11H19C19.5523 11 20 11.4477 20 12V19C20 19.5523 19.5523 20 19 20H13C12.4477 20 12 19.5523 12 19V12Z"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                    <path
                                        d="M4 5C4 4.44772 4.44772 4 5 4H8C8.55228 4 9 4.44772 9 5V19C9 19.5523 8.55228 20 8 20H5C4.44772 20 4 19.5523 4 19V5Z"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                    <path
                                        d="M12 5C12 4.44772 12.4477 4 13 4H19C19.5523 4 20 4.44772 20 5V7C20 7.55228 19.5523 8 19 8H13C12.4477 8 12 7.55228 12 7V5Z"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                </svg>
                            </div>
                            <h2 class="text-xl text-gray-900 font-black title-font mb-3">網站應用程式開發</h2>
                            <p class="text-base text-[#58626B] font-semibold">除了靜態網頁，我們更專精於開發功能強大的網站應用程式。無論是電子商務平台、預約系統、會員管理，或是客製化的資料庫應用，我們都能為您量身打造穩定、高效、安全的解決方案，滿足複雜的商業需求。</p>
                        </div>
                    </div>
                    <div class="xl:w-1/4 md:w-1/3">
                        <div class="p-6">
                            <div class="w-8 h-8 inline-flex items-center justify-center text-[#146CDF]">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12M21 12C21 7.02944 16.9706 3 12 3M21 12H19M3 12C3 7.02944 7.02944 3 12 3M3 12H5M12 3V5M13.3229 10.5C12.9703 10.1888 12.5072 10 12 10C10.8954 10 10 10.8954 10 12C10 13.1046 10.8954 14 12 14C13.1046 14 14 13.1046 14 12C14 11.4027 13.7381 10.8665 13.3229 10.5ZM13.3229 10.5L15.8229 8"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                </svg>
                            </div>
                            <h2 class="text-xl text-gray-900 font-black title-font mb-3">搜索引擎最佳化（SEO）</h2>
                            <p class="text-base text-[#58626B] font-semibold">網站設計得再好，如果沒有人看見，也無法發揮其價值。我們的 SEO 專家會將關鍵字研究、內容優化、技術 SEO 等策略融入網站設計與開發過程，有效提升您的網站在搜尋引擎上的排名，為您帶來更多精準的潛在客戶。</p>
                        </div>
                    </div>
                    <div class="xl:w-1/4 md:w-1/3">
                        <div class="p-6">
                            <div class="w-8 h-8 inline-flex items-center justify-center text-[#146CDF]">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    <circle cx="9.5" cy="9.5" r="1.5" fill="currentColor" />
                                    <circle cx="14.5" cy="9.5" r="1.5" fill="currentColor" />
                                    <path
                                        d="M15 14C15 14.394 14.9224 14.7841 14.7716 15.1481C14.6209 15.512 14.3999 15.8427 14.1213 16.1213C13.8427 16.3999 13.512 16.6209 13.1481 16.7716C12.7841 16.9224 12.394 17 12 17C11.606 17 11.2159 16.9224 10.8519 16.7716C10.488 16.6209 10.1573 16.3999 9.87868 16.1213C9.6001 15.8427 9.37913 15.512 9.22836 15.1481C9.0776 14.7841 9 14.394 9 14L12 14H15Z"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                            <h2 class="text-xl text-gray-900 font-black title-font mb-3">AI 智慧助理</h2>
                            <p class="text-base text-[#58626B] font-semibold">結合最新 AI 技術，我們能為您的網站或應用程式導入智慧問答助理。這項服務能提供 24/7 的即時客戶支援，自動解答常見問題、引導用戶、甚至提供個人化推薦，大幅提升客戶服務效率與用戶滿意度。</p>
                        </div>
                    </div>
                    <div class="xl:w-1/4 md:w-1/3">
                        <div class="p-6">
                            <div class="w-8 h-8 inline-flex items-center justify-center text-[#146CDF]">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M3 10V18C3 19.1046 3.89543 20 5 20H19C20.1046 20 21 19.1046 21 18V10M3 10V6C3 4.89543 3.89543 4 5 4H19C20.1046 4 21 4.89543 21 6V10M3 10H21"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    <circle cx="6" cy="7" r="1" fill="currentColor" />
                                    <circle cx="9" cy="7" r="1" fill="currentColor" />
                                </svg>
                            </div>
                            <h2 class="text-xl text-gray-900 font-black title-font mb-3">網站維護（MaxWeb Care）</h2>
                            <p class="text-base text-[#58626B] font-semibold">網站上線只是服務的開始。我們的「MaxWeb Care」維護服務提供定期的網站備份、安全性更新、功能故障排除與效能優化，確保您的網站始終處於最佳運行狀態，免除您的後顧之憂。</p>
                        </div>
                    </div>
                    <div class="xl:w-1/4 md:w-1/3">
                        <div class="p-6">
                            <div class="w-8 h-8 inline-flex items-center justify-center text-[#146CDF]">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M10 21L7.18762 18.9912C4.55966 17.1141 3 14.0834 3 10.8538L3 5.75432C3 5.30784 3.29598 4.91546 3.72528 4.7928L9.72528 3.07852C9.90483 3.02721 10.0952 3.02721 10.2747 3.07852L16.2747 4.7928C16.704 4.91546 17 5.30784 17 5.75432V7.50002M19 15V13C19 11.8955 18.1046 11 17 11C15.8954 11 15 11.8955 15 13V15M19 15H15M19 15C20.1046 15 21 15.8955 21 17V19C21 20.1046 20.1046 21 19 21H15C13.8954 21 13 20.1046 13 19V17C13 15.8955 13.8954 15 15 15"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                            <h2 class="text-xl text-gray-900 font-black title-font mb-3">主機與網址</h2>
                            <p class="text-base text-[#58626B] font-semibold">穩定可靠的主機與易於記憶的網址是網站成功的基石。我們提供專業的伺服器代管服務，確保網站的高速運行與資料安全。同時，也協助您挑選並註冊最能代表您品牌的專屬網址。</p>
                        </div>
                    </div>
                    <div class="xl:w-1/4 md:w-1/3">
                        <div class="p-6">
                            <div class="w-8 h-8 inline-flex items-center justify-center text-[#146CDF]">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M16 10V17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M12 7V17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    <rect x="3" y="3" width="18" height="18" rx="2" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M8 13L8 17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                            <h2 class="text-xl text-gray-900 font-black title-font mb-3">網路行銷</h2>
                            <p class="text-base text-[#58626B] font-semibold">
                                我們提供多元化的網路行銷服務，從社群媒體管理、內容行銷、付費廣告投放（如 Google Ads, Meta Ads），到口碑行銷與數據分析，協助您精準觸及目標受眾，建立品牌知名度，並將流量有效轉換為實際訂單。</p>
                        </div>
                    </div>
                    <div class="xl:w-1/4 md:w-1/3">
                        <div class="p-6">
                            <div class="w-8 h-8 inline-flex items-center justify-center text-[#146CDF]">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M11 17H13M9 21H15C16.6569 21 18 19.6569 18 18V6C18 4.34315 16.6569 3 15 3H9C7.34315 3 6 4.34315 6 6V18C6 19.6569 7.34315 21 9 21Z"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                </svg>
                            </div>
                            <h2 class="text-xl text-gray-900 font-black title-font mb-3">手機 APP 開發</h2>
                            <p class="text-base text-[#58626B] font-semibold">
                                隨著行動裝置普及，手機 App 已成為企業與用戶互動的利器。我們提供跨平台（iOS/Android）的手機 App 開發服務，從介面設計、功能開發到上架協助，為您的品牌打造流暢、創新的行動應用程式，擴展您的數位影響力。</p>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        {{-- 里程碑 --}}
                {{-- 里程碑 --}}
        <section class="sec_7 relative bg-cover bg-center" style="background-image: url('{{ asset('sec_7_bg.jpg') }}')">
                <div class="absolute inset-0 bg-[#0d256e52]">
                </div>
                <div class="max-w-[1600px] mx-auto px-8 pt-16 pb-32 lg:px-32" style="background: rgba(0,0,0,0.5) url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAMAAAACCAYAAACddGYaAAAAD0lEQVQIW2NkQABjRmQOAAM+AGkQsDBSAAAAAElFTkSuQmCC) repeat;">
                <div class="text-center mb-6">
                    <h2 class="text-4xl font-normal text-white">里程碑</h2>
                    <p class="text-lg text-red-700 mt-2">創意無限，一直是我們所追求的設計理念</p>
                </div>

                <div class="relative">
                    <!-- Timeline -->
                    <div class="relative flex justify-center items-center">

                        {{-- <x-mary-button label="Previous" wire:click="prev" />
                        <x-mary-steps wire:model="step" class="border-y border-base-content/10 my-5 py-5">
                            <x-mary-step step="1" text="Register">
                                Register step
                            </x-mary-step>
                            <x-mary-step step="2" text="Payment">
                                Payment step
                            </x-mary-step>
                            <x-mary-step step="3" text="Receive Product" class="bg-warning/20">
                                Receive Product
                            </x-mary-step>
                        </x-mary-steps>
                        <x-mary-button label="Next" wire:click="next" /> --}}
<x-milestone-timeline :milestones="$milestones" />

                        {{-- <ul class="timeline overflow-x-auto">
                            <div class="absolute top-1/2 -translate-y-1/2 w-full flex justify-between z-10 px-4">
                                <!-- "Prev" Button -->
                                <a href="#0" 8 class="prev h-[34px] w-[34px] rounded-full border-2 border-gray-300 flex items-center justify-center transition-colors duration-300 hover:border-red-500">
                                    <!-- Heroicon: chevron-left -->
                                    <svg class="w-5 h-5 text-gray-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                                    </svg>
                                    <span class="sr-only">Prev</span>
                                </a>
                                <!-- "Next" Button -->
                                <a href="#0" 18 class="next h-[34px] w-[34px] rounded-full border-2 border-gray-300 flex items-center justify-center transition-colors duration-300 hover:border-red-500">
                                    <!-- Heroicon: chevron-right -->
                                    <svg class="w-5 h-5 text-gray-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                    </svg>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>


                            <li>
                                <div class="timeline-start timeline-box">Macintosh PC</div>
                                <div class="timeline-middle">
                                    <span class="bg-primary/20 flex size-4.5 items-center justify-center rounded-full">
                                        <span class="badge badge-primary size-3 rounded-full p-0"></span>
                                    </span>
                                </div>
                                <hr />
                            </li>
                            <li>
                                <hr />
                                <div class="timeline-start timeline-box">iMac</div>
                                <div class="timeline-middle">
                                    <span class="bg-primary/20 flex size-4.5 items-center justify-center rounded-full">
                                        <span class="badge badge-primary size-3 rounded-full p-0"></span>
                                    </span>
                                </div>
                                <hr />
                            </li>
                            <li>
                                <hr />
                                <div class="timeline-start timeline-box">iPod</div>
                                <div class="timeline-middle">
                                    <span class="bg-primary/20 flex size-4.5 items-center justify-center rounded-full">
                                        <span class="badge badge-primary size-3 rounded-full p-0"></span>
                                    </span>
                                </div>
                                <hr />
                            </li>
                            <li>
                                <hr />
                                <div class="timeline-start timeline-box">iPhone</div>
                                <div class="timeline-middle">
                                    <span class="bg-primary/20 flex size-4.5 items-center justify-center rounded-full">
                                        <span class="badge badge-primary size-3 rounded-full p-0"></span>
                                    </span>
                                </div>
                                <hr />
                            </li>
                            <li>
                                <hr />
                                <div class="timeline-start timeline-box">Apple Watch</div>
                                <div class="timeline-middle">
                                    <span class="bg-primary/20 flex size-4.5 items-center justify-center rounded-full">
                                        <span class="badge badge-primary size-3 rounded-full p-0"></span>
                                    </span>
                                </div>
                                <hr />
                            </li>
                            <li>
                                <hr />
                                <div class="timeline-start timeline-box">Vision Pro</div>
                                <div class="timeline-middle">
                                    <span class="bg-primary/20 flex size-4.5 items-center justify-center rounded-full">
                                        <span class="badge badge-primary size-3 rounded-full p-0"></span>
                                    </span>
                                </div>
                            </li>
                        </ul> --}}

                    </div>
<!-- Timeline end-->
                    <!-- Content -->
                    {{-- <div class="relative w-full h-40 overflow-hidden">
                        <template x-for="(milestone, index) in milestones" :key="index">
                            <div x-show="activeMilestoneIndex === index"
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 transform translate-y-4"
                                 x-transition:enter-end="opacity-100 transform translate-y-0"
                                 x-transition:leave="transition ease-in duration-200 absolute"
                                 x-transition:leave-start="opacity-100 transform translate-y-0"
                                 x-transition:leave-end="opacity-0 transform -translate-y-4"
                                 class="text-center w-full absolute inset-0">
                                <h3 class="text-2xl font-bold text-white" x-text="milestone.title"></h3>
                                <em class="text-sm text-gray-400 my-2 block" x-text="milestone.date"></em>
                                <p class="text-gray-300 max-w-2xl mx-auto" x-text="milestone.description"></p>
                            </div>
                        </template>
                    </div> --}}
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


    </div>
