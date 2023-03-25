
$(".delete-element").click(function (evt) {

    id = $(this).data('id');
    console.log(id);

    $("#deleteModalAgreeBtn").attr('href', `delete-contact.php?id=${id}`);

});

