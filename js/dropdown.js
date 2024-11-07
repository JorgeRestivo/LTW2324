document.addEventListener('DOMContentLoaded', function() {
    var dropdown = document.querySelector('.dropdown');
    dropdown.addEventListener('click', function(event) {
        event.stopPropagation();
        dropdown.querySelector('.dropdown-content').classList.toggle('show');
    });

    window.addEventListener('click', function() {
        var dropdowns = document.querySelectorAll('.dropdown-content');
        dropdowns.forEach(function(dropdownContent) {
            if (dropdownContent.classList.contains('show')) {
                dropdownContent.classList.remove('show');
            }
        });
    });
});