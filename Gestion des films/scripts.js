// Handle modal display
document.addEventListener('DOMContentLoaded', function() {
    // Get the modal
    const modal = document.getElementById('addFilmModal');
    
    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    }
    
    // Show success message for comments if parameter exists
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('comment_success')) {
        alert('Commentaire ajouté avec succès!');
    }
});

// Form validation
function validateFilmForm() {
    const title = document.getElementById('title').value;
    const synopsis = document.getElementById('synopsis').value;
    const releaseYear = document.getElementById('release_year').value;
    
    if (title.length < 3) {
        alert('Le titre doit contenir au moins 3 caractères');
        return false;
    }
    
    if (synopsis && synopsis.length < 50) {
        alert('Le synopsis doit contenir au moins 50 caractères');
        return false;
    }
    
    const currentYear = new Date().getFullYear();
    if (releaseYear < 2000 || releaseYear > currentYear) {
        alert(`L'année de sortie doit être entre 2000 et ${currentYear}`);
        return false;
    }
    
    return true;
}