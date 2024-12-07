# Inventory App V1

Aplikasi manajemen inventaris yang membantu melacak stok barang, penjualan, dan pembelian secara efisien.

## Fitur Utama

- Menambahkan, Mengedit,dan Menghapus Data Produk/Barang.
- Terdapat menu Penjualan dan Pembelian yang akan menambahkan/mengurangi stok ketika ada pembelian atau penjualan.
- Terdapat menu history untuk melacak data produk/barang yang terjual, terbeli maupun penambahan produk
- Bisa digunakan untuk login karena sudah ada menu user dan role yang dapat diatur oleh admin.

## Teknologi yang digunakan

### Backend

- PHP (v8.0.3)
- Database MYSQL (Laragon)
- JWT (untuk enkripsi token)

### Frontend

- HTML,CSS, dan JS Vanilla

### Cara instalasi

```bash
# Clone Repository
# Import sql query database ada di Inventory.sql
# Install composer package
composer install
# Jalankan server nya dengan command
cd ./server
php -S localhost:8000
# Lalu buka file login,html di folder client
# admin password default
# user : admin , pass : admin
```

## API Dokumentasi

### Endpoint : GET /produk

- Deskripsi: Mengambil semua produk
- Header: Authorization: 'Bearer {token}'
- Response:

```json

```

### Endpoint : GET /produk?id={id}

- Deskripsi: Mengambil produk sesuai ID
- Header: Authorization: 'Bearer {token}'
- Response :

```json
"data": [
    {
      "id_produk": 1,
      "id_user": 2,
      "nama_produk": "Shampoo",
      "deskripsi": "Shampoo murah",
      "kategori": "Barang",
      "harga": "2000.00",
      "stok_awal": 20
    }
  ],
  "user": {
    "id_user": 2,
    "username": "soleh",
    "role": "admin",
    "iat": 1733538370,
    "exp": 1733541970
  }
```

### Endpoint : POST /produk

- Deskripsi: Menambahkan Produk
- Header: Authorization: 'Bearer {token}'
- Body:

```json
{
  "nama_produk": "{nama_produk}",
  "deskripsi": "{deskripsi}",
  "kategori": "{kategori}",
  "harga": "{harga}",
  "stok_awal": "{harga}",
  "id_user": "{id_user}"
}
```

- Response:

```json
{
  "success": true,
  "message": "Produk berhasil ditambahkan"
}
```

### Endpoint : PUT /produk?id={id}

- Deskripsi: Mengedit Produk berdasarkan ID
- Header: Authorization: 'Bearer {token}'
- Body:

```json
{
    'nama_produk': '{nama_produk}',
    'deskripsi': '{deskripsi}',
    'kategori': '{kategori}',
    'harga': '{harga}',
    'stok_awal': '{harga}',
    'id_user': '{id_user}'
    'id_produk': '{id_produk}'
}
```

- Response:

```json
{
  "succes": true,
  "message": "Produk berhasil diupdate"
}
```

### Endpoint : DELETE /produk?id={id}

- Deskripsi: Menghapus produk sesuai ID
- Header: Authorization: 'Bearer {token}'
- Response:

```json
{
  "succes": true,
  "message": "Produk Berhasil Dihapus"
}
```

### Endpoint : POST /penjualan

- Deskripsi: Menambahkan Penjualan
- Header: Authorization: 'Bearer {token}'
- Body:

```json
{
  "id_produk": "{id_produk}",
  "id_user": "{id_user}",
  "jumlah": "{jumlah}",
  "harga_satuan": "{harga_satuan}",
  "total_harga": "{total_harga}"
}
```

- Response:

```json
{
  "success": true,
  "message": "Penjualan berhasil ditambahkan"
}
```

### Endpoint : POST /pembelian

- Deskripsi: Menambahkan pembelian
- Header: Authorization: 'Bearer {token}'
- Body:

```json
{
  "id_produk": "{id_produk}",
  "id_user": "{id_user}",
  "jumlah": "{jumlah}",
  "harga_satuan": "{harga_satuan}",
  "total_harga": "{total_harga}"
}
```

- Response:

```json
{
  "success": true,
  "message": "Pembelian berhasil ditambahkan"
}
```

### Endpoint : GET /history

- Deksripsi: Menampilkan semua history pembelian,penjualan dan produk
- Header : Authorization : 'Bearer {token}'
- Response:

```json
{
  "data": [
    {
      "id_history": 2,
      "id_produk": 1,
      "tipe": "penjualan",
      "jumlah": 10,
      "stok_awal": 20,
      "stok_akhir": 10,
      "id_user": 2,
      "tanggal": "2024-12-05 20:03:21",
      "nama_produk": "Shampoo"
    },
    {
      "id_history": 1,
      "id_produk": 1,
      "tipe": "Menambahkan Produk",
      "jumlah": 20,
      "stok_awal": 0,
      "stok_akhir": 20,
      "id_user": 2,
      "tanggal": "2024-12-05 20:03:01",
      "nama_produk": "Shampoo"
    }
  ],
  "user": {
    "id_user": 2,
    "username": "soleh",
    "role": "admin",
    "iat": 1733538370,
    "exp": 1733541970
  }
}
```

### Endpoint : GET /user

- Deskripsi: Mengambil semua user
- Header: Authorization: 'Bearer {token}'
- Response:

```json
{
  "data": [
    {
      "id_user": 2,
      "username": "soleh",
      "email": "soleh@gmail.com",
      "password": "$2y$10$UgTsdwNF8peA2h3..q10G.9JjBqS0uqzsiqssE8C9HENycUKviBA2",
      "full_name": "soleh",
      "role": "admin",
      "created_at": "2024-12-05 20:02:01",
      "updated_at": "2024-12-05 20:02:01"
    }
  ],
  "user": {
    "id_user": 2,
    "username": "soleh",
    "role": "admin",
    "iat": 1733538370,
    "exp": 1733541970
  }
}
```

### Endpoint : GET /user?id={id}

- Deskripsi: Mengambil user sesuai ID
- Header: Authorization: 'Bearer {token}'
- Response:

```json
{
  "data": [
    {
      "id_user": 2,
      "username": "soleh",
      "email": "soleh@gmail.com",
      "password": "$2y$10$UgTsdwNF8peA2h3..q10G.9JjBqS0uqzsiqssE8C9HENycUKviBA2",
      "full_name": "soleh",
      "role": "admin",
      "created_at": "2024-12-05 20:02:01",
      "updated_at": "2024-12-05 20:02:01"
    }
  ]
}
```

### Endpoint : POST /user

- Deskripsi: Menambahkan User
- Header: Authorization: 'Bearer {token}'
- Body:

```json
{
  "username": "{username}",
  "email": "{email}",
  "password": "{password}",
  "full_name": "{full_name}",
  "role": "{role}"
}
```

- Response:

```json
{
  "status": true,
  "message": "User Berhasil Ditambahkan"
}
```

### Endpoint : PUT /user?id={id}

- Deskripsi: Mengupdate User berdasarkan ID
- Header: Authorization: 'Bearer {token}'
- Body:

```json
{
  "username": "{username}",
  "email": "{email}",
  "password": "{password}",
  "full_name": "{full_name}",
  "role": "{role}",
  "id_user": "{id_user}"
}
```

- Response:

```json
{
  "status": true,
  "message": "User Berhasil Ditambahkan"
}
```

### Endpoint : GET /produk/getStockProduk

- Deskripsi: Menampilkan Produk Dengan Stoknya
- Header: Authorization: 'Bearer {token}'
- Response:

```json
{
  "data": [
    {
      "id_produk": 1,
      "id_user": 2,
      "nama_produk": "Shampoo",
      "deskripsi": "Shampoo murah",
      "kategori": "Barang",
      "harga": "2000.00",
      "stok_awal": 20,
      "stok_terkini": 10
    }
  ],
  "user": {
    "id_user": 2,
    "username": "soleh",
    "role": "admin",
    "iat": 1733538370,
    "exp": 1733541970
  }
}
```

### Endpoint : DELETE /user?id={id}

- Deskripsi: Menghapus user sesuai ID
- Header: Authorization: 'Bearer {token}'
- Response:

```json
{
  "succes": true,
  "message": "User Berhasil Dihapus"
}
```

### Endpoint : GET /produk/getProdukPenjualan

- Deskripsi: Menampilkan Penjualan Dengan Nama Produknya
- Header: Authorization: 'Bearer {token}'
- Response:

```json
{
  "data": [
    {
      "nama_produk": "Shampoo",
      "id_penjualan": 1,
      "id_produk": 1,
      "id_user": 2,
      "jumlah": 10,
      "harga_satuan": "2000.00",
      "total_harga": "20000.000",
      "tanggal": "2024-12-05 20:03:21"
    }
  ],
  "user": {
    "id_user": 2,
    "username": "soleh",
    "role": "admin",
    "iat": 1733538370,
    "exp": 1733541970
  }
}
```

### Endpoint : GET /produk/getProdukPembelian

- Deskripsi: Menampilkan Pembelian Dengan Stoknya
- Header: Authorization: 'Bearer {token}'
- Response:

```json
{
  "data": [
    {
      "nama_produk": "Shampoo",
      "id_pembelian": 1,
      "id_produk": 1,
      "id_user": 2,
      "jumlah": 2,
      "harga_satuan": "2000.00",
      "total_harga": "4000.00",
      "tanggal": "2024-12-07 09:39:21"
    }
  ],
  "user": {
    "id_user": 2,
    "username": "soleh",
    "role": "admin",
    "iat": 1733538370,
    "exp": 1733541970
  }
}
```
