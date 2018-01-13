(function () {
	'use strict';

	var service = 'paginationSrv';

	angular.module('app').factory(service, [paginationSrv]);

	/**
	 * Pagination Service
	 */
	function paginationSrv() {

		var service = {
			paginate: paginate
		}

		return service;

		function paginate(data = [], currentPage = 1, itemsPerPage = 10) {
            var allCandidates = data;
            var totalItems = allCandidates.length;

            var pagedData = allCandidates.slice(
                (currentPage - 1) * itemsPerPage,
                currentPage * itemsPerPage
            );

            return {
                data: pagedData,
                totalItems: totalItems,
                currentPage: currentPage,
                itemsPerPage: itemsPerPage
            };
		}

	} // end service
})();