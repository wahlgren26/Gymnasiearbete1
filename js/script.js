// Optimerad sidebar toggle med förbättrad prestanda
document.addEventListener('DOMContentLoaded', function() {
    const hamBurger = document.querySelector(".toggle-btn");
    const sidebar = document.querySelector("#sidebar");
    
    if (hamBurger && sidebar) {
        // Använd requestAnimationFrame för smidigare animationer
        hamBurger.addEventListener("click", function() {
            requestAnimationFrame(function() {
                sidebar.classList.toggle("expand");
            });
        });
        
        // Stäng sidebaren om användaren klickar utanför
        document.addEventListener('click', function(e) {
            // Kontrollera om klicket var utanför sidebaren och hamburger-knappen
            // och om sidebaren är expanderad
            if (!sidebar.contains(e.target) && 
                !hamBurger.contains(e.target) && 
                sidebar.classList.contains('expand')) {
                
                requestAnimationFrame(function() {
                    sidebar.classList.remove("expand");
                });
            }
        });
    }
}); 