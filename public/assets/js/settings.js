document.addEventListener('DOMContentLoaded', function() {
    const tabsList = document.getElementById('settingsTabs');
    if (!tabsList) return;

    // Function to activate a tab
    function activateTab(tabId) {
        const targetTab = document.querySelector(`[data-tab-id="${tabId}"]`);
        if (targetTab) {
            const tab = new bootstrap.Tab(targetTab);
            tab.show();
        }
    }

    // Function to update URL
    function updateURL(tabId) {
        const url = new URL(window.location);
        url.hash = tabId;
        window.history.replaceState({}, '', url);
    }

    // Handle tab changes
    tabsList.addEventListener('shown.bs.tab', function(event) {
        const tabId = event.target.getAttribute('data-tab-id');
        updateURL(tabId);
    });

    // Set initial tab based on URL hash or default to first tab
    function setInitialTab() {
        let tabId = 'general'; // default tab
        if (window.location.hash) {
            tabId = window.location.hash.replace('#', '');
        }
        activateTab(tabId);
    }

    // Initialize
    setInitialTab();

    // Handle browser back/forward
    window.addEventListener('hashchange', function() {
        const newTab = window.location.hash.replace('#', '') || 'general';
        activateTab(newTab);
    });

    // Toggle password visibility
    window.togglePassword = function(inputId) {
        const input = document.getElementById(inputId);
        const type = input.type === 'password' ? 'text' : 'password';
        input.type = type;

        const icon = event.currentTarget.querySelector('i');
        icon.classList.toggle('bi-eye');
        icon.classList.toggle('bi-eye-slash');
    };
});
