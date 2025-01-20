document.addEventListener('DOMContentLoaded', function () {
    const tabs = document.querySelectorAll('.tab-link');
    const tabContents = document.querySelectorAll('.tab-content');

    tabs.forEach(tab => {
        tab.addEventListener('click', function () {
            // Remove active class from all tabs
            tabs.forEach(t => {
                t.classList.remove('active');
            });

            // Hide all tab contents
            tabContents.forEach(content => content.classList.add('hidden'));

            // Activate the clicked tab and show corresponding
            const target = this.getAttribute('data-target');
            document.getElementById(target).classList.remove('hidden');

            this.classList.add('active');
        });
    });
});
