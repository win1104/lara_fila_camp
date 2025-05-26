import './bootstrap';
import './alpine-plugins';

// resources/js/app.js
function toggleTheme()
{
    if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches))
    {
        // 切換到淺色主題
        document.documentElement.classList.remove('dark');
        document.documentElement.setAttribute('data-theme', 'light'); //for DaisyUI
        localStorage.theme = 'light';
    }
    else
    {
        // 切換到深色主題
        document.documentElement.classList.add('dark');
        document.documentElement.setAttribute('data-theme', 'dark'); //for DaisyUI
        localStorage.theme = 'dark';
    }
}

// 頁面載入時設置主題
if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches))
{
    document.documentElement.classList.add('dark');
    document.documentElement.setAttribute('data-theme', 'dark'); //for DaisyUI
}
else
{
    document.documentElement.classList.remove('dark');
    document.documentElement.setAttribute('data-theme', 'light'); //for DaisyUI
}

// 將函數放到全域
window.toggleTheme = toggleTheme;
