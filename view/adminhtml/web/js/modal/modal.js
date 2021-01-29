define([
    'jquery',
    'Magento_Ui/js/modal/modal-component',
    'mage/url'
], function ($, Modal, url) {
    'use strict';

    return Modal.extend({

        actionDone: function () {
            this.valid = true;
            this.elems().forEach(this.validate, this);

            this.applyData();
            // get url : /name alias link to login backend /frontname/controllername/class
            // ex in local : /admin_d7p8hh/team1productsource/source/saveproduct
            // ex in server  /thanos/team1productsource/source/saveproduct

            var ajaxUrl = url.build('/thanos/team1productsource/source/saveproduct');
            console.log(this.applied);
            $.ajax({
                url: ajaxUrl,
                type: 'POST',
                data: {
                    form_key: window.FORM_KEY,
                    // get Data to 2 param
                    sourcecode: $("input[name='general[source_code]']").val(),
                    productdata: this.applied[Object.keys(this.applied)[0]]
                },
                // get respone in controller
                complete: function (response) {
                    console.log("Product had inserted to Product Grid");
                    console.log(response);
                    location.reload();
                },

                success: function (data, status, xhr) {
                    console.log("Product added to table one!!!!")
                },

                error: function (xhr, status, errorThrown) {
                    console.log('Error happens. Try again.');
                    console.log(errorThrown);
                }
            });

            if (this.valid) {
                this.closeModal();
            }
        }
    });
});