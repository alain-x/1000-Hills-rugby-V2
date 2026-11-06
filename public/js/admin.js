document.addEventListener('DOMContentLoaded', function () {
    // Image preview for file inputs
    document.querySelectorAll('input[type="file"][data-preview]').forEach(function (input) {
        input.addEventListener('change', function () {
            const preview = document.querySelector(input.getAttribute('data-preview'));
            if (!preview || !input.files || !input.files[0]) return;
            const url = URL.createObjectURL(input.files[0]);
            if (preview.tagName === 'IMG') {
                preview.src = url;
                preview.classList.remove('d-none');
            } else {
                preview.style.backgroundImage = 'url(' + url + ')';
            }
        });
    });

    // Slug helper
    document.querySelectorAll('[data-slug-source]').forEach(function (source) {
        const target = document.querySelector(source.getAttribute('data-slug-target'));
        if (!target) return;
        source.addEventListener('input', function () {
            if (target.dataset.touched === '1') return;
            target.value = source.value
                .toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .trim()
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');
        });
        target.addEventListener('input', function () { target.dataset.touched = '1'; });
    });

    // Confirm destructive actions
    document.querySelectorAll('form[data-confirm]').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!window.confirm(form.getAttribute('data-confirm'))) {
                event.preventDefault();
            }
        });
    });

    // Rich text editors
    if (window.Quill) {
        document.querySelectorAll('[data-quill]').forEach(function (wrapper) {
            const textarea = wrapper.querySelector('textarea');
            if (!textarea) return;
            const editor = new Quill(wrapper.querySelector('.quill-editor'), {
                theme: 'snow',
                modules: {
                    toolbar: [
                        [{ header: [2, 3, false] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ list: 'ordered' }, { list: 'bullet' }],
                        ['blockquote', 'link'],
                        ['clean']
                    ]
                }
            });
            editor.root.innerHTML = textarea.value || '';
            editor.on('text-change', function () {
                textarea.value = editor.root.innerHTML;
            });
            const form = textarea.closest('form');
            if (form) {
                form.addEventListener('submit', function () {
                    textarea.value = editor.root.innerHTML;
                });
            }
        });
    }

    // Bootstrap tooltips
    if (window.bootstrap && window.bootstrap.Tooltip) {
        document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function (el) {
            new bootstrap.Tooltip(el);
        });
    }
});
