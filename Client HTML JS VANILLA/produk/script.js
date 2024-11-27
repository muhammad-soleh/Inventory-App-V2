document.addEventListener("DOMContentLoaded", function () {
  // Fetch data from API
  fetch("http://localhost:8000/produk/getStockProduk")
    .then((response) => response.json()) // Convert response to JSON
    .then((data) => {
      // Populate table body
      const tableBody = document.querySelector("#produk tbody");
      console.log(data);
      data.forEach((item, index) => {
        const row = `
                      <tr>
                          <td>${index + 1}</td>
                          <td>${item.nama_produk}</td>
                          <td>${item.deskripsi}</td>
                          <td>${item.kategori}</td>
                          <td>Rp. ${formatRupiah(item.harga)}</td>
                          <td>${item.stok_terkini}</td>
                      </tr>
                  `;
        tableBody.insertAdjacentHTML("beforeend", row);
      });

      // Initialize DataTables
      $("#produk").DataTable();
    })
    .catch((error) => console.error("Error fetching data:", error));
});

function submitForm() {
  const nama_produk = document.getElementById("nama_produk").value.trim();
  const deskripsi = document.getElementById("deskripsi").value.trim();
  const kategori = document.getElementById("kategori").value;
  const harga = document.getElementById("harga").value.trim();
  const stok_awal = document.getElementById("stok_awal").value.trim();
  const errorMessage = document.getElementById("error-message");

  // Clear previous error message
  errorMessage.textContent = "";

  // Validasi form
  if (!nama_produk || !harga) {
    errorMessage.textContent = "Nama produk dan harga wajib diisi!";
    return;
  }

  // Data yang akan dikirim
  const data = {
    nama_produk,
    deskripsi,
    kategori,
    harga: parseFloat(harga),
    stok_awal: parseInt(stok_awal),
  };

  // Fetch API
  fetch("http://localhost:8000/produk/", {
    method: "POST",
    body: JSON.stringify(data),
  })
    .then((response) => {
      console.log("Status Response:", response.status);
      if (!response.ok) {
        throw new Error("Terjadi kesalahan pada server.");
      }
      alert("Produk berhasil ditambahkan!");
      window.location.href = "produk.html";
      return response.json();
    })
    .catch((error) => {
      console.error("Error:", error);
      errorMessage.textContent = error.message || "Gagal menghubungi server!";
    });
}
