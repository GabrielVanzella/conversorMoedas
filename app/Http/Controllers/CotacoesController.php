<?php

namespace App\Http\Controllers;

use App\Models\Cotacoes;

class CotacoesController extends Controller
{
    public function index()
    {
        $cotacoes = new Cotacoes();
        $getValorMoedas = $cotacoes->getValorMoedas();

        if($_POST){
            $valor_real_BRL     = $_POST['valor_real_BRL'];

            if($valor_real_BRL<=1000 && $valor_real_BRL>=100000){
                echo "O valor para conversão deve ser maior que R$ 1.000 e menor que R$ 100.000,00";
                exit;
            }

            $nome_moeda_destino = $_POST['nome_moeda_destino'];
            $forma_pagamento    = $_POST['forma_pagamento'];

            $cotacoes = new Cotacoes();
            $exibirValoresConvertido        = $cotacoes->getValorConvertidoMoedaDestino($valor_real_BRL,$nome_moeda_destino,$forma_pagamento);
            $nome_moeda_destino             = $exibirValoresConvertido["nome_moeda_destino"];
            $valor_real_BRL                 = ($exibirValoresConvertido["valor_real_BRL"]);

            $valor_moeda_destino            = $exibirValoresConvertido["valor_moeda_destino"];
            $valor_total_multiplicado       = $exibirValoresConvertido["valor_total_multiplicado"];
            $vrl_taxa_conversao_reais       = $exibirValoresConvertido["vrl_taxa_conversao_reais"];

            $vrl_tot_mult_taxa_conversao    = $exibirValoresConvertido["vrl_tot_mult_taxa_conversao"];
            $valor_total_multiplicado_juros = $exibirValoresConvertido["valor_total_multiplicado_juros"];
            $getJurosTipoPagamento          = $cotacoes->getJurosTipoPagamento();
            $getValorTipoPagamentoJuros     = $cotacoes->getValorTipoPagamentoJuros($valor_total_multiplicado,$forma_pagamento);
            $data_hora_cotacao              = date('d/m/Y H:i:s', time());
            $getJurosValorTotalPercentual   = $cotacoes->getJurosValorTotalPercentual($valor_total_multiplicado);

            return view('cotacoes.index', [
                "exibir_resultado"              =>  true,
                "moeda_origem_blr"              =>  number_format($valor_real_BRL,2,',','.'),
                "nome_moeda_destino"            =>  $nome_moeda_destino,
                "valor_moeda_destino"           =>  $valor_moeda_destino,
                "forma_pagamento"               =>  $forma_pagamento,
                "getValorTipoPagamentoJuros"    =>  number_format($getValorTipoPagamentoJuros,2,',','.'),
                "getJurosTipoPagamento"         =>  $getJurosTipoPagamento,
                "vrl_taxa_conversao_reais"      =>  number_format($vrl_taxa_conversao_reais,2,',','.'),
                "getJurosValorTotalPercentual"  =>  $getJurosValorTotalPercentual,
                "valor_total_reais"             =>  number_format($valor_total_multiplicado,2,',','.'),
                "vrl_tot_mult_taxa_conversao"   =>  number_format($vrl_tot_mult_taxa_conversao,2,',','.'),
                "valor_total_reais_juros"       =>  number_format($valor_total_multiplicado_juros,2,',','.'),
                "data_hora_cotacao"             =>  $data_hora_cotacao,
                "getValorMoedas"                =>  $getValorMoedas
            ]);

        }
        return view('cotacoes.index', ["getValorMoedas"=>$getValorMoedas,"exibir_resultado" => false]);
    }
}
