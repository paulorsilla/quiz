$(document).ready(function() {
	var questoes;
	var alternativas;
	var inicio = true;
	var resultados = false;
	var questaoAtual;
	var gabarito;
	var respostas;
	var fim;
	
	iniciar();
	
	$("#cover").click(function() {
		$("#cover").hide();
		$("#page").show();
		if (inicio) {
			inicio = false;
			questaoAtual = -1;
			var grupo = Math.floor(Math.random() * 8 + 1);

			$.ajax({
		        type: 'POST',
		        dataType: "json",
		        data: {grupo:grupo},
		        async: false,
		        url: "/application/questao/buscar",
		        success: function(data) {
		        	questoes = data.questoes;
		        	alternativas = data.alternativas;
		        	gabarito = data.gabarito;
		        }
		    });
		    proximaQuestao();
		} 
		
	});

	$("#page").click(function() {
		if(resultados && fim) {
			iniciar();
		} else if (resultados) {
			fim = true;
		}
	});
	
	$("#alternativaA").click(function() {
		respostas.push("A");
		proximaQuestao();
	});
	$("#alternativaB").click(function() {
		respostas.push("B");
		proximaQuestao();

	});
	$("#alternativaC").click(function() {
		respostas.push("C");
		proximaQuestao();
	}); 

	function proximaQuestao() {
		questaoAtual += 1;
    	if(questaoAtual === 3) {
    		resultados = true;
    		acertos = corrigir();
    		var mensagem;
    		if (acertos === 3) {
    			mensagem = "<h2>Parabéns, você acertou todas as questões. <br /> Procure um atendente da Embrapa para ganhar a sua publicação.</h2>";
    		} else {
    			var erros = 3 - acertos;
    			
    			if (erros == 1) {
    				mensagem = "<h2>Que pena, você errou uma questão. <br />Tente novamente mais tarde.</h2>";
    			} else {
    				mensagem = "<h2>Que pena, você errou "+erros+" questões. <br />Tente novamente mais tarde.</h2>";
    			}
    		}
    		$("#questao").html(mensagem);
    		$("#alternativaA").slideUp(300);
    		$("#alternativaB").slideUp(300);
    		$("#alternativaC").slideUp(300);
    	} else {
	    	$("#questao").html("<h2>"+questoes[questaoAtual]+"</h2>");
	    	$("#questao").fadeIn(500);
			
	    	var altAux = alternativas[questaoAtual].split("&");
	    	$("#alternativaA").html("<h3>A - "+altAux[0]+"</h3>");
	    	$("#alternativaB").html("<h3>B - "+altAux[1]+"</h3>");
	    	$("#alternativaC").html("<h3>C - "+altAux[2]+"</h3>");
	    	
	    	$("#alternativaA").fadeIn(500);
	    	$("#alternativaB").fadeIn(500);
	    	$("#alternativaC").fadeIn(500);
    	}
	}
	
	function iniciar() {
		$("#page").hide();
		resultados = false;
		fim = false;
		$("#cover").show();
		inicio = true;
		respostas = new Array();
		$("#questao").hide();
		$("#alternativaA").hide();
		$("#alternativaB").hide();
		$("#alternativaC").hide();
	}
	
	function corrigir() {
		var corretas = 0;
		for(var i=0;i<3;i++) {
			if (respostas[i] === gabarito[i]) {
				corretas += 1;
			}
		}
		return corretas;
 	}

});