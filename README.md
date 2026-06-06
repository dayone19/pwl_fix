# 💼 Sistem Payroll Web Manajemen

Sistem **Payroll Web Manajemen** yang dikembangkan menjadi aplikasi berbasis web pada perusahaan jasa bengkel yang digunakan untuk mengelola penggajian karyawan secara terstruktur.  

---

# 👥 DIVISI

1. 🧑‍💼 **MANAGEMENT**
2. 🧑‍💻 **HRD**
3. 💰 **FINANCE**
4. 🔧 **TEKNIS**

### 🏷️ Jabatan 
-  Manager  
-  HR  
-  Payroll Officer 
-  Accountant  
-  Foreman  
-  Heavy Repair
-  General Repair  
-  Electrical Repair
-  Diagnostic Repair
-  Body Repair
-  Admin Service  

---

# 🔄 ALUR KERJA LENGKAP

## 🧾 1. HRD Mengelola Data Karyawan

HRD bertugas mengurus data dasar karyawan.

### 📌 Yang dilakukan HRD:
-  Kelola data karyawan  
-  Kelola jabatan  
-  Kelola divisi  
-  Kelola absensi  
-  Kelola lembur  
-  Kelola bonus
-  Approve Cuti Karyawan  

### 📤 Output: 
-  Ekspor Pdf Rekap Absensi Pribadi dan Slip Gaji
-  Ekspor Pdf Absensi Seluruh Karyawan
-  Melihat Slip Gaji
-  Melihat Riwayat Gaji 
-  Melihat Data Profil Karyawan 
-  Cetak Kartu Pegawai 

---

## 💰 2. Payroll Staff Menghitung Gaji

Setelah data lengkap, bagian **Payroll Staff** membuat perhitungan gaji.

### 📌 Yang dilakukan Payroll:
- 📥 Mengambil data rekap absensi seluruh karyawan 
- 🧮 Menghitung:
  -  Gaji pokok  
  -  Tunjangan  
  -  Bonus  
  -  Potongan  

### 📤 Status:
-  **Draft Payroll Karyawan** untuk setiap karyawan  
  Status awal:  **Draft** (Masih bisa diedit oleh payroll, belum dilihat/ dikirim ke manager)
-  **Aksi Payroll** jika perhitungan sudah selsesai, Payroll menekan tombol sumbit.
  Status berubah:  **Terbit** (Data dikirim dan masuk ke antrian manager)

### 📤 Output :  
-  Melihat Slip gaji
-  Melihat Riwayat Gaji  
-  Melihat laporan gaji seluruh karyawan setelah finalisasi  
-  Cetak Kartu Pegawai 

---

## ✅ 3. Manager Melakukan Approval

Manager menerima data individu yang berstatus 'Terbit' dan bertugas untuk mengecek, apakah perhitungan sesuai dengan data.

### 🔍 Yang dicek:
-  Rekap Absensi seluruh karyawan
-  Bonus atau tunjangan  
-  Potongan (cuti / alpa)  
-  Total gaji  

### 🔄 Keputusan:
-  Jika salah → dikembalikan ke Payroll Staff untuk diperbaiki.
Status berubah: 🔴 **Ditolak** 

-  Jika benar → **Manager menyetujui payroll**  
Status berubah: 🟢 **Dibayar**

---

## 📦 4. Payroll Staff Finalisasi Payroll

Setelah data per individu disetujui manager:

-  Payroll staff melakukan finalisasi dan transfer gaji. 

Status berubah: 🟢 **Dibayar**  
-  Sistem membuat **slip gaji**  

---

## 👨‍🔧 5. Karyawan Melihat Slip Gaji

Karyawan login ke sistem untuk:

- 📅 Melihat riwayat dan rekap absen individu  
- 📥 Download slip gaji, absen individu  
- 🔍 Melihat rincian:
  -  Gaji pokok  
  -  Tunjangan  
  -  Potongan  
  -  Bonus  
  -  Total gaji  

---
# 📌 ATURAN KERJA & BONUS KARYAWAN TEKNIS
## 👨‍🔧 Admin service
  -  Menginput kerjaan masuk dari pelanggan  

## 👨‍🔧 Teknis selain Admin Service
-  Foreman  
-  Heavy Repair
-  General Repair  
-  Electrical Repair
-  Diagnostic Repair
-  Body Repair
-  Admin Service
  Tugas :
  -  Mengambil pekerjaan yang sudah diinput dari Admin Service sesuai jabatan masing-masing

  Bonus :
  -  Target harian teknis = 5 pekerjaan 
  -  Jika melebihi target harian, walaupun menyelesaikan 1 saja, maka teknisi mendapatkan bonus harian.

  Bonus 
-> Contoh :  Simulasi Perhitungan
Selesai = 4  
Karena 4 < 5 → Bonus = Rp 0

Selesai = 5  
Kelipatan = floor(5/5) = 1
Bonus = 1 × 20.000 = Rp 20.000

Selesai = 10  
Kelipatan = floor(10/5) = 2
Bonus = 2 × 20.000 = Rp 40.000

Selesai = 12  
Kelipatan = floor(12/5) = 2
Bonus = 2 × 20.000 = Rp 40.000

Selesai = 15  
Kelipatan = floor(15/5) = 3
Bonus = 3 × 20.000 = Rp 60.000
---
# 📌 ATURAN CUTI & PERHITUNGAN GAJI

## 🏖️ Aturan Cuti
Cuti tahunan ditetapkan sebanyak **12 hari kerja per tahun**. Cuti ini hanya berlaku untuk cuti biasa.

Terdapat 2 jenis cuti
- Cuti keperluan, dan cuti bukan keperluan
- kalau karyawan mengajukan cuti keperluan, kalau disetujui, kuota cuti tidak berkurang lalu statusnya menjadi izin
- kalau cuti yang bukan termasuk keperluan, kalau ditolak maka tetap hadir, kalau diterima statusnya menjadi izin

Jika karyawan mengambil cuti melebihi batas yang ditentukan, maka kelebihan tersebut akan dianggap sebagai **alpha (tidak masuk kerja)** dan akan mempengaruhi perhitungan gaji.

---

## 💰 Perhitungan Gaji
Perhitungan gaji dilakukan berdasarkan gaji bulanan dengan standar **26 hari kerja** dalam satu bulan.

Dalam proses penggajian, terdapat beberapa penyesuaian:
- ❌ Ketidakhadiran tanpa keterangan (alpha) akan mengurangi gaji sebesar **gaji harian**
- ⏰ Keterlambatan akan dikenakan potongan sesuai ketentuan perusahaan
- 📊 Absensi mempengaruhi total gaji yang diterima

Selain itu, gaji juga dikenakan **pajak** yang dihitung berdasarkan total penghasilan tahunan dengan sistem persentase (progresif), kemudian dibagi menjadi potongan bulanan.

Adapun rumus perhitungan gaji adalah sebagai berikut:

Gaji Harian = Gaji Bulanan / 26  

Potongan Alpha = Jumlah Alpha × Gaji Harian  

Potongan Telat = Jumlah Telat × Tarif Telat  

Pajak Bulanan = Pajak Tahunan / 12  

Tunjangan = Gaji Pokok x 15%

Gaji Bersih = Gaji Bulanan − (Potongan Alpha + Potongan Telat + Pajak Bulanan)  

Alur perhitungannya dimulai dari menghitung gaji harian berdasarkan gaji bulanan, kemudian menghitung jumlah ketidakhadiran (alpha) dan keterlambatan untuk mendapatkan total potongan. Setelah itu dihitung pajak bulanan berdasarkan penghasilan tahunan. Seluruh potongan tersebut kemudian dikurangkan dari gaji bulanan sehingga menghasilkan **gaji bersih** yang diterima karyawan.

# 🛠️ PENAMBAHAN FITUR

- Karyawan dapat mencetak kartu pegawai 
- Karyawan dapat mengetahui status pembayaran gaji mereka secara individu  
- Pembatasan login sebanyak 3x, jika lebih dari 3x, maka harus menunggu uselama 15 menit untuk login  
- Sistem Forgot password yang harus di setujui oleh HRD


# 🛠️ PERBAIKAN DAN SARAN OLEH DOSEN

### 1. 🔐 Akses HRD
- HRD dapat mengakses data absensi karyawan  
- HRD dapat mengubah data absensi jika diperlukan  

### 2. 🔗 Keterkaitan Absen dan Gaji
- Data absensi memengaruhi perhitungan gaji  
- Absensi memengaruhi gaji jika batas izin/cuti sudah habis  

### 3. ✨ Tambahan Fitur

#### 📝 Pengajuan Cuti / Izin
- Karyawan dapat mengajukan cuti ke HRD  
- HRD dapat:
  -  Menyetujui  
  -  Menolak  
