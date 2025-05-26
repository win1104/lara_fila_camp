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
});
