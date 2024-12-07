document.addEventListener("DOMContentLoaded", function () {
  const token = sessionStorage.getItem("authToken");
  // Fetch data from API
  fetch("http://localhost:8000/produk/getStockProduk", {
    headers: {
      Authorization: `Bearer ${token}`,
    },
  })
    .then((response) => response.json()) // Convert response to JSON
    .then((data) => {
      // Populate table body
      const tableBody = document.querySelector("#produk tbody");
      if (data.status == "error") {
        const row = `<tr><td colspan="7" class="text-center">Gagal Query</td></tr>`;
        tableBody.insertAdjacentHTML("beforeend", row);
        return;
      }
      data.data.forEach((item, index) => {
        const row = `
                      <tr>
                          <td>${index + 1}</td>
                          <td>${item.nama_produk}</td>
                          <td>${item.deskripsi}</td>
                          <td>${item.kategori}</td>
                          <td>Rp. ${formatRupiah(item.harga)}</td>
                          <td>${item.stok_terkini}</td>
                          <td> <div class="btn-group" role="group">
                          
        <button type="button" class="btn btn-sm btn-warning" onclick=edit(${
          item.id_produk
        })><i class="bi bi-pencil-square"></i> Edit</button>
        <button type="button" class="btn btn-sm btn-danger" onclick=deleteProduk(${
          item.id_produk
        })><i class="bi bi-trash"></i> Delete</button>
      </div></td>
                      </tr>
                  `;
        tableBody.insertAdjacentHTML("beforeend", row);
      });
      if (data.user.role != "admin") {
        document.getElementById("admin").classList.add("invisible");
      }
      document.getElementById("welcome_user").innerHTML =
        "Welcome, " + data.user.username;
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

// Edit Data
function edit(id) {
  fetch("http://localhost:8000/produk?id=" + id, {
    method: "GET",
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.status == "error") {
        alert("Tidak dapat mengedit data");
        return;
      }
      if (localStorage.getItem("produkData")) {
        localStorage.removeItem("produkData");
      }
      localStorage.setItem("produkData", JSON.stringify(data.data[0]));
      window.location.href = "edit_produk.html";
    });
}

function deleteProduk(id) {
  if (confirm("Yakin ingin menghapus Data?")) {
    fetch("http://localhost:8000/produk?id=" + id, {
      method: "DELETE",
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.status == "error") {
          alert("Tidak dapat Menghapus data");
          return;
        }
        alert("data berhasil dihapus");

        window.location.href = "produk.html";
      });
  }
}
