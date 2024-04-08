<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link href="calc.css" rel="stylesheet" />
    <title>Calculadora - KWh</title>
</head>

<body>
    <div class="container h-75 mt-5 mb-2">
        <div class="row bg-secondary">
            <span class="mt-2 col-md-10">CALCULADORA (KWh)</span>
            <span class="alert alert-warning div-alert" id="idAlert" hidden role="alert"></span>
            <div class="configdiv">
                <form id="form_filtro" class="mt-5 center-form">
                    <div class="col-md-3">
                        <label for="qtdHoras">Quantidade horas.*</label>
                        <input class="form-control mb-3" name="qtdHoras" id="idQtdHoras" onchange="enviarHoras(this)" type="number">
                    </div>
                    <div class="col-md-3">
                        <label for="qtdDias">Quantidade dias.*</label>
                        <input class="form-control mb-3" name="qtdDias" id="idQtdDias" onchange="enviarDias(this)" type="number">
                    </div>
                    <div class="col-md-3">
                        <label for="potencia">Potência.*</label>
                        <input class="form-control" name="potencia" id="idQtdPotencia" onchange="enviarPotenc(this)" type="number"><br><br>
                    </div>
                    <div class="col-md-3">
                        <label for="result">Resultado</label>
                        <input class="form-control" name="result" type="text" disabled id="idResult" type>
                        <button type="button" name="" class="mb-3 mt-3 btn btn-primary" onclick="limparCalc()">Limpar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function enviarHoras() {
            localStorage.setItem('vQtdHoras', $("#idQtdHoras").val());
            enviarCalc();
        }

        function enviarDias() {
            localStorage.setItem('vQtdDias', $("#idQtdDias").val());
            enviarCalc();
        }

        function enviarPotenc() {
            localStorage.setItem('vQtdPoten', $("#idQtdPotencia").val());
            enviarCalc();
        }

        function limparCalc() {
            localStorage.removeItem('vQtdHoras');
            localStorage.removeItem('vQtdDias');
            localStorage.removeItem('vQtdPoten');

            $("#idQtdHoras").val("");
            $("#idQtdDias").val("");
            $("#idQtdPotencia").val("");
            $("#idResult").val("");
        }

        function enviarCalc() {
            let v_hr = localStorage.getItem('vQtdHoras');
            let v_dias = localStorage.getItem('vQtdDias');
            let v_pot = localStorage.getItem('vQtdPoten');

            if (v_hr && v_dias && v_pot) {
                let p = document.getElementById('idAlert');
                p.setAttribute("hidden", false);

                $.ajax({
                    type: "POST",
                    url: 'calculadora-kWh.php',
                    data: {
                        "v_acao": "LIST_CALC",
                        "v_horas": v_hr,
                        "v_dias": v_dias,
                        "v_potencia": v_pot
                    },
                    success: function(data) {
                        $("#idResult").val(data.valorTotal);
                    }
                });

            } else {
                let p = document.getElementById('idAlert');
                p.removeAttribute("hidden");
                $(".div-alert").text("Atenção! Preencher todos os campos.");
            }
        }
    </script>
</body>

</html>

<!--  
Potencia: 50
Dias: 20
Qtd horas:10
tarifa val KWh: 1,10
ttl kw/mes: 50 * 20 * 10 = 10.000 /1000 = 10 * 1,10 = 11
-->