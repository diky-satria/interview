let makanan = [
  {
    kode: 1,
    nama: "Biskuit",
    stok: 2,
    harga: 6000,
  },
  {
    kode: 2,
    nama: "Chips",
    stok: 0,
    harga: 8000,
  },
  {
    kode: 3,
    nama: "Oreo",
    stok: 3,
    harga: 10000,
  },
  {
    kode: 4,
    nama: "Tango",
    stok: 0,
    harga: 12000,
  },
  {
    kode: 5,
    nama: "Coklat",
    stok: 10,
    harga: 15000,
  },
];

class VendingMachine {
  kode;
  bayar;
  totalUangLembaran;
  pecahanUangTerdaftar = [2000, 5000, 10000, 20000, 50000];
  qty;
  error = "";
  pesanan = {};

  constructor(kode, bayar, qty, totalUangLembaran = 1) {
    this.kode = kode;
    this.bayar = bayar;
    this.qty = qty;
    this.totalUangLembaran = totalUangLembaran;
  }

  cekKode() {
    if (this.kode < 1 || this.kode > 5) {
      this.error = "Kode makanan tidak terdaftar";
    }
  }

  cekPecahan() {
    if (!this.error) {
      let status = false;
      for (let i = 0; i <= this.pecahanUangTerdaftar.length; i++) {
        if (this.bayar === this.pecahanUangTerdaftar[i]) {
          status = true;
        }
      }

      if (!status) {
        this.error = "Pecahan uang harus 2000, 5000, 10000, 20000 atau 50000";
      }
    }
  }

  cekStok() {
    if (!this.error) {
      // cek qty yang dipilih
      if (this.qty <= 0) {
        this.error = "Qty yang harus di pilih minimal 1";
      } else {
        // pilih makanan sesuai kode yang dipilih
        let cek = makanan.filter((m) => {
          return m.kode === this.kode;
        });

        // cek apakah stoknya ada
        if (cek[0].stok <= 0) {
          this.error = `Stok ${cek[0].nama} sedang kosong`;
        } else {
          // cek jika qty yang akan dibeli lebih banyak dari stok
          if (this.qty > cek[0].stok) {
            this.error = `Stok ${cek[0].nama} hanya ${cek[0].stok}`;
          } else {
            let total = cek[0].harga * this.qty;
            let kembalian = this.kembalian(
              this.bayar,
              this.totalUangLembaran,
              total
            );
            let pembayaran = this.bayar * this.totalUangLembaran;

            if (pembayaran < total) {
              this.error = `Uang anda tidak cukup! total harga ${total}, uang anda ${pembayaran}`;
            } else {
              this.pesanan = {
                pesananAnda: cek[0].nama,
                harga: cek[0].harga,
                qty: this.qty,
                total: total,
                pembayaran: pembayaran,
                kembalian: kembalian,
              };

              // update stok nya
              cek[0].stok = cek[0].stok - this.qty;
            }
          }
        }
      }
    }
  }

  kembalian(bayar, totalUangLembaran, total) {
    return bayar * totalUangLembaran - total;
  }

  pembelian() {
    this.cekKode();
    this.cekPecahan();
    this.cekStok();

    if (this.error) {
      return this.error;
    }

    return this.pesanan;
  }
}

// masukan kode makanan ke instance class VendingMachine
// 1 - biskuit
// 2 - chips
// 3 - oreo
// 4 = tango
// 5 - coklat

let data = new VendingMachine(5, 5000, 2, 6); // (kode, bayar, qty, totalUangLembaran)
console.log(data.pembelian());
