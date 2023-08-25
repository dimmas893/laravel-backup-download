<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Download File</title>
    <link rel="stylesheet" href="{{ asset('iziToast.min.css') }}">
</head>

<body>
    <div id="app">
        <button id="backup">Download File clik</button>
    </div>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
    <script src="{{ asset('iziToast.min.js') }}"></script>
    <script>
        // $(document).ready(function() {
        $(document).on('click', '#backup', function(e) {
            e.preventDefault();
            alertDownloading()
            $.ajax({
                url: '{{ route('backup') }}',
                method: 'get',
                success: function(response) {
                    // console.log(response);
                    downloadFile()
                    hideAlertDownloading()
                    printDownloadCompleted()
                }
            });
        });

        function downloadFile() {
            // alertDownloading();
            const fileUrl = '{{ asset('backup/' . $backup->filename) }}';
            $.ajax({
                url: fileUrl,
                method: 'GET',
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(blob) {
                    const url = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.style.display = 'none';
                    a.href = url;
                    a.download = 'backup.sql'; // Nama file sederhana
                    document.body.appendChild(a);
                    a.click();
                    window.URL.revokeObjectURL(url);
                },
                error: function(error) {
                    console.error('Error downloading file:', error);
                },
            });
        }

        function alertDownloading() {
            iziToast.show({
                theme: 'light',
                icon: 'fa fa-download',
                title: 'Downloading...',
                message: 'Please wait...',
                position: 'topRight',
                timeout: false,
                progressBar: true,
                close: false
            });
        }

        function hideAlertDownloading() {
            const alert = document.querySelector('.iziToast');
            alert.style.display = 'none';
        }

        function printDownloadCompleted() {
            iziToast.success({
                title: 'Download Completed',
                message: 'File has been successfully downloaded.',
                position: 'topRight'
            });
        }
        // });
    </script>
</body>

</html>
