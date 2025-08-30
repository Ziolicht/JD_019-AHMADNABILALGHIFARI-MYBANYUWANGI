@php $editing = isset($event); @endphp
@csrf

@if ($errors->any())
    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-md">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


<div class="grid md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm mb-1">Judul</label>
        <input type="text" name="title" value="{{ old('title', $event->title ?? '') }}"
            class="w-full border rounded-md px-3 py-2" required>
    </div>

    <div>
        <label class="block text-sm mb-1">Slug (opsional)</label>
        <input type="text" name="slug" value="{{ old('slug', $event->slug ?? '') }}"
            class="w-full border rounded-md px-3 py-2">
    </div>

    <div>
        <label class="block text-sm mb-1">Kategori</label>
        <input type="text" name="category" value="{{ old('category', $event->category ?? '') }}"
            placeholder="mis: budaya, olahraga" class="w-full border rounded-md px-3 py-2" required>

    </div>

    <div>
        <label class="block text-sm mb-1">Lokasi (opsional)</label>
        <input type="text" name="location" value="{{ old('location', $event->location ?? '') }}"
            class="w-full border rounded-md px-3 py-2">
    </div>

    <div>
        <label class="block text-sm mb-1">Mulai</label>
        <input type="datetime-local" name="starts_at"
            value="{{ old('starts_at', isset($event) && $event->starts_at ? \Illuminate\Support\Carbon::parse($event->starts_at)->format('Y-m-d\TH:i') : '') }}"
            class="w-full border rounded-md px-3 py-2" required>
    </div>

    <div>
        <label class="block text-sm mb-1">Selesai (opsional)</label>
        <input type="datetime-local" name="ends_at"
            value="{{ old('ends_at', isset($event) && $event->ends_at ? \Illuminate\Support\Carbon::parse($event->ends_at)->format('Y-m-d\TH:i') : '') }}"
            class="w-full border rounded-md px-3 py-2">
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm mb-1">Deskripsi (opsional)</label>
        <textarea name="description" rows="5" class="w-full border rounded-md px-3 py-2">{{ old('description', $event->description ?? '') }}</textarea>
    </div>

    <div>
        <label class="block text-sm mb-1">Kontak WhatsApp (opsional)</label>
        <input type="text" name="contact_whatsapp"
            value="{{ old('contact_whatsapp', $event->contact_whatsapp ?? '') }}"
            class="w-full border rounded-md px-3 py-2">
    </div>

    <div>
        <label class="block text-sm mb-1">Poster / Gambar (opsional)</label>
        <input type="file" name="image" class="w-full border rounded-md px-3 py-2 bg-white">
        @if (isset($event) && $event->image_path)
            <img src="{{ asset('storage/' . $event->image_path) }}" class="mt-2 w-40 rounded-md">
        @endif
    </div>
</div>

<div class="mt-6 flex gap-3">
    <button class="px-4 py-2 bg-indigo-600 text-white rounded-md">
        {{ $editing ? 'Update' : 'Simpan' }}
    </button>
    <a href="{{ $editing ? route('events.show', $event) : route('events.index') }}"
        class="px-4 py-2 border rounded-md">Batal</a>
</div>
