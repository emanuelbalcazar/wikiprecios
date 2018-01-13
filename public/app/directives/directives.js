(function () {
    'use strict';

    var app = angular.module('app');

    app.directive('onEnter', function () {
        return function (scope, element, attrs) {
            element.bind("keydown keypress", function (event) {
                if (event.which === 13) {
                    $(attrs.onEnter).focus();
                    event.preventDefault();
                }
            });
        };
    });

})();