jQuery(function ($) {
    function sortDropdownByName(name) {
        setTimeout(function () {
            var dropdown = $("select[name='" + name + "']");
            if (dropdown.length > 0) {
                var options = dropdown.children("option").get();
                options.sort(function (a, b) {
                    var textA = $(a).text().trim().toLowerCase();
                    var textB = $(b).text().trim().toLowerCase();
                    return textA.localeCompare(textB);
                });
                dropdown.empty().append(options);
                if (options.length > 2) { // fix of bug when parama 1 and parama 2 appears in a list. It removes those two last options
                    options.slice(0, -2).forEach(function (option) {
                        dropdown.append(option);
                    });
                }
            }
        }, 20);
    }

    sortDropdownByName("automobilio-marke");
});
