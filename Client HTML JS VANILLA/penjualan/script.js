document.addEventListener("DOMContentLoaded", function () {
  //data produk penjualan
  fetch("http://localhost:8000/produk/getProdukPenjualan")
    .then((response) => response.json()) // Convert response to JSON
    .then((data) => {
      // Populate table body
      const tableBody = document.querySelector("#penjualan tbody");
      console.log(data);
      data.forEach((item, index) => {
        const row = `
                      <tr>
                          <td>${index + 1}</td>
                          <td>${item.nama_produk}</td>
                          <td>${item.jumlah}</td>
                          <td>Rp. ${formatRupiah(item.harga_satuan)}</td>
                          <td>Rp. ${formatRupiah(item.total_harga)}</td>
                          <td>${formatTanggal(item.tanggal)}</td>
                      </tr>
                  `;
        tableBody.insertAdjacentHTML("beforeend", row);
      });

      // Initialize DataTables
      $("#penjualan").DataTable();
    })
    .catch((error) => console.error("Error fetching data:", error));
});
