document.querySelector(".header").innerHTML = `
    <div class="header-content">
        <div class="header-left">
            <a class="menu-button">
                <img class="menu-icon" src="../general/menu-images/menu-icon.png">
            </a>
        </div>

        <div class="header-mid">      
            <img class="crm-icon" src="../general/menu-images/hp-logo.png">
        </div>
        
        <div class="header-right bell-container">
            <a href="../Notifications/notifications.html" class="bell-icon">
                <img src="../general/menu-images/bell-icon.png">
            </a>
            <a href="../signin.php" class="logout-container">
                <img class="logout-icon" src="../general/menu-images/logout-icon.png">
            </a>
        </div>
    </div>
`;
