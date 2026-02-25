
// ==========================================
// 1. FITUR DARK MODE (LocalStorage & DOM)
// ==========================================
const btnTheme = document.getElementById('btn-theme');
const body = document.body;

// Cek apakah ada simpanan tema di browser?
if (localStorage.getItem('theme') === 'dark') {
    body.classList.add('dark-mode');
    btnTheme.innerText = "Mode Terang";
}

btnTheme.addEventListener('click', function () {
    body.classList.toggle('dark-mode');

    if (body.classList.contains('dark-mode')) {
        localStorage.setItem('theme', 'dark');
        btnTheme.innerText = "Mode Terang";
    } else {
        localStorage.removeItem('theme');
        btnTheme.innerText = "Mode Gelap";
    }
});

// ==========================================
// 2. FITUR BELI (Event Listener & DOM)
// ==========================================
function aktifkanTombolBeli() {
    const tombolBeli = document.querySelectorAll('.btn-detail');
    tombolBeli.forEach(function (button) {
        button.replaceWith(button.cloneNode(true));
    });
    const tombolBaru = document.querySelectorAll('.btn-detail');
    tombolBaru.forEach(function (button) {
        button.addEventListener('click', function (e) {
            const cardBody = e.target.closest('.card-body');
            const stokElement = cardBody.querySelector('.stok-text');
            let stok = parseInt(stokElement.innerText.replace("Stok: ", ""));
            if (stok > 0) {
                stok--;
                stokElement.innerText = "Stok: " + stok;
                const namaBarang = cardBody.querySelector('.card-title').innerText;
                alert("Berhasil membeli " + namaBarang);
            } else {
                alert("Stok Habis!");
                e.target.disabled = true;
                e.target.innerText = "Habis";
            }
        });
    });
}
aktifkanTombolBeli();

// ==========================================
// 3. FITUR WISHLIST (SessionStorage & DOM)
// ==========================================
let wishlist = JSON.parse(sessionStorage.getItem('wishlist')) || [];

// Update angka counter wishlist di navbar
function updateWishlistCount() {
    document.getElementById('wishlist-count').innerText = wishlist.length;
}

// Tambah produk ke wishlist saat tombol ❤ diklik
document.querySelectorAll('.btn-wishlist').forEach(function (button) {
    button.addEventListener('click', function (e) {
        const cardBody = e.target.closest('.card-body');
        const namaBarang = cardBody.querySelector('.card-title').innerText;

        if (!wishlist.includes(namaBarang)) {
            wishlist.push(namaBarang);
            sessionStorage.setItem('wishlist', JSON.stringify(wishlist));
            updateWishlistCount();
            alert(namaBarang + " ditambahkan ke Wishlist!");
        } else {
            alert(namaBarang + " sudah ada di Wishlist!");
        }
    });
});

// Render isi wishlist ke dalam modal
function tampilkanWishlist() {
    const daftarWishlist = document.getElementById('daftar-wishlist');
    daftarWishlist.innerHTML = '';

    if (wishlist.length === 0) {
        daftarWishlist.innerHTML = '<li class="list-group-item text-center text-muted">Wishlist masih kosong.</li>';
    } else {
        wishlist.forEach(function (item) {
            const li = document.createElement('li');
            li.className = 'list-group-item';
            li.innerText = '❤ ' + item;
            daftarWishlist.appendChild(li);
        });
    }
}

// Panggil tampilkanWishlist() otomatis setiap modal dibuka
const wishlistModal = document.getElementById('wishlistModal');
wishlistModal.addEventListener('show.bs.modal', function () {
    tampilkanWishlist();
});

// Kosongkan semua wishlist
function hapusWishlist() {
    wishlist = [];
    sessionStorage.removeItem('wishlist');
    updateWishlistCount();
    tampilkanWishlist();
}

// Inisialisasi counter saat halaman pertama kali dibuka
updateWishlistCount();