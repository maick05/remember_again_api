$(document).ready(function()
{
	String.prototype.replaceAll = function(searchStr, replaceStr)
	{
		var str = this;
		// no match exists in string?
		if(str.indexOf(searchStr) === -1)
			return str;
		// replace and remove first match, and do another recursirve search/replace
		return (str.replace(searchStr, replaceStr)).replaceAll(searchStr, replaceStr);
	}

	$('.close').on('click', function() {
		console.log('fechar');
		$(this)
			.closest('.mensagem')
			.transition('fade')
		;
	});

});

function setaValor(campoalvo, valor, modo='sub')
{
	if(campoalvo.prop('type') == 'checkbox')
		campoalvo.prop('checked', valor);
	else if(campoalvo.hasClass('select-input'))
		campoalvo.dropdown('set selected', valor);
	else {
		console.log(modo);
		if(modo == 'sub')
			campoalvo.val(valor);
		else
			campoalvo.val(campoalvo.val()+valor);
	}
}

function loadingSelect(select, load=true)
{
	if(load)
	{
		select.css('text-align', 'center');
		select.find('.text').html('<i class="notched circle loading icon"></i>');
	}
	else
	{
		select.css('text-align', '');
		select.find('.text').html('Nenhum(a)');
	}
}

function carregarSelect(campotabela, registros, callback=function (){})
{
	$('#'+campotabela).find('.item').remove();
	if(!registros) {
		$('#' + campotabela).find('.menu').append('<div class="item nenhum" style="color:red" data-value="">Nenhum(a)</div>');
		loadingSelect($('#'+campotabela), false);
		return;
	}
	$('#'+campotabela).find('.menu').append(registros);
	loadingSelect($('#'+campotabela), false);
	callback();
}




