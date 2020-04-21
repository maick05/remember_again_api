$(document).ready(function(){
    $('.ui.form').form(
    {
        fields: {
            login: {
            identifier: 'login',
            rules: [
                {
                type   : 'empty',
                prompt : 'Informe seu login'
                }
            ]
            },
            password: {
            identifier: 'password',
            rules: [
                {
                type   : 'empty',
                prompt : 'Informe sua senha'
                }
            ]
            },
        },
        onSuccess: function(){action(); return false}
    });

    function action()
    {
        let btn =  $('#btn-login');
        loading(true, btn, $('.ui.form'));
        $.post('login', {login: $('#login').val(), password: $('#password').val()}, function(dados){
            dados = JSON.parse(dados);
            if(dados.key == 'error')
            {
                loading(false, btn, $('.ui.form'));
                showMessage(dados.title, dados.msg);
            }
            else
                window.location.replace("logar");

        });
    }

    function loading(load, btn, div)
    {
        if(load)
        {
            $('.loader').removeClass('disabled');
            div.css('opacity', '0.30');
        }
        else
        {
            $('.loader').addClass('disabled');
            div.css('opacity', '1');
        }
    }

    function showMessage(title, msg)
    {
        $('.warning.message').show();
        $('.header').html(title);
        $('.txtMessage').html(msg);
    }
});