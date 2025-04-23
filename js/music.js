// music.js - Specific JS for the music page
document.addEventListener('DOMContentLoaded', function() {
    // Get user ID for personalized storage
    function getUserId() {
        const userIdField = document.getElementById('current_user_id');
        if (userIdField && userIdField.value) {
            return userIdField.value;
        }
        return 'default_user';
    }
    
    // Function to show toast notifications
    function showToast(message, type = 'success') {
        const toastEl = document.createElement('div');
        toastEl.className = `toast align-items-center text-white bg-${type} border-0`;
        toastEl.setAttribute('role', 'alert');
        toastEl.setAttribute('aria-live', 'assertive');
        toastEl.setAttribute('aria-atomic', 'true');
        
        toastEl.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    <i class="lni lni-${type === 'success' ? 'checkmark-circle' : 'alarm-clock'} me-2"></i>
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        `;
        
        document.querySelector('.toast-container').appendChild(toastEl);
        
        const toast = new bootstrap.Toast(toastEl, {
            delay: 3000,
            autohide: true
        });
        
        toast.show();
        
        // Remove the element after it's hidden
        toastEl.addEventListener('hidden.bs.toast', function() {
            toastEl.remove();
        });
    }
    
    // Playlist data är deklarerad globalt i PHP
    // men vi implementerar en fallback om den inte finns
    const playlistData = window.playlistData || {};
    
    // Load favorites from localStorage
    function loadFavorites() {
        const userId = getUserId();
        const favorites = JSON.parse(localStorage.getItem(`music_favorites_${userId}`) || '[]');
        
        // Update buttons
        document.querySelectorAll('.favorite-btn').forEach(btn => {
            const category = btn.getAttribute('data-category');
            const index = parseInt(btn.getAttribute('data-index'));
            
            // Check if playlist is in favorites
            const isFavorite = favorites.some(fav => 
                fav.category === category && fav.index === index
            );
            
            if (isFavorite) {
                btn.classList.add('active');
                btn.title = 'Remove from favorites';
            } else {
                btn.classList.remove('active');
                btn.title = 'Add to favorites';
            }
        });
        
        // Render favorites tab
        const noFavorites = document.getElementById('no-favorites');
        const favoritesContainer = document.getElementById('favorites-container');
        
        if (!noFavorites || !favoritesContainer) return;
        
        if (favorites.length === 0) {
            noFavorites.style.display = 'block';
            favoritesContainer.innerHTML = '';
            return;
        }
        
        noFavorites.style.display = 'none';
        favoritesContainer.innerHTML = '';
        
        favorites.forEach(fav => {
            if (!window.playlistData || 
                !window.playlistData[fav.category] || 
                !window.playlistData[fav.category].playlists || 
                !window.playlistData[fav.category].playlists[fav.index]) {
                return; // Skip if playlist doesn't exist
            }
            
            const playlist = window.playlistData[fav.category].playlists[fav.index];
            const categoryName = window.playlistData[fav.category].title;
            
            const playlistEl = document.createElement('div');
            playlistEl.className = 'col-lg-6 col-md-12';
            playlistEl.innerHTML = `
                <div class="card playlist-card shadow-sm position-relative">
                    <button class="favorite-btn active" 
                            data-category="${fav.category}" 
                            data-index="${fav.index}" 
                            title="Remove from favorites">
                        <i class="lni lni-heart"></i>
                    </button>
                    <div class="card-body">
                        <span class="badge bg-light text-dark mb-2">${categoryName}</span>
                        <h5 class="card-title fw-bold mb-2">${playlist.title}</h5>
                        <p class="card-text text-muted mb-3">${playlist.description}</p>
                        <iframe src="${playlist.embed_url}" 
                                width="100%" height="352" frameborder="0" 
                                allowtransparency="true" allow="encrypted-media" 
                                class="rounded"></iframe>
                    </div>
                </div>
            `;
            
            favoritesContainer.appendChild(playlistEl);
        });
        
        // Add event listeners to favorite buttons in favorites tab
        favoritesContainer.querySelectorAll('.favorite-btn').forEach(btn => {
            btn.addEventListener('click', toggleFavorite);
        });
    }
    
    // Toggle favorite status
    function toggleFavorite() {
        const btn = this;
        const category = btn.getAttribute('data-category');
        const index = parseInt(btn.getAttribute('data-index'));
        const userId = getUserId();
        
        let favorites = JSON.parse(localStorage.getItem(`music_favorites_${userId}`) || '[]');
        
        // Check if it's already a favorite
        const favIndex = favorites.findIndex(fav => 
            fav.category === category && fav.index === index
        );
        
        if (favIndex >= 0) {
            // Remove from favorites
            favorites.splice(favIndex, 1);
            btn.classList.remove('active');
            btn.title = 'Add to favorites';
            showToast('Removed from favorites');
        } else {
            // Add to favorites
            favorites.push({ category, index });
            btn.classList.add('active');
            btn.title = 'Remove from favorites';
            showToast('Added to favorites');
        }
        
        // Save to localStorage
        localStorage.setItem(`music_favorites_${userId}`, JSON.stringify(favorites));
        
        // Reload favorites tab
        loadFavorites();
    }
    
    // Initiera allt som behövs för musiksidan
    function initMusicPage() {
        // Lägg till event listeners för favorit-knappar
        document.querySelectorAll('.favorite-btn').forEach(btn => {
            btn.addEventListener('click', toggleFavorite);
        });
        
        // Ladda favoriter vid sidladdning
        loadFavorites();
        
        // Hantera flikändringar
        const tabs = document.querySelectorAll('[data-bs-toggle="tab"]');
        tabs.forEach(tab => {
            tab.addEventListener('shown.bs.tab', function() {
                // Uppdatera favoriter när fliken visas
                if (tab.id === 'favorites-tab') {
                    loadFavorites();
                }
            });
        });
    }
    
    // Starta allt
    initMusicPage();
}); 