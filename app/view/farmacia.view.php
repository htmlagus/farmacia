<?php

class FarmaciaView {

   public function mostrarInicio($compras) {
        
        $count = count($compras);

       require 'templates/farmacia_listado.phtml';

    }

    public function visualizarMedicamento($compra) {
      
        require 'templates/farmacia_visualizacion.phtml';

    }

}