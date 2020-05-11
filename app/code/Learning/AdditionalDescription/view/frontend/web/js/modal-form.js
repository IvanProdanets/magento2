define(
    [
        'jquery',
        'Magento_Ui/js/modal/modal'
    ],
    function ($) {
        "use strict";
        let descriptionId = null;
        //creating jquery widget
        $.widget('Learning_AdditionalDescription.modalForm', {
            options: {
                modalForm: '#modal-form',
                modalButton: '.open-modal-form'
            },
            _create: function () {
                this.options.modalOption = this._getModalOptions();
                this._bind();
                this._getDescription();
            },
            _getModalOptions: function () {
                return  {
                    type: 'popup',
                    responsive: true,
                    buttons: []
                    // buttons: [{
                    //     text: $.mage.__('Save'),
                    //     click: function () {
                    //         this._saveDescription();
                    //         this.closeModal();
                    //     }
                    // }]
                };
            },
            _bind: function () {
                const modalOption = this.options.modalOption;
                const modalForm = this.options.modalForm;

                $(document).on('click', this.options.modalButton,  function () {
                    //Initialize modal
                    $(modalForm).modal(modalOption);
                    //open modal
                    $(modalForm).trigger('openModal');
                });
            },

            _getDescription: function (id) {
                console.log('_getDescription');
                // $.ajax({
                //     method: 'GET',
                //     url: url
                // }).done(function (data) {
                //     $('div[data-role=partners-block]').html(data);
                // });
            },

            _saveDescription: function () {
                console.log('_saveDescription');
                // $.ajax({
                //     method: 'GET',
                //     url: url
                // }).done(function (data) {
                //     $('div[data-role=partners-block]').html(data);
                // });
            }

        });

        return $.Learning_AdditionalDescription.modalForm;
    }
);
