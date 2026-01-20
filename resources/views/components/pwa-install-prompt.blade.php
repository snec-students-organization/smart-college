<div id="pwa-install-prompt"
    class="fixed bottom-4 left-4 right-4 md:left-auto md:right-4 md:w-96 bg-white dark:bg-gray-800 p-4 rounded-xl shadow-2xl border border-gray-100 dark:border-gray-700 transform translate-y-full transition-transform duration-300 z-50 flex flex-col gap-4 hidden">
    <div class="flex items-start gap-4">
        <div class="bg-indigo-100 dark:bg-indigo-900/30 p-3 rounded-lg flex-shrink-0">
            <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
            </svg>
        </div>
        <div class="flex-1">
            <h3 class="font-bold text-gray-900 dark:text-gray-100">Install App</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Install Smart College on your home screen for quick
                access and offline use.</p>
        </div>
        <button id="pwa-dismiss" class="text-gray-400 hover:text-gray-500">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
    <div class="flex gap-3">
        <button id="pwa-install-btn"
            class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium text-sm transition-colors text-center">
            Install Now
        </button>
    </div>
</div>

<script>
    let deferredPrompt;
    const installPrompt = document.getElementById('pwa-install-prompt');
    const installBtn = document.getElementById('pwa-install-btn');
    const dismissBtn = document.getElementById('pwa-dismiss');

    window.addEventListener('beforeinstallprompt', (e) => {
        // Prevent Chrome 67 and earlier from automatically showing the prompt
        e.preventDefault();
        // Stash the event so it can be triggered later.
        deferredPrompt = e;
        // Update UI to notify the user they can add to home screen
        installPrompt.classList.remove('hidden');
        // Small delay to allow display:block to apply before transition
        setTimeout(() => {
            installPrompt.classList.remove('translate-y-full');
        }, 10);

        console.log('PWA Install Prompt fired');
    });

    installBtn.addEventListener('click', async () => {
        // Hide the app provided install promotion
        installPrompt.classList.add('translate-y-full');
        // Show the install prompt
        if (deferredPrompt) {
            deferredPrompt.prompt();
            // Wait for the user to respond to the prompt
            const { outcome } = await deferredPrompt.userChoice;
            console.log(`User response to the install prompt: ${outcome}`);
            deferredPrompt = null;
        }
        // Completely hide after animation
        setTimeout(() => {
            installPrompt.classList.add('hidden');
        }, 300);
    });

    dismissBtn.addEventListener('click', () => {
        installPrompt.classList.add('translate-y-full');
        setTimeout(() => {
            installPrompt.classList.add('hidden');
        }, 300);
    });

    // Check if app is already installed
    window.addEventListener('appinstalled', () => {
        // Hide the app-provided install promotion
        installPrompt.classList.add('hidden');
        deferredPrompt = null;
        console.log('PWA was installed');
    });
</script>