<?php

// 🚨 URL yang Anda berikan sudah lengkap dengan endpoint, parameter (country=us&category=technology), dan apiKey
$url = "https://newsapi.org/v2/top-headlines?country=us&category=technology&apiKey=5877e01441c44a8d8a1a9a63d7aed720"; 

echo "<h1>REST Client Test News API</h1>";
echo "<h3>Endpoint yang Diakses:</h3>";
echo "<p>" . htmlspecialchars($url) . "</p>";
echo "<hr>";

// 1. Inisialisasi cURL
$ch = curl_init();

// 2. Set Opsi cURL
curl_setopt($ch, CURLOPT_URL, $url); 
// Mengembalikan transfer sebagai string (wajib untuk diproses PHP)
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
// Set User-Agent karena News API memerlukannya
curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-REST-Client-Test/1.0');
// Set timeout 30 detik
curl_setopt($ch, CURLOPT_TIMEOUT, 30); 

// 3. Eksekusi Request dan Tangkap Response
$responseJson = curl_exec($ch);

// 4. Cek Error cURL
if (curl_errno($ch)) {
    $error_msg = curl_error($ch);
    die("<h3>❌ Error cURL!</h3><p>Gagal menjalankan cURL: " . $error_msg . "</p>");
}

// 5. Tutup cURL Session
curl_close($ch);

// 6. Proses Response (JSON ke Array PHP)
$data = json_decode($responseJson, true);

// 7. Tampilkan Hasil
if ($data && $data['status'] === 'ok') {
    echo "<h3>✅ Status API: OK</h3>";
    echo "<p>Total Hasil Ditemukan: **" . number_format($data['totalResults']) . "**</p>";
    
    if (!empty($data['articles'])) {
        echo "<h4>Top 5 Berita (US - Technology):</h4>";
        echo "<ol>";
        // Ambil 5 artikel pertama
        foreach (array_slice($data['articles'], 0, 5) as $article) {
            echo "<li>";
            echo "<h4>" . htmlspecialchars($article['title']) . "</h4>";
            echo "<p>Sumber: " . htmlspecialchars($article['source']['name']) . "</p>";
            echo "<p>Deskripsi: " . htmlspecialchars($article['description'] ?? 'Tidak ada deskripsi.') . "</p>";
            echo "<a href='" . htmlspecialchars($article['url']) . "' target='_blank'>Baca Sumber Asli</a>";
            echo "</li>";
        }
        echo "</ol>";
    } else {
        echo "<p>Tidak ada artikel teknologi dari US yang ditemukan.</p>";
    }

} else {
    // Penanganan Error dari API (misal: API Key tidak valid/quota habis)
    echo "<h3>❌ Error API Response</h3>";
    if (isset($data['code']) && isset($data['message'])) {
        echo "<p>Kode Error: **" . htmlspecialchars($data['code']) . "**</p>";
        echo "<p>Pesan: **" . htmlspecialchars($data['message']) . "**</p>";
    } else {
        echo "<p>Response tidak valid atau format error tidak diketahui.</p>";
        echo "<pre>" . htmlspecialchars($responseJson) . "</pre>";
    }
}
?>