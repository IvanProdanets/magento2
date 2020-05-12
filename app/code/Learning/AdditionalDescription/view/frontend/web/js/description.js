define(
    [ 'jquery' ],
    function ($) {
        const $modal = $('#modal-form');
        const $modalForm = $('#additional-description-form');
        const modalButton = '.open-modal-form';
        const $descriptionId = $('#description_id');
        const $descriptionField = $('#description_field');

        const getModalOptions = () => {
            return {
                type: 'popup',
                responsive: true,
                buttons: [{
                    text: $.mage.__('Save'),
                    click: saveDescription
                }]
            };
        };

        const getDescription = (id) => {
            const action = '/additional/index/index?id=' + id;

            $.ajax({
                url: action,
                type: 'get',
                dataType: 'json',
                context: $modal,
                showLoader: true,
                success: (data) => {
                    updateFormData(data.data);
                },
                error: (error) => {
                    alert($.mage.__('Request Error'), error.error);
                }
            });
        };

        const updateFormData = (data) => {
            if (data !== undefined) {
                $descriptionField.text(data.additional_description);
                $descriptionId.val(data.id);
            }
        };

        const saveDescription = () => {
            const action = $modalForm.attr('action');

            $.ajax({
                url: action,
                type: 'post',
                dataType: 'json',
                data: $modalForm.serializeArray(),
                context: $modal,
                showLoader: true,
                success: (data) => {
                    $modal.trigger('closeModal');
                    location.reload();
                },
                error: (error) => {
                    alert($.mage.__('Save Error'), error.error);
                },
            });
        };

        const init = () => {
            $(document).on('click', modalButton, function () {
                $modal.modal(getModalOptions());
                $modal.trigger("reset");
                $modal.trigger('openModal');
                let descriptionId = $(this).attr('data-id') || null;
                if (descriptionId !== null) {
                    getDescription(descriptionId);
                }
            });
        };

        return init();
    }
);
