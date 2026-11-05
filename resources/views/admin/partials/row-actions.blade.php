{{--
    Tombol aksi baris yang seragam untuk semua tabel admin.
    Parameter: $show (url|null), $edit (url|null), $delete (url|null), $confirm (teks konfirmasi hapus)
--}}
<div class="flex items-center justify-end gap-1.5">
    @if(!empty($show))
        <a href="{{ $show }}" title="Lihat detail" aria-label="Lihat detail"
           class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-[#253D4E] hover:bg-gray-100 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.5 12C3.8 7.9 7.6 5 12 5s8.2 2.9 9.5 7c-1.3 4.1-5.1 7-9.5 7s-8.2-2.9-9.5-7z"/></svg>
        </a>
    @endif
    @if(!empty($edit))
        <a href="{{ $edit }}" class="inline-flex items-center gap-1 h-8 px-3 rounded-lg bg-[#DEF9EC] text-[#3BB77E] hover:bg-[#3BB77E] hover:text-white text-xs font-bold transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.2 5.2l3.6 3.6M4 20l4.2-1 10.3-10.3a2.5 2.5 0 00-3.6-3.6L4.6 15.4 4 20z"/></svg>
            Edit
        </a>
    @endif
    @if(!empty($delete))
        <form method="POST" action="{{ $delete }}" onsubmit="return confirm(@js($confirm ?? 'Yakin ingin menghapus data ini?'))">
            @csrf
            @method('DELETE')
            <button type="submit" title="Hapus" aria-label="Hapus"
                    class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 text-gray-400 hover:text-white hover:bg-[#F74B81] hover:border-[#F74B81] transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.9 12.1A2 2 0 0116.1 21H7.9a2 2 0 01-2-1.9L5 7m5 4v6m4-6v6M4 7h16M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3"/></svg>
            </button>
        </form>
    @endif
</div>
