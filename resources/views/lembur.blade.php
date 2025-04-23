<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Lembur</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h2>Cek Status Lembur</h2>
    <form id="lemburForm">
        <label for="tanggal">Masukkan Tanggal:</label>
        <input type="date" id="tanggal" name="tanggal" required>
        <button type="submit">Cek Hari</button>
    </form>

    <h3 id="hasil"></h3>

    <script>
        $(document).ready(function() {
            $("#lemburForm").submit(function(event) {
                event.preventDefault();
                let tanggal = $("#tanggal").val();

                $.ajax({
                    url: "{{ route('cekLembur') }}",
                    type: "POST",
                    data: {
                        tanggal: tanggal,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        $("#hasil").text("Tanggal " + response.tanggal + " (" + response.hari + ") adalah " + response.status);
                    },
                    error: function(xhr) {
                        $("#hasil").text("Terjadi kesalahan: " + xhr.responseJSON.error);
                    }
                });
            });
        });
    </script>
</body>
</html>
