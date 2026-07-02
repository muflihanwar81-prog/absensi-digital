# Database Entity Relationship Diagram (ERD)

Berikut adalah diagram relasi entitas (ERD) untuk database aplikasi absensi berdasarkan struktur tabel terbaru.

```mermaid
erDiagram
    DIVISIS ||--o{ USERS : "memiliki (1:N)"
    USERS ||--o{ ABSENSIS : "melakukan (1:N)"
    USERS ||--o{ IZINS : "mengajukan (1:N)"

    USERS {
        bigint id PK
        string nip
        string nama
        bigint divisi_id FK "nullable"
        string divisi
        string jabatan
        string email
        string username
        string password
        string role "Admin / Kepala Divisi / Karyawan"
        string status "Aktif / Nonaktif"
        date tgl_lahir
        string jenis_kelamin
        text alamat
        date tgl_bergabung
        string no_hp
        time jam_masuk
        time jam_keluar
        text komentar_nonaktif
        timestamp created_at
        timestamp updated_at
    }

    DIVISIS {
        bigint id PK
        string nama_divisi
        time jam_masuk
        time jam_keluar
        float latitude
        float longitude
        integer radius
        timestamp created_at
        timestamp updated_at
    }

    ABSENSIS {
        bigint id PK
        bigint user_id FK
        date tanggal
        time jam_masuk
        time jam_keluar
        string status "Hadir/Terlambat/Izin/Sakit/Alpha"
        timestamp created_at
        timestamp updated_at
    }

    IZINS {
        bigint id PK
        bigint user_id FK
        string nip
        string nama
        string divisi
        string jabatan
        date tanggal
        text alasan
        string kategori "Sakit / Izin / Cuti"
        date tanggal_mulai
        date tanggal_selesai
        string file_tambahan
        string status "Menunggu / Disetujui / Ditolak"
        text alasan_tolak
        timestamp created_at
        timestamp updated_at
    }

    ADMIN_ACTIVITIES {
        bigint id PK
        string type
        string judul
        string deskripsi
        string icon
        string warna
        timestamp created_at
        timestamp updated_at
    }

    SETTINGS {
        bigint id PK
        string key
        text value
        timestamp created_at
        timestamp updated_at
    }
```

> [!NOTE]
> - Tabel `karyawans` tidak dimasukkan karena strukturnya sudah digabung (di-*merge*) sepenuhnya ke dalam tabel `USERS`.
> - Tabel `perizinans` juga tidak dimasukkan karena telah tergantikan oleh tabel `IZINS`.
> - Tabel bawaan framework Laravel (seperti `migrations`, `sessions`, `cache`, dan `jobs`) disembunyikan agar diagram fokus pada domain bisnis aplikasi.
