/* ################################ FORMULAR FORM ############################*/

(function($) {

    $(document).ready(function() {

        var inputNume = $('input[name= "Nume"]');
        var inputPrenume = $('input[name= "Prenume"]');
        var inputTel = $('input[name= "Telefon"]');
        var inputEmail = $('input[name= "Email"]');
        var inputOras = $('input[name= "Oras"]');
        var inputAdresa = $('input[name= "Adresa"]');
        var inputCod = $('input[name= "Cod"]');

        $("#contact-form").submit(function(e) {

            e.preventDefault();
            $('#contact-form input').css({
                "border": "1px solid white"
            });
            var formData = new FormData(this);
            var ajaxUrl = params.ajaxurl;

            var errors = verify_inputs();
            if (errors === undefined || errors.length === 0) {

                $.ajax({
                    url: ajaxUrl,
                    type: 'POST',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log("success");
                        console.log(response);
                        if(response=="success")
                        {
                            $("#contact-form").empty();
                            $("h1").before("<b>Formular trimis cu succes!</b>");
                        }
                        else{
                            alert("Submit failed! \n Error code: " + response);
                        }
                    },
                    error: function(response) {
                        console.log("error");
                        console.log(response);
                        alert("Submit failed! \n Error code: " + response);
                    }
                })
            } else {
                show_errors(errors);
            }
        });
        function verify_inputs() {
            var errors = [];
            var nameCond = new RegExp("[A-Za-z]+");
            var telCond = new RegExp("^[0-9]+$");

            //invalid name
            if (inputNume.val().length == 0) {
                errors.push({
                    "field": "Nume",
                    "error": "Va rugam introduceti un nume complet."
                });
            } else if (nameCond.test(inputNume.val()) == false) {
                errors.push({
                    "field": "Nume",
                    "error": "Nu utilizati caractere speciale!"
                })
            }
            //invalid prenume
            if (inputPrenume.val().length == 0) {
                errors.push({
                    "field": "Prenume",
                    "error": "Va rugam introduceti prenumele complet."
                });
            } else if (nameCond.test(inputPrenume.val()) == false) {
                errors.push({
                    "field": "Prenume",
                    "error": "Nu utilizati caractere speciale!"
                })
            }
            //invalid tel
            if (inputTel.val().length == 0) {
                errors.push({
                    "field": "Telefon",
                    "error": "Va rugam introduceti un numar de telefon complet."
                });
            } else if (telCond.test(inputTel.val()) == false) {
                errors.push({
                    "field": "Telefon",
                    "error": "Va rugam introduceti un numar de telefon corect."
                })
            }
            //invalid email
            if (inputEmail.val().length == 0) {
                errors.push({
                    "field": "Email",
                    "error": "Va rugam introduceti o adresa de email corecta"
                });
            }
            //invalid oras
            if (inputOras.val().length == 0) {
                errors.push({
                    "field": "Oras",
                    "error": "Va rugam introduceti un oras"
                });
            }
            //invalid mesaj
            if (inputAdresa.val().length == 0) {
                errors.push({
                    "field": "Adresa",
                    "error": "Va rugam introduceti o adresa"
                });
                alert("Va rugam introduceti adresa");
            }
            //invalid cod
            if (inputCod.val().length == 0) {
                errors.push({
                    "field": "Cod",
                    "error": "Va rugam introduceti un cod"
                });
                alert("Va rugam introduceti un cod valabil");
            }
            return errors;
        }
        function show_errors(errors) {
            $(".error").remove();
            errors.forEach(function(value, index) {
                switch (value.field) {
                    default: $('#contact-form input[name*="' + value.field + '"]').before("<p class='error'>" + value.error + "</p>");
                    $('#contact-form input[name*="' + value.field + '"]').css({
                        "border": "1px solid red"
                    });
                    break;
                }
            })
            $(".error").fadeOut(5000);
        }
    });

})

/* ########################## WINNING form shortcode + pick reward ############################*/

$(document).on("submit", "#winning-code-form", function(e) {
    e.preventDefault()

    var winningCode = $("#input-win-code").val();
    var ajaxurl = ajax_params.ajax_url;

    $.ajax({
        url: ajaxurl,
        type: 'GET',
        data: {
            'action': 'winning_code_process',
            'win-code': winningCode,
        },
        success: function(response) {
            console.log("success");
            console.log(response);
            if (response == "success") {
                alert("Congratulations! \nYou will be redirected to a new page where you can choose your prize!");
                var encoded = $.md5(winningCode);
                window.location.href = "http://localhost/codes_campaign/prize-page?token=" + encoded;
            } else {
                alert("Submit failed! \nError code: " + response);
            }
        },
        error: function(response) {
            console.log("error");
            console.log(response);
            alert("Submit failed! \n Error code: " + response);
        }
    });
});


//Used for 'winning-form.php' page
$(document).on("submit", "#get_reward", function(e) {
    e.preventDefault()

    var prizeChoose = $('input[name="prize"]:checked').val();;
    var ajaxurl = ajax_params.ajax_url;

    //getting the encoded token
    var url = window.location;
    var currentToken = new URLSearchParams(url.search).get('token');

    if (confirm("Are you sure about the prize you have chosen? \nIt cannot be changed or modified!")) {
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                'action': 'choose_prize_process',
                'prize-choose': prizeChoose,
                'current-token': currentToken
            },
            success: function(response) {
                console.log("success");
                console.log(response);
                if (response == "success") {
                    $('.get_reward_form').empty();
                    $('#get_reward_form').html("<h1>Congratulations, you have chosen your prize!");
                    window.setTimeout(function() {
                        window.location.href = 'http://localhost/codes_campaign/';
                    }, 3000);
                } else {
                    alert("Submit failed! \nError code: " + response);
                    window.location.href = "http://localhost/codes_campaign/did-you-win/";
                }
            },
            error: function(response) {
                console.log("error");
                console.log(response);
                alert("Submit failed! \n Error code: " + response);
            }
        });
    }
})(jQuery);
