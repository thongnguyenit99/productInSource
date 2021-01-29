define(function () {
    'use strict';

    var mixin = {
        initialize: function () {
            var obj = this._super();
            // Remove the Select All options from the dropdown
            if (this.modules && this.modules.source && this.modules.source.indexOf('source_product_listing') !== -1) {
                this.actions.splice(0, 3);
            }
            return obj;
        },
        // Remove the "Select All On This Page" functionality
        selectPage: function () {
            if (this.modules && this.modules.source && this.modules.source.indexOf('source_product_listing') !== -1) {
                return this;
            } else {
                this._super();
            }
            return this;
        }
    };

    return function (target) {
        return target.extend(mixin);
    };
});
