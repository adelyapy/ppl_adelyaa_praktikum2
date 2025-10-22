<?php
// =======================================================
// Persiapan (Mocking)
// = ASUMSIKAN file config.php berisi fungsi http_request_get()
// = Kami akan MOCK fungsi ini untuk tujuan pengujian White Box
// =======================================================

// Pastikan fungsi ini belum ada (misalnya di config.php)
if (!function_exists('http_request_get')) {
    function http_request_get($url) {
        // Respons yang disimulasikan dari NewsAPI ketika API Key salah
        // JSON ini akan memicu alur kegagalan (status != 'ok')
        $mock_api_response_error = '{"status":"error","code":"apiKeyInvalid","message":"Your API key is invalid or not specified."}';
        return $mock_api_response_error;
    }
}

// =======================================================
// Pengujian WBT_001: Memastikan Jalur 'else' Dipicu
// =======================================================

echo "<h2>White Box Test: WBT_001 (Error Branch Coverage)</h2>";

// Inisialisasi variabel seperti di aplikasi utama
$api_key="INVALID_KEY"; 
$url="https://newsapi.org/v2/top-headlines?country=us&category=technology&apiKey=".$api_key;
$data=http_request_get($url);
$hasil=json_decode($data,true);

// Tangkap output (stdout) dari blok 'else'
ob_start();

// Logic yang diuji dari aplikasi utama
if (is_array($hasil) && isset($hasil['status']) && $hasil['status'] == 'ok' && isset($hasil['articles'])) {
    echo "FAIL: Test Gagal, Blok 'if' (Success) terpanggil.";
} else {
    // Alur ini yang DIHARAPKAN terpicu
    if (isset($hasil['status']) && $hasil['status'] == 'error') {
        echo "PASS: Blok 'else' terpanggil. Error API berhasil diidentifikasi.";
    } else {
        echo "FAIL: Blok 'else' terpanggil, namun format error tidak sesuai.";
    }
}

$test_output = ob_get_clean(); // Ambil output
$status = strpos($test_output, 'PASS') !== false ? 'PASS' : 'FAIL';

// =======================================================
// Hasil Pengujian
// =======================================================
echo "<hr>";
echo "<h3>Hasil Pengujian WBT_001</h3>";
echo "<strong>Hasil Aktual:</strong> " . $test_output . "<br>";
echo "<strong>Status:</strong> <span style='color: " . ($status == 'PASS' ? 'green' : 'red') . "; font-weight: bold;'>" . $status . "</span>";
echo "<hr>";

?>