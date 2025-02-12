document.addEventListener('DOMContentLoaded', function() {
    let currentFieldId = '';

    function editField(fieldId) {
        currentFieldId = fieldId;
        const field = document.getElementById(fieldId);
        field.readOnly = false;
        field.focus();
        document.getElementById('saveButton').style.display = 'block';
    }

    function showConfirmModal() {
        $('#confirmModal').modal('show');
    }

    document.getElementById('confirmButton').addEventListener('click', function() {
        document.getElementById('perfilForm').submit();
    });

    document.getElementById('cancelButton').addEventListener('click', function() {
        const field = document.getElementById(currentFieldId);
        field.readOnly = true;
        $('#confirmModal').modal('hide');
    });

    document.querySelector('.modal .close').addEventListener('click', function() {
        const field = document.getElementById(currentFieldId);
        field.readOnly = true;
        $('#confirmModal').modal('hide');
    });

    window.editField = editField;
    window.showConfirmModal = showConfirmModal;
    window.validatePhoneNumber = function(input) {
        input.value = input.value.replace(/\D/g, '').slice(0, 10);
    };
});