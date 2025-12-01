// Language Selector - Change URL locale while preserving slug
(function() {
    'use strict';
    
    function initLanguageSelector(selectId) {
        const select = document.getElementById(selectId);
        if (!select) return;
        
        select.addEventListener('change', function() {
            const newLocale = this.value;
            const currentPath = window.location.pathname;
            
            // Get supported locales from config
            const supportedLocales = ['en', 'az', 'ru'];
            
            // Split path into segments
            const segments = currentPath.split('/').filter(s => s);
            
            // Check if first segment is a locale
            if (segments.length > 0 && supportedLocales.includes(segments[0])) {
                // Replace locale (keep slug and other params)
                segments[0] = newLocale;
            } else {
                // Add locale at beginning
                segments.unshift(newLocale);
            }
            
            // Rebuild URL
            const newPath = '/' + segments.join('/');
            const queryString = window.location.search;
            const hash = window.location.hash;
            
            window.location.href = newPath + queryString + hash;
        });
    }
    
    // Initialize both language selectors
    document.addEventListener('DOMContentLoaded', function() {
        initLanguageSelector('footerSettingsLanguage');
        initLanguageSelector('footerSettingsLanguage_mobile');
    });
})();

