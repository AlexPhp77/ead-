setInterval(updateArea, 1000);

function updateArea(){
	var alturaTela = $(document.body).height();
	var posicao = $('.curso_left').offset().top;
	var altura = alturaTela - posicao;
	$('.curso_left, .curso_right').css('height', altura+'px');

	var ratio = 1920/1080;
	var video_largura = $('#video').width();
	var video_altura = video_largura / ratio; 

	$('#video').css('height', video_altura+'px');
}

function marcarAssistido(obj){
	var id = $(obj).attr('data-id');

	$(obj).remove(); // remove botão após ação

	$.ajax({
		url:base+'ajax/marcar_assistido/'+id,
		type:'GET',		
	});
}
