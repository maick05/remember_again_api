var index = -1;

$(document).ready(function()
{
	var letras = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'X', 'W','Y','Z'];

	$(document).on('keyup', function (e)
	{
		if(verificaCompleto())
			return;

		var tecla = String.fromCharCode(e.keyCode).toUpperCase();

		if($.inArray(tecla, letras) == -1)
			return;

		var acertou = $('.letter[data-letra="'+tecla+'"]').length;
		var etapa = parseInt($('img').data('etapa'));

		if(acertou == 0 && etapa < 8)
		{
			etapa += 1;
			// console.log('assets/img/forca/forca-'+etapa+'.jpg');
			$('img').prop('src', 'assets/img/forca/forca-'+etapa+'.jpg');
			$('img').data('etapa', etapa);
		}
		else if(etapa == 7)
			revelar();


		$('.letter[data-letra="'+tecla+'"]').html(tecla);
		$('.tecla[data-letra="'+tecla+'"]').html('');
		$('.letter[data-letra="'+tecla+'"]').removeClass('revelar');
		if(verificaCompleto())
			proximo();
	});

	proximo();
});

function revelar()
{
	$('.letter').each(function () {
		$(this).html($(this).data('letra'));
		$(this).removeClass('revelar');
	});
}

function verificaCompleto()
{
	let cont = $('.revelar').length;
	return cont == 0;
}

function proximo()
{
	console.log('prox');
	index++;
	$('.tecla').each(function () {
		$(this).html($(this).data('letra'));
	});

	$('.guess-word').html('');
	$.post('next/'+index, {}, function (dados) {
		dados = JSON.parse(dados);
		var word = JSON.parse(dados.word);
		var html = '';
		for(i in word){
			html += $('#template-letra').tmpl(word[i]).html();
		}

		$('.guess-word').append(html);
		$('.palavra').html(dados.palavra);
	});
}

