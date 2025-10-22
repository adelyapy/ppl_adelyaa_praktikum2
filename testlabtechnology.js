// Test 1: Memeriksa Kode Status HTTP
pm.test("Status code is 200", function () {
    pm.response.to.have.status(200);
});

// Test 2: Memeriksa Properti Wajib pada Setiap Artikel
pm.test("Each article has required fields (title, description, author)", function () {
    // Memastikan respons adalah JSON dan menyimpannya
    const jsonData = pm.response.json();

    // Memastikan array 'articles' ada dan merupakan array
    pm.expect(jsonData).to.have.property('articles');
    pm.expect(jsonData.articles).to.be.an('array');
    
    // Melakukan iterasi pada setiap artikel
    jsonData.articles.forEach(article => {
        
        // 1. Memeriksa Judul (title)
        pm.expect(article, 'Article must have a title').to.have.property("title");
        
        // 2. Memeriksa Deskripsi (description)
        pm.expect(article, 'Article must have a description').to.have.property("description");
        
        // 3. Memeriksa Penulis (author)
        // Note: Saya memasukkan 'author' sesuai permintaan tugas sebelumnya,
        // meskipun kode awal Anda menggunakan 'url'. Anda bisa ganti 'author'
        // menjadi 'url' jika itu yang Anda inginkan.
        pm.expect(article, 'Article must have an author').to.have.property("author");
    });
});