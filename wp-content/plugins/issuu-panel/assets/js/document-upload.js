(function($){
	function refreshNumbers()
	{
		var dia = $('#dia').val();
		var mes = $('#mes').val();
		var ano = $('#ano').val();

		var maxDia = 31;

		if (mes != '')
		{
			mes = parseInt(mes);

			if (mes < 0)
			{
				mes = 1;
				$('#mes').val(mes);
			}
			else if (mes > 12)
			{
				mes = 12;
				$('#mes').val(mes);
			}

			if (mes != 2)
			{
				if (mes <= 7)
				{
					if (mes % 2 == 0)
					{
						maxDia = 30;
					}
					else
					{
						maxDia = 31;
					}
				}
				else
				{
					if (mes % 2 == 0)
					{
						maxDia = 31;
					}
					else
					{
						maxDia = 30;
					}
				}
			}
			else
			{
				if (ano != '')
				{
					if (ano.length == 4)
					{
						ano = parseInt(ano);

						if (ano % 4 == 0 && ano % 100 != 0 || (ano % 400 == 0))
						{
							maxDia = 29;
						}
						else
						{
							maxDia = 28;
						}
					}
				}
				else
				{
					if (ano.length == 4)
					{
						maxDia = 28;
					}
				}
			}
		}
		else
		{
			maxDia = 31;
		}

		if (dia != '')
		{
			dia = parseInt(dia);

			if (dia < 0)
			{
				$('#dia').val(1);
			}
			else if(dia > maxDia)
			{
				$('#dia').val(maxDia);
			}
		}
	}
	function wholeNumber(e)
	{
		refreshNumbers();

		if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))
		{
			return false;
		}
	}
	$('.small-text').keypress(wholeNumber);
	$('#document-upload').submit(function(e){
		if ($('#file').val() == "")
		{
			alert("Insira um documento");
			return false;
		}
	});
})(jQuery);