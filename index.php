<!DOCTYPE html>
<html>

<head>
    <title>QR Code Scanner</title>
    <!-- Include the Instascan library -->
    <script src="path/to/instascan.min.js"></script>
</head>

<body>
    <h1>QR Code Scanner</h1>
    <input type="file" id="fileInput">
    <div id="scanner-container"></div>
    <div id="result-container"></div>

    <script>
        // Initialize the scanner
        let scanner = new Instascan.Scanner({
            video: document.getElementById('scanner-container')
        });

        // Listen for scan events
        scanner.addListener('scan', function(content) {
            // Display the scanned data on the index page
            document.getElementById('result-container').innerText = content;
        });

        // Start scanning
        Instascan.Camera.getCameras().then(cameras => {
            if (cameras.length > 0) {
                scanner.start(cameras[0]);
            } else {
                console.error('No cameras found.');
            }
        });

        // Handle file input change event
        document.getElementById('fileInput').addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                // Create a FormData object to send the image to the server
                const formData = new FormData();
                formData.append('image', file);

                // Send the image to the server for processing
                fetch('scan.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.text())
                    .then(data => {
                        // Display the scanned data from the image on the index page
                        document.getElementById('result-container').innerText = data;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }
        });
    </script>
</body>

</html>
