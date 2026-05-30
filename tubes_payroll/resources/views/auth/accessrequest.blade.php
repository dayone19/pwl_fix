@extends('layouts.app')

@section('title', 'Permintaan Akses | PayTato')

@section('content')

{{-- Flash: link reset (muncul setelah HR setujui) --}}
@if(session('success_link'))
<div x-data="{ show: true }" x-show="show"
     class="mb-8 bg-blue-50 border border-blue-200 rounded-[30px] p-6 flex gap-4 items-start">
    <div class="bg-blue-500 text-white p-3 rounded-2xl flex-shrink-0">
        <i class="fas fa-link text-sm"></i>
    </div>
    <div class="flex-1 min-w-0">
        <p class="text-[10px] font-black uppercase tracking-widest text-blue-600 italic mb-1">
            Link Reset untuk NIP {{ session('success_nip') }}
        </p>
        <p class="text-[11px] text-blue-800 font-bold mb-3">
            Salin link berikut dan kirimkan ke karyawan melalui saluran resmi:
        </p>
        <div class="flex items-center gap-3 bg-white border border-blue-100 rounded-2xl px-4 py-3">
            <code id="resetLink" class="text-[11px] text-slate-700 font-mono break-all flex-1">{{ session('success_link') }}</code>
            <button onclick="copyLink()" class="flex-shrink-0 bg-blue-600 text-white px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-blue-700 transition">
                <i class="fas fa-copy mr-1"></i> Salin
            </button>
        </div>
        <p class="text-[9px] text-blue-400 italic mt-2">* Link berlaku 24 jam</p>
    </div>
    <button @click="show = false" class="text-blue-300 hover:text-blue-500 flex-shrink-0">
        <i class="fas fa-times"></i>
    </button>
</div>
@endif

@if(session('success'))
<div class="mb-6 bg-green-50 border border-green-200 rounded-[25px] p-5 flex items-center gap-3">
    <i class="fas fa-check-circle text-green-500"></i>
    <p class="text-[12px] font-bold text-green-700">{{ session('success') }}</p>
</div>
@endif

@if(session('error'))
<div class="mb-6 bg-red-50 border border-red-200 rounded-[25px] p-5 flex items-center gap-3">
    <i class="fas fa-exclamation-circle text-red-500"></i>
    <p class="text-[12px] font-bold text-red-700">{{ session('error') }}</p>
</div>
@endif

{{-- Header --}}
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
    <div>
        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] italic mb-1">Human Resource</p>
        <h1 class="text-3xl font-black text-slate-900 uppercase italic tracking-tighter leading-none">Permintaan Akses</h1>
    </div>
    {{-- Statistik cepat --}}
    <div class="flex gap-3 flex-wrap">
        @php
            $counts = $requests->getCollection()->groupBy('status');
            $statItems = [
                ['status' => 'pending',   'color' => 'orange', 'icon' => 'fa-clock',        'label' => 'Pending'],
                ['status' => 'disetujui', 'color' => 'blue',   'icon' => 'fa-paper-plane',  'label' => 'Disetujui'],
                ['status' => 'selesai',   'color' => 'green',  'icon' => 'fa-check-double', 'label' => 'Selesai'],
                ['status' => 'ditolak',   'color' => 'red',    'icon' => 'fa-ban',           'label' => 'Ditolak'],
            ];
        @endphp
        @foreach($statItems as $s)
        <div class="bg-white border border-slate-100 rounded-2xl px-4 py-3 flex items-center gap-3 shadow-sm">
            <i class="fas {{ $s['icon'] }} text-{{ $s['color'] }}-500 text-sm"></i>
            <div>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest italic leading-none">{{ $s['label'] }}</p>
                <p class="text-lg font-black text-slate-900 leading-none">
                    {{ \App\Models\AccessRequest::where('status', $s['status'])->count() }}
                </p>
            </div>
        </div>
        @endforeach
    </div>
</div>

{{-- Tabel --}}
<div class="bg-white rounded-[45px] border border-slate-100 shadow-sm overflow-hidden">

    {{-- Table header --}}
    <div class="px-10 py-6 border-b border-slate-50">
        <div class="grid grid-cols-12 gap-4">
            <p class="col-span-2 text-[9px] font-black text-slate-400 uppercase tracking-widest italic">Tanggal</p>
            <p class="col-span-2 text-[9px] font-black text-slate-400 uppercase tracking-widest italic">NIP</p>
            <p class="col-span-3 text-[9px] font-black text-slate-400 uppercase tracking-widest italic">Nama</p>
            <p class="col-span-2 text-[9px] font-black text-slate-400 uppercase tracking-widest italic">Divisi</p>
            <p class="col-span-2 text-[9px] font-black text-slate-400 uppercase tracking-widest italic">Status</p>
            <p class="col-span-1 text-[9px] font-black text-slate-400 uppercase tracking-widest italic text-right">Aksi</p>
        </div>
    </div>

    {{-- Rows --}}
    @forelse($requests as $req)
    @php
        $badge = $req->statusBadge();
        $nama  = $req->pengguna?->nama ?? '–';
        $divisi = $req->pengguna?->divisi?->nama_divisi ?? '–';
        $colorMap = [
            'orange' => 'bg-orange-50 text-orange-600 border-orange-100',
            'blue'   => 'bg-blue-50 text-blue-600 border-blue-100',
            'green'  => 'bg-green-50 text-green-600 border-green-100',
            'red'    => 'bg-red-50 text-red-500 border-red-100',
            'slate'  => 'bg-slate-50 text-slate-500 border-slate-100',
        ];
        $dotMap = [
            'orange' => 'bg-orange-500',
            'blue'   => 'bg-blue-500',
            'green'  => 'bg-green-500',
            'red'    => 'bg-red-500',
            'slate'  => 'bg-slate-400',
        ];
    @endphp
    <div class="px-10 py-5 border-b border-slate-50 hover:bg-slate-50/50 transition group">
        <div class="grid grid-cols-12 gap-4 items-center">
            <p class="col-span-2 text-[11px] font-bold text-slate-500 italic">
                {{ $req->created_at->format('d M Y') }}
            </p>
            <p class="col-span-2 text-[11px] font-black text-slate-900 font-mono">{{ $req->nip }}</p>
            <p class="col-span-3 text-[12px] font-black text-slate-900 italic uppercase tracking-tight truncate">{{ $nama }}</p>
            <p class="col-span-2 text-[11px] font-bold text-slate-500 uppercase italic truncate">{{ $divisi }}</p>
            <div class="col-span-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full border text-[9px] font-black uppercase tracking-widest {{ $colorMap[$badge['color']] }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ $dotMap[$badge['color']] }} flex-shrink-0"></span>
                    {{ $badge['label'] }}
                </span>
            </div>
            <div class="col-span-1 flex justify-end">
                <button
                    onclick="openDetail({{ $req->id }})"
                    class="bg-slate-900 text-white px-4 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest hover:bg-orange-600 transition opacity-0 group-hover:opacity-100">
                    Lihat
                </button>
            </div>
        </div>
    </div>
    @empty
    <div class="px-10 py-20 text-center">
        <i class="fas fa-inbox text-4xl text-slate-200 mb-4"></i>
        <p class="text-[11px] font-black text-slate-400 uppercase italic tracking-widest">Belum ada permintaan akses</p>
    </div>
    @endforelse
</div>

{{-- Pagination --}}
@if($requests->hasPages())
<div class="mt-6 flex justify-end">
    {{ $requests->links() }}
</div>
@endif


{{-- ════════════════════════════════════════════════════════════
     MODAL DETAIL
════════════════════════════════════════════════════════════ --}}
<div id="detailModal"
     class="fixed inset-0 z-[9999] flex items-center justify-center p-4 hidden"
     onclick="if(event.target===this) closeDetail()">

    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-slate-950/60 backdrop-blur-sm"></div>

    {{-- Card --}}
    <div class="relative bg-white rounded-[45px] shadow-2xl w-full max-w-lg overflow-hidden">

        {{-- Dark top bar --}}
        <div class="bg-slate-950 px-10 py-8 relative overflow-hidden">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_var(--tw-gradient-stops))] from-orange-500/15 via-transparent to-transparent pointer-events-none"></div>
            <div class="relative z-10 flex items-start justify-between">
                <div>
                    <p class="text-[9px] font-black text-orange-500 uppercase tracking-widest italic mb-2">Detail Permintaan</p>
                    <h3 id="modalNama" class="text-2xl font-black text-white uppercase italic tracking-tighter leading-none">–</h3>
                    <p id="modalNip" class="text-[11px] font-black text-slate-400 mt-1">NIP –</p>
                </div>
                <button onclick="closeDetail()" class="text-slate-500 hover:text-white transition p-2">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
        </div>

        {{-- Body --}}
        <div class="p-10 space-y-6">

            {{-- Info grid --}}
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-slate-50 rounded-2xl p-4">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest italic mb-1">Divisi</p>
                    <p id="modalDivisi" class="text-[12px] font-black text-slate-900 uppercase italic">–</p>
                </div>
                <div class="bg-slate-50 rounded-2xl p-4">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest italic mb-1">Tanggal Request</p>
                    <p id="modalTanggal" class="text-[12px] font-black text-slate-900 italic">–</p>
                </div>
            </div>

            {{-- Status badge --}}
            <div id="modalStatusWrap" class="flex items-center gap-3">
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest italic">Status Saat Ini:</p>
                <span id="modalStatusBadge" class="px-4 py-1.5 rounded-full border text-[9px] font-black uppercase tracking-widest">–</span>
            </div>

            {{-- Catatan HR (jika ada) --}}
            <div id="modalCatatanWrap" class="hidden bg-orange-50 border border-orange-100 rounded-2xl p-4">
                <p class="text-[9px] font-black text-orange-600 uppercase tracking-widest italic mb-1">Catatan HR</p>
                <p id="modalCatatan" class="text-[11px] text-slate-700 italic">–</p>
            </div>

            {{-- Token info (disetujui) --}}
            <div id="modalTokenWrap" class="hidden bg-blue-50 border border-blue-100 rounded-2xl p-4">
                <p class="text-[9px] font-black text-blue-600 uppercase tracking-widest italic mb-1">
                    <i class="fas fa-clock mr-1"></i> Token berlaku hingga
                </p>
                <p id="modalTokenExpiry" class="text-[12px] font-black text-slate-900 italic">–</p>
            </div>

            {{-- ─── FORM AKSI (pending only) ─── --}}
            <div id="modalFormWrap">
                <form id="approveForm" method="POST">
                    @csrf
                    <div class="flex gap-3">
                        <button type="submit" formaction="" id="btnApprove"
                            class="flex-1 bg-slate-900 text-white py-4 rounded-[20px] font-black text-[10px] uppercase tracking-widest hover:bg-green-600 transition active:scale-[0.97]">
                            <i class="fas fa-check mr-2"></i>Setujui Permintaan
                        </button>
                        <button type="submit" formaction="" id="btnReject"
                            class="flex-1 bg-red-50 text-red-500 border border-red-100 py-4 rounded-[20px] font-black text-[10px] uppercase tracking-widest hover:bg-red-500 hover:text-white transition active:scale-[0.97]">
                            <i class="fas fa-ban mr-2"></i>Tolak
                        </button>
                    </div>
                </form>
            </div>

            {{-- Penutup jika sudah diproses --}}
            <div id="modalDone" class="hidden text-center py-4">
                <p class="text-[11px] font-black text-slate-400 uppercase italic tracking-widest">Permintaan ini sudah diproses.</p>
            </div>

        </div>
    </div>
</div>


{{-- ════════════════════════════════════════════════════════════
     DATA JSON untuk JS
════════════════════════════════════════════════════════════ --}}
<script>
const requestsData = @json($requestsJson);

const colorClass = {
    orange : 'bg-orange-50 text-orange-600 border-orange-100',
    blue   : 'bg-blue-50 text-blue-600 border-blue-100',
    green  : 'bg-green-50 text-green-600 border-green-100',
    red    : 'bg-red-50 text-red-500 border-red-100',
    slate  : 'bg-slate-50 text-slate-500 border-slate-100',
};

function openDetail(id) {
    const r = requestsData.find(x => x.id === id);
    if (!r) return;

    document.getElementById('modalNama').textContent    = r.nama;
    document.getElementById('modalNip').textContent     = 'NIP ' + r.nip;
    document.getElementById('modalDivisi').textContent  = r.divisi;
    document.getElementById('modalTanggal').textContent = r.tanggal;

    // Status badge
    const sb = document.getElementById('modalStatusBadge');
    sb.className = 'px-4 py-1.5 rounded-full border text-[9px] font-black uppercase tracking-widest ' + (colorClass[r.badgeColor] || colorClass.slate);
    sb.textContent = r.badgeLabel;

    // Catatan HR
    const cw = document.getElementById('modalCatatanWrap');
    if (r.catatan_hr) {
        cw.classList.remove('hidden');
        document.getElementById('modalCatatan').textContent = r.catatan_hr;
    } else {
        cw.classList.add('hidden');
    }

    // Token expiry (disetujui)
    const tw = document.getElementById('modalTokenWrap');
    if (r.status === 'disetujui' && r.token_expiry) {
        tw.classList.remove('hidden');
        document.getElementById('modalTokenExpiry').textContent = r.token_expiry;
    } else {
        tw.classList.add('hidden');
    }

    // Form aksi: hanya tampil kalau pending
    const fw   = document.getElementById('modalFormWrap');
    const done = document.getElementById('modalDone');
    if (r.status === 'pending') {
        fw.classList.remove('hidden');
        done.classList.add('hidden');
        document.getElementById('btnApprove').setAttribute('formaction', r.approveUrl);
        document.getElementById('btnReject').setAttribute('formaction', r.rejectUrl);
    } else {
        fw.classList.add('hidden');
        done.classList.remove('hidden');
    }

    document.getElementById('detailModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeDetail() {
    document.getElementById('detailModal').classList.add('hidden');
    document.body.style.overflow = '';
}

function copyLink() {
    const text = document.getElementById('resetLink').textContent;
    navigator.clipboard.writeText(text).then(() => {
        const btn = event.target.closest('button');
        btn.textContent = '✓ Tersalin!';
        btn.classList.replace('bg-blue-600', 'bg-green-600');
        setTimeout(() => {
            btn.innerHTML = '<i class="fas fa-copy mr-1"></i> Salin';
            btn.classList.replace('bg-green-600', 'bg-blue-600');
        }, 2000);
    });
}

// Escape key tutup modal
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeDetail(); });
</script>

@endsection