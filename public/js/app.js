// Javascript
console.info('JS geladen.');

$(function() {

    $('#create-order').on('submit', function () {

        var errors = [];
        var email = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

        if ($('#user-name').val() === '') {
            errors.push('Bitte gib einen Benutzernamen ein.');
        }

        if (email.test($('#user-email').val()) === false) {
            errors.push('Bitte geben Sie eine Korrekte Email ein');
        }

        var isValid = errors.length < 1;

        if (!isValid) {
            alert(errors[0]);
        }
        return isValid;
    });
});

$('#prozent').on('change', function() {
    var datediff = (30 + parseInt($('#prozent').val()))*24*3600*1000;
    var date = new Date(Date.now() + datediff);
    $('#time-to-pay').text(" " + date.getDate() +  "." + (date.getMonth()+1) + "." + date.getFullYear());
})


