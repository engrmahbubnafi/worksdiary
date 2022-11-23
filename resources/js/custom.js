String.prototype.replaceAll = function (mapObj) {
    var re = new RegExp(Object.keys(mapObj).join("|"), "gi");
    return this.replace(re, function (matched) {
        return mapObj[matched];
    });
}

window.tooltipViewerFn = function () {
    let tooltip = document.querySelectorAll(`[data-tooltip]`);

    if (tooltip.length) {
        tooltip.forEach(function (item, index) {
            let tis = $(item);
            let parentObj = tis.parent();
            parentObj.attr("title", tis.data('tooltip'))
            parentObj.tooltip();
        });
    }
}

var debounce_fun = _.debounce(function (e) {
    window.LaravelDataTables["dataTableBuilder"].search(e.target.value).draw();
}, 800);

// For datatable search for builder instance
window.handleSearchDatatable = function () {
    const filterSearch = document.querySelector('[data-kt-table-filter="search"]');
    filterSearch.addEventListener('keyup', function (e) {
        debounce_fun(e)
    });
}
