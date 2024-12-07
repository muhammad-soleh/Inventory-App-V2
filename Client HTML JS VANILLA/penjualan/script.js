document.addEventListener("DOMContentLoaded", function () {
  const token = sessionStorage.getItem("authToken");

  fetch("http://localhost:8000/produk/getProdukPenjualan", {
    headers: {
      Authorization: `Bearer ${token}`,
    },
  })
    .then((response) => response.json())
    .then((data) => {
      const tableBody = document.querySelector("#penjualan tbody");
      if (data.status == "error") {
        const row = `<tr><td colspan="7" class="text-center">Gagal Query</td></tr>`;
        tableBody.insertAdjacentHTML("beforeend", row);
        return;
      }
      const promises = data.data.map((item, index) =>
        fetch("http://localhost:8000/user?id=" + item.id_user)
          .then((response) => response.json())
          .then((data2) => {
            const username = data2.data[0].username;

            const row = `
                <tr>
                    <td>${index + 1}</td>
                    <td>${item.nama_produk}</td>
                    <td>${item.jumlah}</td>
                    <td>Rp. ${formatRupiah(item.harga_satuan)}</td>
                    <td>Rp. ${formatRupiah(item.total_harga)}</td>
                    <td>${formatTanggal(item.tanggal)}</td>
                    <td>${username}</td>
                </tr>
            `;
            tableBody.insertAdjacentHTML("beforeend", row);
          })
      );

      // Setelah semua data selesai dimuat
      Promise.all(promises).then(() => {
        if (data.user.role != "admin") {
          document.getElementById("admin").classList.add("invisible");
        }
        document.getElementById("welcome_user").innerHTML =
          "Welcome, " + data.user.username;
        // Initialize DataTables setelah data selesai dimuat
        $("#penjualan").DataTable();
      });
    })
    .catch((error) => console.error("Error fetching data:", error));
});
