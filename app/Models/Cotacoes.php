<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cotacoes extends Model
{
    use HasFactory;

    public function getValorMoedas(){
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://economia.awesomeapi.com.br/json/all",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_CUSTOMREQUEST => "GET"
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        $retorno = json_decode($response,true);

        return $retorno;
      }

      public function getValorConvertidoMoedaDestino($valor_real_BRL,$nome_moeda_destino,$forma_pagamento){
          
        $getValorMoedas                 = $this->getValorMoedas();
        $valor_unitario_moeda_destino   = ($getValorMoedas["$nome_moeda_destino"]["bid"]);
        $valor_total_multiplicado       = ($valor_real_BRL * $valor_unitario_moeda_destino);
        $vrl_tot_mult_taxa_conversao    = $this->getValorTotalTaxaConversao($valor_total_multiplicado);
        $vrl_taxa_conversao_reais       = $this->getTaxaConversaoReais($valor_total_multiplicado);
        $valor_total_multiplicado_juros = $this->getValorTotalPercentualJuros($valor_total_multiplicado,$forma_pagamento);

        return [
          "valor_real_BRL"                  => $valor_real_BRL,
          "valor_moeda_destino"             => $valor_unitario_moeda_destino,
          "valor_total_multiplicado"        => $valor_total_multiplicado,
          "vrl_taxa_conversao_reais"        => $vrl_taxa_conversao_reais,
          "vrl_tot_mult_taxa_conversao"     => $vrl_tot_mult_taxa_conversao,
          "nome_moeda_destino"              => $nome_moeda_destino,
          "valor_total_multiplicado_juros"  => $valor_total_multiplicado_juros
        ];
      }

      public function getJurosValorTotalPercentual($valor_total_multiplicado){
        $getJurosValorTotal = $this->getJurosValorTotal();
        return ($valor_total_multiplicado<=3700)?$getJurosValorTotal["opt1"]:$getJurosValorTotal["opt2"];
      }
      private function getValorTotalTaxaConversao($valor_total_multiplicado){
        return $valor_total_multiplicado + ($valor_total_multiplicado / 100 * $this->getJurosValorTotalPercentual($valor_total_multiplicado));
      }
      private function getTaxaConversaoReais($valor_total_multiplicado){
        return ($valor_total_multiplicado / 100 * $this->getJurosValorTotalPercentual($valor_total_multiplicado));
      }

      public function getValorTipoPagamentoJuros($valor_total_multiplicado,$forma_pagamento){
        $juros = $this->getJurosTipoPagamento();
        return ($valor_total_multiplicado / 100 * $juros[$forma_pagamento]);
      }

      private function getValorTotalPercentualJuros($valor_total_multiplicado,$forma_pagamento){
        $juros = $this->getJurosTipoPagamento();
        return $valor_total_multiplicado + ($valor_total_multiplicado / 100 * $juros[$forma_pagamento]);
      }

      public function getJurosTipoPagamento(){
        return [
          "boleto"=>1.37,
          "cartao_credito"=>7.73
        ];
      }

      public function getJurosValorTotal(){
        return [
          "opt1"=>2.00,
          "opt2"=>1.00
        ];
      }
}