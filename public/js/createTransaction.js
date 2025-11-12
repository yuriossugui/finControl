document.addEventListener('DOMContentLoaded', function() {
    
    function formatarMoeda(input) {
        let valor = input.value;

        valor = valor.replace(/\D/g, "");

        valor = (valor / 100).toFixed(2) + "";

        valor = valor.replace(".", ",");
        
        valor = valor.replace(/\B(?=(\d{3})+(?!\d))/g, ".");

        input.value = "R$ " + valor;
    }

    document.getElementById('value').addEventListener('input', function() {
        formatarMoeda(this);
    });

});