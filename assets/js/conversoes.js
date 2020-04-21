function converter(funcao, valor, med) {
	switch (funcao) {
		case 'KelvinCelsius':
			return KelvinCelsius(valor, med);
			break;
	}
}

function KelvinCelsius(valor, med) {
	if(med == 'K')
		return valor - 273;
	else
		return valor + 273;
}
