# 👥 PEMBAGIAN TUGAS ROLE PPDB

## 🎯 **ALUR LENGKAP PPDB**

```
SISWA → VERIFIKATOR → KEUANGAN → ADMIN → HASIL AKHIR
```

---

## 📋 **1. SISWA/PENDAFTAR**

### 🔹 **Tugas:**
- ✅ Daftar akun dengan email + OTP
- ✅ Isi data pribadi lengkap
- ✅ Upload berkas (KTP, Ijazah, Foto, dll)
- ✅ Upload bukti pembayaran
- ✅ Cek status pendaftaran

### 🔹 **Status yang Dialami:**
- `SUBMIT` → Baru submit data
- `VERIFIKASI_ADMIN` → Berkas perlu diperbaiki
- `MENUNGGU_PEMBAYARAN` → Berkas OK, harus bayar
- `MENUNGGU_VERIFIKASI_KEUANGAN` → Sudah bayar, menunggu verifikasi
- `TERBAYAR` → Pembayaran sudah diverifikasi
- `LULUS` → Diterima! 🎉
- `TIDAK_LULUS` → Ditolak 😔
- `CADANGAN` → Masuk daftar tunggu

---

## 🔍 **2. VERIFIKATOR**

### 🔹 **Tugas:**
- ✅ Cek kelengkapan berkas pendaftar
- ✅ Verifikasi keaslian dokumen
- ✅ Validasi data pribadi
- ✅ Memberikan catatan jika ada masalah

### 🔹 **Keputusan yang Bisa Diambil:**
- `MENUNGGU_PEMBAYARAN` → Berkas lengkap dan valid
- `VERIFIKASI_ADMIN` → Berkas perlu diperbaiki
- `TIDAK_LULUS` → Berkas tidak memenuhi syarat

### 🔹 **Login:**
- Email: `verifikator@smk.com`
- Password: `verifikator123`

---

## 💰 **3. KEUANGAN**

### 🔹 **Tugas:**
- ✅ Verifikasi bukti pembayaran
- ✅ Cek kesesuaian nominal
- ✅ Validasi metode pembayaran
- ✅ Input pembayaran manual (jika ada)

### 🔹 **Keputusan yang Bisa Diambil:**
- `verified` → Pembayaran valid
- `rejected` → Pembayaran ditolak

### 🔹 **Login:**
- Email: `keuangan@smk.com`
- Password: `keuangan123`

---

## 👨‍💼 **4. ADMIN**

### 🔹 **Tugas:**
- ✅ Menentukan status AKHIR pendaftar
- ✅ Mengatur kuota jurusan
- ✅ Manajemen data master (jurusan, gelombang, user)
- ✅ Melihat laporan lengkap
- ✅ Export data

### 🔹 **Keputusan AKHIR yang Bisa Diambil:**
- `LULUS` → Diterima (cek kuota otomatis)
- `TIDAK_LULUS` → Ditolak
- `CADANGAN` → Daftar tunggu

### 🔹 **Syarat Menentukan Status Akhir:**
- Pendaftar sudah status `TERBAYAR` atau `VERIFIKASI_KEUANGAN`
- Sudah melewati verifikasi berkas
- Sudah melewati verifikasi pembayaran

### 🔹 **Login:**
- Email: `admin@smk.com`
- Password: `admin123`

---

## 👔 **5. EKSEKUTIF (KEPALA SEKOLAH)**

### 🔹 **Tugas:**
- ✅ Melihat dashboard laporan
- ✅ Monitoring statistik PPDB
- ✅ Melihat grafik dan analisis
- ✅ Export laporan untuk rapat

### 🔹 **Login:**
- Email: `kepsek@smk.com`
- Password: `kepsek123`

---

## 🔄 **ALUR DETAIL STEP BY STEP**

### **Step 1: Pendaftaran Siswa**
1. Siswa daftar → Status: `SUBMIT`
2. Upload berkas lengkap
3. Menunggu verifikasi berkas

### **Step 2: Verifikasi Berkas (VERIFIKATOR)**
1. Verifikator cek berkas
2. Jika OK → Status: `MENUNGGU_PEMBAYARAN`
3. Jika tidak OK → Status: `VERIFIKASI_ADMIN` (siswa perbaiki)
4. Jika sangat buruk → Status: `TIDAK_LULUS`

### **Step 3: Pembayaran (SISWA)**
1. Siswa bayar biaya pendaftaran
2. Upload bukti pembayaran
3. Status otomatis: `MENUNGGU_VERIFIKASI_KEUANGAN`

### **Step 4: Verifikasi Pembayaran (KEUANGAN)**
1. Keuangan cek bukti pembayaran
2. Jika valid → Status pembayaran: `verified` → Status pendaftar: `TERBAYAR`
3. Jika tidak valid → Status pembayaran: `rejected`

### **Step 5: Keputusan Akhir (ADMIN)**
1. Admin lihat semua yang sudah `TERBAYAR`
2. Pertimbangkan:
   - Kelengkapan berkas ✅
   - Pembayaran ✅
   - Kuota jurusan
   - Nilai/kriteria lain
3. Tentukan: `LULUS` / `TIDAK_LULUS` / `CADANGAN`

---

## 🎯 **KESIMPULAN**

✅ **Verifikator** = Cek berkas saja
✅ **Keuangan** = Cek pembayaran saja  
✅ **Admin** = Keputusan akhir saja

**Tidak ada yang overlap, semua punya tugas jelas!** 🎉