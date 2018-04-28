// tinymce.init({ selector:'textarea' });
tinymce.init({
    selector:'textarea',
    setup: function(editor) {
        editor.getElement().removeAttribute('required');
    },
});