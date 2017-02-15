<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>CDF</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap-theme.css">


    <script type="text/javascript" src="js/jquery-2.1.4.js"></script>
    <script type="text/javascript" src="js/main.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script>
</head>

<script>
    var tabuleiro = new Array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23"); // O verdadeiro 'tabuleiro' do jogo. Cada número representa uma carta.
    var tabuleiroBool = new Array("0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0"); // Array para controle de cartas visíveis/invisíveis.
    var tabuleiroBoolAux = new Array(24); // Array auxiliar para função 'trava'.
    var valor = 0;
    var numCliques = 0; // Número de cliques efetuados pelo jogador.
    var acertos = 0; // Quantidade de acertos do jogador.
    var indiceCartaAnterior = -1; // Índice da carta clicada na jogada anterior.
    var cartaAtual = -1; // Índice da carta clicada na jogada atual.
    embaralhaTabuleiro();

    // *** Embaralha as 'cartas' no tabuleiro aleatoriamente. ***
    function embaralhaTabuleiro() {
        r = -1;
        for (i = 0; i < 24; i++) {
            r = Math.round(Math.random() * ( tabuleiro.length - 1 ));
            aux = tabuleiro[r];
            tabuleiro[r] = tabuleiro[i];
            tabuleiro[i] = aux;
        }
    }

    // *** Verifica qual o botão clicado de uma jogada. Se for o segundo, verifica se acertou ou errou. ***
    function verificaJogada(indice) {
        if (tabuleiroBool[indice] == 0) {
            tabuleiroBool[indice] = 1;
            numCliques++;
            carta = parseInt(tabuleiro[parseInt(indice)]);
            visualizarCarta(carta, indice);

            if (numCliques % 2 != 0) { // Primeiro botão da jogada clicado.
                indiceCartaAnterior = indice;

            } else if (( tabuleiro[indice] % 12 ) == ( tabuleiro[indiceCartaAnterior] % 12 )) { // Acertou.
                acertos++;
                valor += 20;
                document.getElementById("ponto").value = valor;

                if (acertos == tabuleiro.length / 2) {
                    document.getElementById("msg").value = "*** Fim de Jogo! *** Você errou " + ( ( numCliques / 2 ) - acertos ) + " vez(es).";
                    alert("Parabéns, você concluiu o jogo com a pontuação de: " + valor);
                }
            } else { // Errou.
                cartaAtual = indice; // Passando o valor para a variável global pode-se usar 'setTimeout'
                document.getElementById("msg").value = "ERROU!";
                valor -= 10;

                // Os procedimentos adotados abaixo permitem ao jogador visualizar a segunda
                // carta clicada sem poder clicar em nenhuma outra enquanto as outras duas ainda
                // estiverem visíveis.
                trava(1);
                setTimeout("trava( 0 );", 300);

                setTimeout("esconderCarta( indiceCartaAnterior );", 300);
                setTimeout("esconderCarta( cartaAtual );", 300);
                setTimeout("document.getElementById( \"msg\" ).value = \"\";", 300);
                document.getElementById("ponto").value = valor;
            }
        }

        return;
    }

    // *** Deixa uma determinada carta visível ao jogador. ***
    function visualizarCarta(carta, indice) {
        endereco = "imagens/carta" + ( carta % 12 ) + ".jpg";
        document.campo[indice].src = endereco;
    }

    // *** Esconde uma determinada carta do jogador. ***
    function esconderCarta(indice) {
        document.campo[indice].src = "imagens/costas.jpg";
        tabuleiroBool[indice] = 0;
    }

    // *** Inicia um novo jogo ***
    function novoJogo() {
        acertos = 0;
        numCliques = 0;
        indiceBotaoClicado = -1;

        for (i = 0; i < tabuleiro.length; i++) { // Vira todas as cartas.
            esconderCarta(i);
        }

        embaralhaTabuleiro();
        document.getElementById("msg").value = "Novo jogo iniciado!";

        return;
    }

    // *** Permite ou não que o jogador possa clicar nas cartas ***
    function trava(flag) {
        if (flag == 1) { // Bloqueia as cartas para 'clicks'.
            for (i = 0; i < tabuleiroBool.length; i++) {
                tabuleiroBoolAux[i] = tabuleiroBool[i];
                tabuleiroBool[i] = 1;
            }
        } else if (flag == 0) { // Libera as cartas para 'clicks'.
            for (i = 0; i < tabuleiroBool.length; i++) {
                tabuleiroBool[i] = tabuleiroBoolAux[i];
            }
        }

        return;
    }
</script>

<body>
<h2 align="center"><b>Memória CDF</b></h2>

<table border="0" align="center">
    <input disabled="disabled" type="text" id="ponto" size="1" value="0"/>

    <tr>
        <td><img class="carta" src="imagens/costas.jpg" name="campo" onclick="verificaJogada( 0 );" /></td>
        <td><img class="carta" src="imagens/costas.jpg" name="campo" onclick="verificaJogada( 1 );" /></td>
        <td><img class="carta" src="imagens/costas.jpg" name="campo" onclick="verificaJogada( 2 );" /></td>
        <td><img class="carta" src="imagens/costas.jpg" name="campo" onclick="verificaJogada( 3 );" /></td>
        <td><img class="carta" src="imagens/costas.jpg" name="campo" onclick="verificaJogada( 4 );" /></td>
        <td><img class="carta" src="imagens/costas.jpg" name="campo" onclick="verificaJogada( 5 );" /></td>
    </tr>
    <tr>
        <td><img class="carta" src="imagens/costas.jpg" name="campo" onclick="verificaJogada( 6 );" /></td>
        <td><img class="carta" src="imagens/costas.jpg" name="campo" onclick="verificaJogada( 7 );" /></td>
        <td><img class="carta" src="imagens/costas.jpg" name="campo" onclick="verificaJogada( 8 );" /></td>
        <td><img class="carta" src="imagens/costas.jpg" name="campo" onclick="verificaJogada( 9 );" /></td>
        <td><img class="carta" src="imagens/costas.jpg" name="campo" onclick="verificaJogada( 10 );" /></td>
        <td><img class="carta" src="imagens/costas.jpg" name="campo" onclick="verificaJogada( 11 );" /></td>
    </tr>
    <tr>
        <td><img class="carta" src="imagens/costas.jpg" name="campo" onclick="verificaJogada( 12 );" /></td>
        <td><img class="carta" src="imagens/costas.jpg" name="campo" onclick="verificaJogada( 13 );" /></td>
        <td><img class="carta" src="imagens/costas.jpg" name="campo" onclick="verificaJogada( 14 );" /></td>
        <td><img class="carta" src="imagens/costas.jpg" name="campo" onclick="verificaJogada( 15 );" /></td>
        <td><img class="carta" src="imagens/costas.jpg" name="campo" onclick="verificaJogada( 16 );" /></td>
        <td><img class="carta" src="imagens/costas.jpg" name="campo" onclick="verificaJogada( 17 );" /></td>
    </tr>
    <tr>
        <td><img class="carta" src="imagens/costas.jpg" name="campo" onclick="verificaJogada( 18 );" /></td>
        <td><img class="carta" src="imagens/costas.jpg" name="campo" onclick="verificaJogada( 19 );" /></td>
        <td><img class="carta" src="imagens/costas.jpg" name="campo" onclick="verificaJogada( 20 );" /></td>
        <td><img class="carta" src="imagens/costas.jpg" name="campo" onclick="verificaJogada( 21 );" /></td>
        <td><img class="carta" src="imagens/costas.jpg" name="campo" onclick="verificaJogada( 22 );" /></td>
        <td><img class="carta" src="imagens/costas.jpg" name="campo" onclick="verificaJogada( 23 );" /></td>
    </tr>
</table>

<center>
    <input type="text" id="msg" size="45" />

    <input type="button" value="Novo Jogo" onclick="novoJogo();" />
    <center>
</body>
</html>