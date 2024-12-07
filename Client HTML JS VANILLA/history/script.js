document.addEventListener("DOMContentLoaded", function () {
  const token = sessionStorage.getItem("authToken");
  const tableBody = document.querySelector("#history tbody");
  // Tambahkan teks loading sebelum data dimuat
  const loadingRow = `<tr id="loading-row"><td colspan="7" class="text-center">Loading...</td></tr>`;
  tableBody.insertAdjacentHTML("beforeend", loadingRow);

  fetch("http://localhost:8000/history", {
    headers: {
      Authorization: `Bearer ${token}`,
    },
  })
    .then((response) => response.json())
    .then((data) => {
      // Hapus baris loading
      document.getElementById("loading-row").remove();
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
                    <td>${item.tipe}</td>
                    <td>${item.jumlah}</td>
                    <td>${item.stok_awal}</td>
                    <td>${item.stok_akhir}</td>
                    <td>${username}</td>
                    <td>${formatTanggal(item.tanggal)}</td>
                    
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
        $("#history").DataTable();
      });
    })
    .catch((error) => console.error("Error fetching data:", error));
});
