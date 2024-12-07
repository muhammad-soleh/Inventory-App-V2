const formatRupiah = (number) => {
  return new Intl.NumberFormat("id-ID").format(number);
};
function formatTanggal(tanggal) {
  const date = new Date(tanggal);

  // Opsi format untuk output yang lebih mudah dibaca
  const options = {
    day: "2-digit",
    month: "long",
    year: "numeric",
    hour: "2-digit",
    minute: "2-digit",
  };

  // Format output dalam bahasa Indonesia
  return date.toLocaleDateString("id-ID", options);
}

function formatToDecimal(rupiahString) {
  // 1. Hilangkan simbol "Rp" dan spasi
  let numericString = rupiahString.replace(/[^\d,.-]/g, "");

  // 2. Ubah pemisah ribuan dari koma/titik ke format desimal JS
  numericString = numericString.replace(/\./g, "").replace(",", ".");

  // 3. Ubah menjadi angka desimal
  const decimalValue = parseFloat(numericString);

  // 4. Pastikan hasil desimal memiliki dua angka di belakang koma
  return decimalValue.toFixed(2);
}

document.getElementById("logout").addEventListener("click", (event) => {
  event.preventDefault();
  if (confirm("Yakin ingin logout?")) {
    sessionStorage.removeItem("authToken");
    window.location.href = "../login.html";
  }
});
