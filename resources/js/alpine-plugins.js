import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';

// 註冊 Focus 插件
Alpine.plugin(focus);

// 等待 Livewire 初始化完成
document.addEventListener('livewire:init', () =>
{
    // 初始化 Alpine
    window.Alpine = Alpine;
    Alpine.start();
    console.log('Livewire initialized');
});

// 等待 Livewire 更新完成
document.addEventListener('livewire:navigated', () =>
{
    // 確保 Alpine 已經啟動
    if (!window.Alpine)
    {
        window.Alpine = Alpine;
        Alpine.start();
    }
    console.log('Livewire navigated');
});

// 處理 Alpine 錯誤
window.addEventListener('alpine:init', () =>
{
    Alpine.onError = (error) =>
    {
        console.warn('Alpine Error:', error);
        // 如果是找不到 Livewire 組件的錯誤，我們可以忽略它
        if (error.message.includes('Cannot read properties of undefined'))
        {
            return true; // 阻止錯誤繼續傳播
        }
    };
});
