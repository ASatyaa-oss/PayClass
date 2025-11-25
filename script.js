function showForm(formId) {
    const forms = document.querySelectorAll('.form-box');
    forms.forEach(form => form.classList.remove('active'));
    const targetId = formId || 'login-form';
    const target = document.getElementById(targetId);
    if (target) {
        target.classList.add('active');
    } else {
        console.warn('showForm: element not found for id', targetId);
    }
}