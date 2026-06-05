@extends('layouts.app')
@section('title', 'Ganti Password')
@section('content')

<div class="max-w-md mx-auto mt-10">
    <div class="bg-white rounded-[40px] p-10 shadow-sm border border-slate-100">
        <h2 class="text-2xl font-black text-slate-900 uppercase tracking-tighter mb-2">Ganti Password</h2>
        <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mb-8">Wajib diubah sebelum batas waktu</p>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Password Baru</label>
                    <input type="password" name="password_baru"
                        class="mt-1 w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm font-bold focus:outline-none focus:ring-2 focus:ring-orange-400"
                        placeholder="Min 8 karakter, ada huruf kapital & angka">
                    @error('password_baru') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Konfirmasi Password</label>
                    <input type="password" name="password_baru_confirmation"
                        class="mt-1 w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm font-bold focus:outline-none focus:ring-2 focus:ring-orange-400"
                        placeholder="Ulangi password baru">
                </div>
                <button type="submit"
                    class="w-full bg-orange-600 text-white font-black uppercase tracking-widest py-3 rounded-2xl shadow-lg shadow-orange-200 hover:bg-orange-700 transition-all">
                    Simpan Password
                </button>
            </div>
        </form>
    </div>
</div>

@endsection