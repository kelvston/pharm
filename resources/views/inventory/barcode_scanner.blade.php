<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barcode Scanner</title>
</head>
<body>
<div id="scanner"></div>
<h3>Scanned Code: <span id="result"></span></h3>

<script src="https://cdn.jsdelivr.net/npm/quagga/dist/quagga.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const result = document.getElementById("result");

        Quagga.init({
            inputStream: {
                name: "Live",
                type: "LiveStream",
                target: document.querySelector("#scanner"),
            },
            decoder: {
                readers: ["code_128_reader"], // Adjust based on barcode type
            },
        }, function (err) {
            if (err) {
                console.error(err);
                return;
            }
            Quagga.start();
        });

        Quagga.onDetected((data) => {
            result.innerText = data.codeResult.code;
            // Send barcode to Laravel backend
            fetch('/api/scan', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ barcode: data.codeResult.code }),
            }).then(response => response.json())
                .then(data => console.log(data));
        });
    });
</script>
</body>
</html>
