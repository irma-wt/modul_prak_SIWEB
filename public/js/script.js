// ==========================================
// 1. FITUR DARK MODE (LocalStorage & DOM)
// ==========================================
const btnTheme = document.getElementById('btn-theme');
const body = document.body;

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

function updateWishlistCount() {
    document.getElementById('wishlist-count').innerText = wishlist.length;
}

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

const wishlistModal = document.getElementById('wishlistModal');
wishlistModal.addEventListener('show.bs.modal', function () {
    tampilkanWishlist();
});

function hapusWishlist() {
    wishlist = [];
    sessionStorage.removeItem('wishlist');
    updateWishlistCount();
    tampilkanWishlist();
}

updateWishlistCount();

// ==========================================
// 4. FITUR FORM TAMBAH SEPATU (DOM)
// ==========================================
const formTambah = document.getElementById('form-tambah');
if (formTambah) {
    formTambah.addEventListener('submit', function (e) {
        e.preventDefault();

        const nama     = document.getElementById('input-nama').value.trim();
        const harga    = parseInt(document.getElementById('input-harga').value);
        const stok     = parseInt(document.getElementById('input-stok').value);
        const kategori = document.getElementById('input-kategori').value;

        if (!nama || isNaN(harga) || isNaN(stok)) {
            alert("Mohon isi semua data dengan benar!");
            return;
        }

        const hargaFormatted = "Rp " + harga.toLocaleString('id-ID');

        const cardHTML = `
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <span class="badge bg-secondary mb-2">${kategori}</span>
                        <h5 class="card-title">${nama}</h5>
                        <p class="card-text harga-text">Harga: ${hargaFormatted}</p>
                        <p class="card-text stok-text">Stok: ${stok}</p>
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-primary btn-detail w-50 me-2">Beli</button>
                            <button class="btn btn-outline-danger btn-wishlist w-50">❤ Wishlist</button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        document.getElementById('container-barang').insertAdjacentHTML('beforeend', cardHTML);

        // Re-aktifkan event listener tombol baru
        aktifkanTombolBeli();

        // Re-bind wishlist button pada card baru
        const semuaWishlist = document.querySelectorAll('.btn-wishlist');
        const lastWishlist = semuaWishlist[semuaWishlist.length - 1];
        lastWishlist.addEventListener('click', function (e) {
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

        formTambah.reset();
        alert("Sepatu \"" + nama + "\" berhasil ditambahkan!");
    });
}