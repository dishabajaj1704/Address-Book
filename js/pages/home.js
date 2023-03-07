$(function () {
    $('.modal').modal();
});

$(function () {
    $('.modal').modal();
    function getUrlQueryParams() {
        const queryParams = window.location.search.substring(1).split("&");
        let vars = [], hash;
        for (let i = 0; i < queryParams.length; i++) {
            hash = queryParams[i].split("=");
            vars[hash[0]] = hash[1];
        }
        return vars;
    }

    const queryParams = getUrlQueryParams();
    const operation = queryParams['op'];
    const status = queryParams['status'];
    if (operation === "add" && status === "success") {
        M.toast({
            html: 'Contact Added successfully',
            classes: 'green darken-1'
        });e
    }
    else if (operation === "edit" && status === "success") {
        M.toast({
            html: 'Contact Updated successfully',
            classes: 'green darken-1'
        });
    } else if (operation === "delete" && status === "success") {
        M.toast({
            html: 'Contact Deleted successfully',
            classes: 'green darken-1'
        });
    }
})