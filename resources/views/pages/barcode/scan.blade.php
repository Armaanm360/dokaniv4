<script src="https://cdn.jsdelivr.net/npm/@ericblade/quagga2/dist/quagga.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@ericblade/quagga2@1.2.6/dist/quagga.js"></script>
<div id="yourElement"></div>
<script>
Quagga.decodeSingle({
    decoder: {
        readers: ["code_128_reader"] // List of active readers
    },
    locate: true, // try to locate the barcode in the image
    src: 'http://localhost/dokani_v4/get-product-barcode/1' // or 'data:image/jpg;base64,' + data
}, function(result){
    if(result.codeResult) {
        console.log("result", result.codeResult.code);
    } else {
        console.log("not detected");
    }
});
  </script>