let produkList = [];

// Fungsi untuk mencari produk dari API
function searchProduk() {
  const query = document.getElementById("produk").value.toLowerCase();
  const suggestions = document.getElementById("suggestions");
  suggestions.innerHTML = "";

  if (query.length > 1) {
    fetch("http://localhost:8000/produk/getStockProduk")
      .then((response) => response.json())
      .then((data) => {
        produkList = data.filter((item) =>
          item.nama_produk.toLowerCase().includes(query)
        );
        produkList.forEach((item) => {
          const li = document.createElement("li");
          li.textContent = `${item.nama_produk} - Rp ${item.harga} - Stok : ${item.stok_terkini}`;
          li.classList.add("list-group-item");
          li.style.cursor = "pointer";
          li.onclick = () => selectProduk(item);
          suggestions.appendChild(li);
        });
      })
      .catch((error) => console.error("Error:", error));
  }
}

// Fungsi untuk memilih produk dari hasil pencarian
function selectProduk(item) {
  document.getElementById("produk").value = item.nama_produk;
  document.getElementById("harga_satuan").value = item.harga;
  document.getElementById("id_produk").value = item.id_produk;
  document.getElementById("suggestions").innerHTML = "";
  hitungTotal();
}

// Fungsi untuk menghitung harga total
function hitungTotal() {
  const hargaSatuan =
    parseFloat(document.getElementById("harga_satuan").value) || 0;
  const jumlah = parseInt(document.getElementById("jumlah").value) || 0;
  const total = hargaSatuan * jumlah;
  document.getElementById("harga_total").value = total.toLocaleString("id-ID", {
    style: "currency",
    currency: "IDR",
  });
}

// Submit form pembelian
document
  .getElementById("formPembelian")
  .addEventListener("submit", function (event) {
    event.preventDefault();
    const produk = document.getElementById("produk").value;
    const hargaSatuan = document.getElementById("harga_satuan").value;
    const jumlah = document.getElementById("jumlah").value;
    const hargaTotal = document.getElementById("harga_total").value;
    const id_produk = document.getElementById("id_produk").value;

    if (!produk || !hargaSatuan || jumlah <= 0) {
      alert("Harap isi semua data dengan benar.");
      return;
    }

    const dataPembelian = {
      id_produk,
      jumlah,
      harga_satuan: parseFloat(hargaSatuan),
      total_harga: parseFloat(formatToDecimal(hargaTotal)),
    };
    fetch("http://localhost:8000/pembelian/", {
      method: "POST",
      body: JSON.stringify(dataPembelian),
    })
      .then((response) => {
        console.log("Status Response:", response.status);
        if (!response.ok) {
          throw new Error("Terjadi kesalahan pada server.");
        }
        alert("Pembelian berhasil ditambahkan!");
        window.location.href = "pembelian.html";
        return response.json();
      })
      .catch((error) => {
        console.error("Error:", error);
        errorMessage.textContent = error.message || "Gagal menghubungi server!";
      });
  });
