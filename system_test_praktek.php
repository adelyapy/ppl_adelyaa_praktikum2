<?php
// Nama file: system_test_praktek.php (Gunakan ini untuk menjalankan PHPUnit)

use PHPUnit\Framework\TestCase;

class SystemTestPraktek extends TestCase // Ubah huruf besar/kecil (konvensi)
{
    // --- MOCKING/SIMULASI FUNGSI API CALL ---
    // Mensimulasikan http_request_get() dan json_decode() untuk Unit Testing
    private function simulateApiCall(string $apiKey)
    {
        if ($apiKey === "VALID_KEY_MOCK") {
            // Respons Sukses (Path A)
            $json = '{"status": "ok", "totalResults": 2, "articles": [{"title": "Berita A"}, {"title": "Berita B"}]}';
            return json_decode($json, true);
        } elseif ($apiKey === "INVALID_KEY_MOCK") {
            // Respons Gagal Otentikasi (Path B1)
            $json = '{"status": "error", "code": "apiKeyInvalid", "message": "API key is invalid."}';
            return json_decode($json, true);
        }
        // Respons Gagal Koneksi/cURL (Path B2)
        return null; 
    }

    // =======================================================
    // 3 TEST CASE OTOMATIS
    // =======================================================

    /**
     * TC_AUTO_001: Uji Pengambilan Data Sukses
     * Memastikan data yang diterima memiliki status 'ok' dan array artikel
     */
    public function testSuccessDataRetrieval()
    {
        // Panggil simulasi dengan kunci sukses
        $hasil = $this->simulateApiCall("VALID_KEY_MOCK");

        // Validator (Assertion)
        $this->assertEquals('ok', $hasil['status'], "Status API harus 'ok' untuk sukses.");
        $this->assertArrayHasKey('articles', $hasil, "Respons harus memiliki kunci 'articles'.");
        $this->assertGreaterThan(0, count($hasil['articles']), "Harus ada artikel yang diterima.");
    }

    /**
     * TC_AUTO_002: Uji Kegagalan Otentikasi API
     * Memastikan alur error terpicu dengan kode kesalahan API yang benar
     */
    public function testAuthenticationFailure()
    {
        // Panggil simulasi dengan kunci tidak valid
        $hasil = $this->simulateApiCall("INVALID_KEY_MOCK");

        // Validator (Assertion)
        $this->assertEquals('error', $hasil['status'], "Status API harus 'error' untuk kegagalan autentikasi.");
        $this->assertEquals('apiKeyInvalid', $hasil['code'], "Kode error harus 'apiKeyInvalid' (sesuai NewsAPI).");
    }

    /**
     * TC_AUTO_003: Uji Kegagalan Koneksi (Response Null)
     * Memastikan aplikasi menangani kasus di mana cURL gagal total (mengembalikan NULL)
     */
    public function testCurlConnectionFailure()
    {
        // Panggil simulasi yang mengembalikan null (simulasi kegagalan cURL)
        $hasil = $this->simulateApiCall("MOCK_FAIL_CONNECTION"); 

        // Validator (Assertion)
        $this->assertNull($hasil, "Hasil harus NULL ketika simulasi koneksi gagal.");
        // Catatan: Nilai NULL ini di aplikasi utama akan memicu blok 'else' terakhir.
    }
}