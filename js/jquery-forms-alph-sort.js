jQuery(function ($) {
    function sortDropdownByName(name) {
        setTimeout(function () {
            const dropdown = $(`select[name='${name}']`);
            if (dropdown.length > 0) {
                const options = dropdown.children("option").get();
                options.sort(function (a, b) {
                    const textA = $(a).text().trim().toLowerCase();
                    const textB = $(b).text().trim().toLowerCase();
                    return textA.localeCompare(textB);
                });
                dropdown.empty().append(options);
                if (options.length > 2) { // fix of bug when parama 1 and parama 2 appears in a list. It removes those two last options
                    options.slice(0, -2).forEach(option => dropdown.append(option));
                }
            }
        }, 20);
    }

    sortDropdownByName("automobilio-marke");
});
