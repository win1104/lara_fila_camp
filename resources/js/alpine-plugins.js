import focus from '@alpinejs/focus';

// 等待 Livewire 初始化完成
document.addEventListener('livewire:init', () =>
{
    // 註冊 Focus 插件
    window.Alpine.plugin(focus);
});
