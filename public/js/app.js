import './notif.js';

document.addEventListener('DOMContentLoaded', function() {
    if (window.NotificationManager) {
        window.NotificationManager.init();
    }

    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function() {
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = 'Processing...';
                submitBtn.classList.add('loading');

                setTimeout(() => {
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('loading');
                    submitBtn.innerHTML = submitBtn.dataset.originalText || 'Submit';
                }, 5000);
            }
        });
    });

    document.querySelectorAll('button[type="submit"]').forEach(btn => {
        btn.dataset.originalText = btn.innerHTML;
    });

    const deleteForms = document.querySelectorAll('form[method="POST"]:has(input[name="_method"][value="DELETE"])');
    deleteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const confirmation = confirm('Are you sure you want to delete this item? This action cannot be undone.');

            if (confirmation) {
                this.submit();
            }
        });
    });

    const alerts = document.querySelectorAll('.alert:not(.alert-persistent)');
    alerts.forEach(alert => {
        setTimeout(() => {
            fadeOut(alert);
        }, 5000);
    });

    const alertCloses = document.querySelectorAll('.alert-close');
    alertCloses.forEach(closeBtn => {
        closeBtn.addEventListener('click', function() {
            const alert = this.closest('.alert');
            fadeOut(alert);
        });
    });

    const tableRows = document.querySelectorAll('.table tbody tr');
    tableRows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.01)';
            this.style.transition = 'all 0.2s ease';
        });

        row.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });

    const inputs = document.querySelectorAll('.form-input, .form-select');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            validateField(this);
        });

        input.addEventListener('input', function() {
            this.classList.remove('is-invalid', 'is-valid');
        });
    });

    const navLinks = document.querySelectorAll('.nav-button');
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            this.style.opacity = '0.6';
        });
    });

    const mobileMenuTrigger = document.querySelector('.mobile-menu-trigger');
    const mobileMenu = document.querySelector('.mobile-menu');

    if (mobileMenuTrigger && mobileMenu) {
        mobileMenuTrigger.addEventListener('click', function() {
            mobileMenu.classList.toggle('active');
        });
    }

    const searchInput = document.querySelector('#search');
    if (searchInput) {
        let searchTimeout;

        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                handleSearch(this.value);
            }, 300);
        });
    }

    const cards = document.querySelectorAll('.card');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('slide-in');
            }
        });
    });

    cards.forEach(card => {
        observer.observe(card);
    });
});

function fadeOut(element) {
    element.style.transition = 'opacity 0.3s ease';
    element.style.opacity = '0';

    setTimeout(() => {
        element.style.display = 'none';
        element.remove();
    }, 300);
}

function validateField(field) {
    const value = field.value.trim();
    const isRequired = field.hasAttribute('required');

    if (isRequired && !value) {
        field.classList.add('is-invalid');
        return false;
    }

    if (field.type === 'email' && value) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(value)) {
            field.classList.add('is-invalid');
            return false;
        }
    }

    field.classList.add('is-valid');
    return true;
}

function handleSearch(query) {
    console.log('Searching for:', query);

    const tableRows = document.querySelectorAll('.table tbody tr');

    tableRows.forEach(row => {
        const text = row.textContent.toLowerCase();
        const matches = text.includes(query.toLowerCase());

        row.style.display = matches || !query ? '' : 'none';
    });
}

window.AppHelpers = {
    fadeOut,
    validateField,
    handleSearch
};
