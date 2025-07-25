<script>
// Filament 獨立主題切換功能 - 只在 admin 頁面中運行
if (window.location.pathname.includes('/admin')) {
    document.addEventListener('DOMContentLoaded', function() {
        const FILAMENT_THEME_KEY = 'filament_admin_theme';
        
        function getFilamentTheme() {
            return localStorage.getItem(FILAMENT_THEME_KEY) || 'light';
        }
        
        function setFilamentTheme(theme) {
            localStorage.setItem(FILAMENT_THEME_KEY, theme);
            applyFilamentTheme(theme);
        }
        
        function applyFilamentTheme(theme) {
            const html = document.documentElement;
            if (theme === 'dark') {
                html.classList.add('dark');
            } else {
                html.classList.remove('dark');
            }
        }
        
        // 初始化主題
        const currentTheme = getFilamentTheme();
        applyFilamentTheme(currentTheme);
        
        // 覆蓋 Filament 的預設主題存儲
        const originalSetItem = localStorage.setItem.bind(localStorage);
        const originalGetItem = localStorage.getItem.bind(localStorage);
        
        localStorage.setItem = function(key, value) {
            if (key === 'theme' || key === 'filament_theme') {
                return originalSetItem(FILAMENT_THEME_KEY, value);
            }
            return originalSetItem(key, value);
        };
        
        localStorage.getItem = function(key) {
            if (key === 'theme' || key === 'filament_theme') {
                return originalGetItem(FILAMENT_THEME_KEY) || 'light';
            }
            return originalGetItem(key);
        };
        
        // 監聽主題變化
        const themeObserver = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                    const isDark = document.documentElement.classList.contains('dark');
                    const storedTheme = getFilamentTheme();
                    const expectedTheme = isDark ? 'dark' : 'light';
                    
                    if (storedTheme !== expectedTheme) {
                        setFilamentTheme(expectedTheme);
                    }
                }
            });
        });
        
        themeObserver.observe(document.documentElement, {
            attributes: true,
            attributeFilter: ['class']
        });
    });
}
</script>