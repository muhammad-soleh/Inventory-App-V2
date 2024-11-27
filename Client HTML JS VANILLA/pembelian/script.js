document.addEventListener("DOMContentLoaded", function () {
  //data produk Pembelian
  fetch("http://localhost:8000/produk/getProdukPembelian")
    .then((response) => response.json()) // Convert response to JSON
    .then((data) => {
      // Populate table body
      const tableBody = document.querySelector("#pembelian tbody");
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
      $("#pembelian").DataTable();
    })
    .catch((error) => console.error("Error fetching data:", error));
});
