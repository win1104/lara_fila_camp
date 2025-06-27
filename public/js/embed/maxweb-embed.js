/**
 * MaxWeb Embed System - Vanilla JavaScript Version
 * 替代 jQuery + pym.js 的現代化解決方案
 * 版本: 1.0.0
 */

(function ()
{
    'use strict';

    class MaxWebEmbed
    {
        constructor()
        {
            this.embedContainers = [];
            this.defaultConfig = {
                baseUrl: 'http://127.0.0.1:8000/embed/',
                // baseUrl: 'https://maxwebapp.com.tw/arbor_inquiry/inquiry/inquiry_info/data/arbor_inquiry/en/seminar/',
                // baseUrl: 'https://maxwebapp.com.tw/arbor_inquiry/embed/',
                minHeight: 300,
                maxHeight: 800,
                ratios: {
                    mobile: 1.2,    // 手機版高度比例
                    tablet: 0.8,    // 平板版高度比例
                    desktop: 0.6    // 桌面版高度比例
                }
            };
            this.init();
        }

        init()
        {
            if (document.readyState === 'loading')
            {
                document.addEventListener('DOMContentLoaded', () =>
                {
                    this.findAndEmbed();
                });
            } else
            {
                this.findAndEmbed();
            }
            this.setupPostMessage();
        }

        findAndEmbed()
        {
            const containers = document.querySelectorAll('.max_inquiry_box[data]');
            containers.forEach((container) =>
            {
                this.embedInContainer(container);
            });
        }

        embedInContainer(container)
        {
            const dataId = container.getAttribute('data');
            if (!dataId)
            {
                this.showError(container, '缺少 data 屬性');
                return;
            }

            // 顯示載入狀態
            this.showLoading(container);

            try
            {
                const iframe = this.createIframe(dataId);
                container.innerHTML = '';
                container.appendChild(iframe);

                this.makeResponsive(iframe, container);
                this.embedContainers.push({
                    container: container,
                    iframe: iframe,
                    dataId: dataId
                });
            } catch (error)
            {
                this.showError(container, '建立 iframe 時發生錯誤: ' + error.message);
            }
        }

        createIframe(dataId)
        {
            const iframe = document.createElement('iframe');
            iframe.src = this.defaultConfig.baseUrl + dataId;
            iframe.style.width = '100%';
            iframe.style.border = '0';
            iframe.style.height = this.defaultConfig.minHeight + 'px';
            iframe.style.minHeight = this.defaultConfig.minHeight + 'px';
            iframe.setAttribute('allowfullscreen', '');
            iframe.setAttribute('loading', 'lazy');
            iframe.setAttribute('frameborder', '0');

            // 安全屬性
            iframe.setAttribute('sandbox', 'allow-scripts allow-same-origin allow-forms allow-popups');

            // 載入事件處理
            iframe.addEventListener('load', () =>
            {
                console.log('MaxWeb Embed: iframe loaded successfully for ID:', dataId);
            });

            iframe.addEventListener('error', () =>
            {
                this.handleIframeError(iframe, dataId);
            });

            return iframe;
        }

        showLoading(container)
        {
            container.innerHTML = '<div class="maxweb-loading">載入中...</div>';
        }

        showError(container, message)
        {
            container.innerHTML = '<div class="maxweb-error">載入失敗: ' + message + '</div>';
        }

        handleIframeError(iframe, dataId)
        {
            const container = iframe.parentElement;
            if (container)
            {
                this.showError(container, '無法載入內容 (ID: ' + dataId + ')');
            }
        }

        makeResponsive(iframe, container)
        {
            // 使用 ResizeObserver 監聽容器大小變化
            if (window.ResizeObserver)
            {
                const resizeObserver = new ResizeObserver(() =>
                {
                    this.handleResize(iframe, container);
                });
                resizeObserver.observe(container);
            }

            // 備用方案：監聽 window resize
            window.addEventListener('resize', () =>
            {
                this.handleResize(iframe, container);
            });

            // 初始化尺寸
            setTimeout(() =>
            {
                this.handleResize(iframe, container);
            }, 100);
        }

        handleResize(iframe, container)
        {
            try
            {
                const containerWidth = container.offsetWidth;
                let newHeight;

                // 根據寬度調整高度
                if (containerWidth < 480)
                {
                    newHeight = containerWidth * this.defaultConfig.ratios.mobile;
                } else if (containerWidth < 768)
                {
                    newHeight = containerWidth * this.defaultConfig.ratios.tablet;
                } else
                {
                    newHeight = containerWidth * this.defaultConfig.ratios.desktop;
                }

                // 限制高度範圍
                newHeight = Math.max(this.defaultConfig.minHeight, Math.min(newHeight, this.defaultConfig.maxHeight));

                iframe.style.height = newHeight + 'px';
            } catch (error)
            {
                console.error('MaxWeb Embed: Resize error:', error);
            }
        }

        // 跨域通訊處理（如果 A 網站支援）
        setupPostMessage()
        {
            window.addEventListener('message', (event) =>
            {
                try
                {
                    // 檢查來源安全性
                    if (event.origin !== 'https://maxwebapp.com.tw')
                    {
                        return;
                    }

                    const data = event.data;
                    if (data && data.type === 'resize' && data.height)
                    {
                        this.resizeIframeByMessage(data);
                    }
                } catch (error)
                {
                    console.error('MaxWeb Embed: PostMessage error:', error);
                }
            });
        }

        resizeIframeByMessage(data)
        {
            try
            {
                const iframe = document.querySelector('iframe[src*="' + data.id + '"]');
                if (iframe && data.height)
                {
                    const height = Math.max(this.defaultConfig.minHeight, Math.min(data.height, this.defaultConfig.maxHeight));
                    iframe.style.height = height + 'px';
                }
            } catch (error)
            {
                console.error('MaxWeb Embed: Message resize error:', error);
            }
        }

        // 公共方法：手動重新載入特定嵌入
        reload(dataId)
        {
            const container = this.embedContainers.find(item => item.dataId === dataId);
            if (container)
            {
                this.embedInContainer(container.container);
            }
        }

        // 公共方法：手動調整所有嵌入的尺寸
        resizeAll()
        {
            this.embedContainers.forEach((item) =>
            {
                this.handleResize(item.iframe, item.container);
            });
        }
    }

    // 避免重複初始化
    if (!window.MaxWebEmbedInstance)
    {
        window.MaxWebEmbedInstance = new MaxWebEmbed();

        // 暴露一些公共方法到全域
        window.MaxWebEmbed = {
            reload: function (dataId)
            {
                window.MaxWebEmbedInstance.reload(dataId);
            },
            resizeAll: function ()
            {
                window.MaxWebEmbedInstance.resizeAll();
            }
        };
    }

})();