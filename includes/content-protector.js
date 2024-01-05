(function () {
    // Retrieve custom messages from options
    var customAdminMessage = cp_custom_messages.adminMessage || 'Gotcha!😜 Content is protected. Copying is not allowed.';
    var customRightClickMessage = cp_custom_messages.rightClickMessage || 'For copyright protection, right-clicking is currently disabled on this website. Sorry for the inconvenience.';
    
    // Retrieve values from localStorage
    var enableCopyProtection = localStorage.getItem('son_cp_enable_copy_protection');
    var enableRightClickProtection = localStorage.getItem('son_cp_enable_right_click_protection');

    // Display the copy protection alert
    function showCopyProtectionAlert() {
        alert(customAdminMessage);
    }

    // Display the right-click protection alert
    function showRightClickProtectionAlert() {
        alert(customRightClickMessage);
    }

    // Attach event listeners based on settings
    if (enableCopyProtection === '1') { 
        document.addEventListener('copy', function (event) {
            showCopyProtectionAlert();
            event.preventDefault();
        });
    }

    if (enableRightClickProtection === '1') { 
        // Disable right-click on the whole document
        document.addEventListener('contextmenu', function (event) {
            showRightClickProtectionAlert();
            event.preventDefault();
        });
    }
})();
