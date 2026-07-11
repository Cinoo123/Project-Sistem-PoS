<div class="p-6 max-w-7xl mx-auto">
    <div class="mb-4">
        <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:underline font-semibold flex items-center gap-1">
            ⬅️ Kembali ke Dashboard Admin
        </a>
    </div>

    <h1 class="text-2xl font-bold text-gray-800 mb-6">Kelola Menu Restoran</h1>

    @if (session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-800 p-3 rounded-lg mb-6 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white p-6 rounded-xl shadow-md border border-gray-100 mb-8">
        <h3 class="text-lg font-bold text-gray-700 mb-4">Tambah Menu Burger / Minuman Baru</h3>
        <form wire:submit.prevent="saveMenu" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-600">Nama Makanan/Minuman</label>
                <input type="text" wire:model="name" class="w-full border rounded-lg p-2.5 mt-1 focus:ring-2 focus:ring-blue-500" placeholder="Contoh: Crispy Chicken Burger">
                @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-600">Harga (Rp)</label>
                <input type="number" wire:model="price" class="w-full border rounded-lg p-2.5 mt-1 focus:ring-2 focus:ring-blue-500" placeholder="28000">
                @error('price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-600">Kategori</label>
                <select wire:model="category" class="w-full border rounded-lg p-2.5 mt-1 focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Pilih Kategori --</option>
                    <option value="burger">Burger</option>
                    <option value="drinks">Drinks (Minuman)</option>
                    <option value="sides">Sides (Cemilan)</option>
                </select>
                @error('category') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-600">Tautan Gambar (URL Teks)</label>
                <input type="url" wire:model="image_url" class="w-full border rounded-lg p-2.5 mt-1 focus:ring-2 focus:ring-blue-500" placeholder="https://link-foto.com/burger.jpg">
                @error('image_url') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div class="md:col-span-4 text-right mt-2">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg font-bold hover:bg-blue-700 transition shadow">
                    💾 Simpan Menu Baru
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-gray-700 font-semibold">
                    <th class="p-4">Foto</th>
                    <th class="p-4">Nama Menu</th>
                    <th class="p-4">Kategori</th>
                    <th class="p-4">Harga</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-gray-600">
                @forelse($menus as $menu)
                    <tr class="hover:bg-gray-50/80 transition">
                        <td class="p-4"><img src="{{ $menu->image_url }}" class="w-12 h-12 object-cover rounded-xl shadow-sm border"></td>
                        <td class="p-4 font-bold text-gray-800">{{ $menu->name }}</td>
                        <td class="p-4"><span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-600">{{ ucfirst($menu->category) }}</span></td>
                        <td class="p-4 font-semibold text-gray-700">Rp {{ number_format($menu->price, 0, ',', '.') }}</td>
                        <td class="p-4 text-center">
                            <button wire:click="deleteMenu({{ $menu->id }})" onclick="confirm('Apakah Anda yakin ingin menghapus menu ini?') || event.stopImmediatePropagation()" class="text-red-500 font-bold hover:text-red-700 transition hover:underline">
                                🗑️ Hapus
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-gray-400 italic">Belum ada menu makanan yang terdaftar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>