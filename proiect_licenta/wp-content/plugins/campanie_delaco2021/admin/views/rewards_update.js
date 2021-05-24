//update rewards form

(function ($) {

    $(document).on("submit", "#edit-reward-form", function (e) {
        e.preventDefault();
        console.log("clicked");

        var formData = new FormData(document.getElementById('edit-reward-form'));

        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log("success");
                console.log(response);
                if (response === "success") {
                    alert("Modificarile au fost realizate cu succes!");
                    location.reload();
                } else {
                    alert("Submit failed! \nError code: " + response);
                }
            },
            error: function (response) {
                console.log("error");
                console.log(response);
                alert("Submit failed! \n Error code: " + response);

            }
        });
    });

    //delete reward from admin-table and database

    $("#delete-reward").on("click", function (e) {
        e.preventDefault();
        var id_reward = this.getAttribute("data-reward-id");
        console.log(id_reward);
        if (window.confirm("Esti sigur ca vrei sa stergi acest premiu?")) {


            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    'action': 'delete_reward_form_process',
                    'ID': id_reward,
                },

                success: function (response) {
                    console.log("success");
                    console.log(response);
                    if (response === "success") {
                        alert("Premiul a fost sters!")
                        location.reload();
                    } else {
                        alert("Submit failed! \nError code: " + response);
                    }

                },
                error: function (response) {
                    console.log("error");
                    console.log(response);
                    alert("Submit failed! \n Error code: " + response);
                }
            });
        }
    })

})(jQuery)

//add rewards form

$(document).on("submit", "#add-rewards-form", function (e) {
    e.preventDefault();

    var formData = new FormData(this);

    $.ajax({
        url: ajaxurl,
        type: 'POST',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (response) {
            console.log("success");
            console.log(response);
            if (response === "success") {
                location.reload();
            } else {
                alert("Submit failed! \nError code: " + response);
            }

        },
        error: function (response) {
            console.log("error");
            console.log(response);
            alert("Submit failed! \n Error code: " + response);
        }
    });
});


//add extraction

$('#add-extraction-form').on("click", function (e) {
    e.preventDefault();

    if (window.confirm("Doriti sa extrageti un castigator?")) {
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {'action': 
            'add_extraction_form_process'},
            success: function (response) {
                console.log("success");
                console.log(response);
                if (response === "success") {
                    location.reload();
                } else {
                    alert("Submit failed! \nError code: " + response);
                }

            },
            error: function (response) {
                console.log("error");
                console.log(response);
                alert("Submit failed! \n Error code: " + response);
            }
        });
    }
});