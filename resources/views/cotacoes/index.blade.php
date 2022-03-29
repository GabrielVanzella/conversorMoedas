@extends('layouts.app')
@section('content')

<form action="/" method="POST">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">

  <div class="row">
    <div class="col-12">
        <label class="col-form-label">Valor(Compra) para conversão R$</label>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <select name="valor_real_BRL" class="form-control" required>
        <option value="1000">1.000.00</option>
        <option value="5000">5.000,00</option>
        <option value="70000">70.000,00</option>
      </select>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <label>Moeda para conversão</label>
        <select name="nome_moeda_destino" class="form-control" required>
        @foreach($getValorMoedas as $moeda)
          <option value="{{$moeda["code"]}}">{{$moeda["name"]}}</option>
        @endforeach
    </select>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
    <label>Forma de Pagamento</label>
    <select name="forma_pagamento" class="form-control" required>
      <option value="boleto">Boleto</option>
      <option value="cartao_credito">Cartão de Crédito</option>
    </select>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <input type="submit" value="Calcular" class="btn btn-success" style="margin-top: 10px;">
    </div>
  </div>
</form>
  @if($exibir_resultado)
  <div>

      <h3>Cotações Resultado Parâmetros de saída:</h3>

      <strong>Valor(Compra) para conversão BRL R$</strong> {{$moeda_origem_blr}} <br>
      <strong>Forma de pagamento</strong> {{$forma_pagamento}} <br>
      <strong>Valor da moeda de destino {{$nome_moeda_destino}}</strong> {{$valor_moeda_destino}}<br>
      <strong>Valor Total R$ </strong> {{$valor_total_reais}}<br><br>

      <strong>1 Regra -></strong> Aplicar taxa de 2% pela conversão para valores abaixo de R$ 3.700,00 e 1% para valores maiores que R$ 3.700,01, essa taxa deve ser aplicada apenas no valor da compra e não sobre o valor já com a taxa de forma de pagamento. <strong>Com base na especificação da regra o resultado é R$ {{$vrl_taxa_conversao_reais}}.</strong><br>
      <strong>Taxa Conversão com base da <strong>Regra 1 </strong>({{$getJurosValorTotalPercentual}}%)</strong><br><br>

      <strong>2 Regra -></strong>
      Taxa de acordo com o Tipo de Pagamento Boleto taxa de 1,37% & Cartão de Crédito taxa de 7,73%. <strong>Com base na especificação da regra foi aplicado a taxa de ({{$getJurosTipoPagamento[$forma_pagamento]}}%) totalizando R$ {{$getValorTipoPagamentoJuros}}</strong><br><br>
      
      <strong>3 Regra -></strong>
      Valor Total é R$ {{$valor_total_reais}} + Taxa Conversão ({{$getJurosValorTotalPercentual}}%) sendo o valor R$ {{$vrl_taxa_conversao_reais}}. <strong>Com base na especificação da regra o resultado é R$ {{$vrl_tot_mult_taxa_conversao}}</strong><br><br>
      
      <strong>4 Regra -></strong>
      Valor Total R$ {{$valor_total_reais}} + Taxa de acordo com o Tipo de Pagamento Boleto/Cartão ({{$getJurosTipoPagamento[$forma_pagamento]}}) sendo R$ {{$getValorTipoPagamentoJuros}}.<strong>Com base na especificação da regra o resultado é R$ {{$valor_total_reais_juros}} </strong> <br><br>
      
      
      Cotação realizada em {{$data_hora_cotacao}}
  </div>
  @endif

@endsection