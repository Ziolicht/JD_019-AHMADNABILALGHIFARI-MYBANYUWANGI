<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EventController extends Controller
{
    /**
     * Tampilkan daftar event untuk halaman utama (public).
     */
    public function index(Request $request)
    {
        $query = Event::query();

        // Filter pencarian judul
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Filter kategori
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter status (aktif / selesai)
        if ($request->filled('status')) {
            if ($request->status === 'aktif') {
                $query->where('ends_at', '>=', now());
            } elseif ($request->status === 'selesai') {
                $query->where('ends_at', '<', now());
            }
        }

        // Sorting
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'az':
                    $query->orderBy('title', 'asc');
                    break;
                case 'za':
                    $query->orderBy('title', 'desc');
                    break;
                case 'date_asc':
                    $query->orderBy('starts_at', 'asc');
                    break;
                case 'date_desc':
                    $query->orderBy('starts_at', 'desc');
                    break;
            }
        }

        $events = $query->orderBy('starts_at')->get();

        // Ambil data event
        $events = $query->paginate(9);

        // Ambil daftar kategori unik
        $categories = Event::select('category')->distinct()->pluck('category');

        return view('events.index', compact('events', 'categories'));
    }

    /**
     * Tampilkan daftar event untuk halaman "Lihat Semua".
     */
    public function list(Request $request)
    {
        $query = Event::query();

        // Filter pencarian judul
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Filter kategori
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter status (aktif / selesai)
        if ($request->filled('status')) {
            if ($request->status === 'aktif') {
                $query->where('ends_at', '>=', now());
            } elseif ($request->status === 'selesai') {
                $query->where('ends_at', '<', now());
            }
        }

        if ($request->has('date')) {
            $date = Carbon::parse($request->date);
            $query->whereDate('starts_at', $date);
        }


        // Sorting
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'az':
                    $query->orderBy('title', 'asc');
                    break;
                case 'za':
                    $query->orderBy('title', 'desc');
                    break;
                case 'date_asc':
                    $query->orderBy('starts_at', 'asc');
                    break;
                case 'date_desc':
                    $query->orderBy('starts_at', 'desc');
                    break;
            }
        }

        $events = $query->paginate(9);
        $categories = Event::select('category')->distinct()->pluck('category');

        return view('events.eventspage', compact('events', 'categories'));
    }

    /**
     * Tampilkan detail event.
     */
    public function show(Event $event)
    {
        abort_unless($event->is_published || (Auth::check() && Auth::user()->is_admin), 404);

        return view('events.show', compact('event'));
    }

    /**
     * Form tambah event (admin).
     */
    public function create()
    {
        return view('events.create');
    }

    /**
     * Simpan event baru ke database.
     */
    public function store(Request $request)
    {
        $data = $request->validate(
            [
                'title'             => ['required', 'string', 'max:255'],
                'slug'              => ['nullable', 'string', 'max:255', 'unique:events,slug'],
                'description'       => ['nullable', 'string'],
                'category'          => ['nullable', 'string', 'max:100'],
                'location'          => ['nullable', 'string', 'max:255'],
                'starts_at'         => ['required', 'date'],
                'ends_at'           => ['nullable', 'date', 'after_or_equal:starts_at'],
                'contact_whatsapp'  => ['nullable', 'string', 'max:30'],
                'image'             => ['nullable', 'image', 'max:2048'],
                'is_published'      => ['nullable', 'boolean'],
            ],
            [
                'ends_at.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai.',
            ]
        );


        // Upload gambar jika ada
        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('events', 'public');
        }

        $data['created_by'] = Auth::id();
        $data['is_published'] = $request->boolean('is_published', true);

        $event = Event::create($data);

        return redirect()->route('events.show', $event)->with('success', 'Event berhasil dibuat.');
    }

    /**
     * Form edit event.
     */
    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    /**
     * Update event.
     */
    public function update(Request $request, Event $event)
    {
        $data = $request->validate(
            [
                'title'             => ['required', 'string', 'max:255'],
                'slug'              => ['nullable', 'string', 'max:255', Rule::unique('events', 'slug')->ignore($event->id)],
                'description'       => ['nullable', 'string'],
                'category'          => ['nullable', 'string', 'max:100'],
                'location'          => ['nullable', 'string', 'max:255'],
                'starts_at'         => ['required', 'date'],
                'ends_at'           => ['nullable', 'date', 'after_or_equal:starts_at'],
                'contact_whatsapp'  => ['nullable', 'string', 'max:30'],
                'image'             => ['nullable', 'image', 'max:2048'],
                'is_published'      => ['nullable', 'boolean'],
            ],
            [
                'ends_at.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai.',
            ]
        );

        // Hapus gambar lama jika ada gambar baru
        if ($request->hasFile('image')) {
            if ($event->image_path) {
                Storage::disk('public')->delete($event->image_path);
            }
            $data['image_path'] = $request->file('image')->store('events', 'public');
        }

        $data['is_published'] = $request->boolean('is_published', true);

        $event->update($data);

        return redirect()->route('events.show', $event)->with('success', 'Event diperbarui.');
    }

    /**
     * Hapus event.
     */
    public function destroy(Event $event)
    {
        if ($event->image_path) {
            Storage::disk('public')->delete($event->image_path);
        }

        $event->delete();

        return redirect()->route('events.index')->with('success', 'Event dihapus.');
    }

public function calendar($year = null, $month = null)
{
    $now = Carbon::now();

    // Jika tidak ada parameter, pakai bulan sekarang
    $current = Carbon::createFromDate($year ?? $now->year, $month ?? $now->month, 1);

    // Awal & akhir kalender (mulai dari Senin minggu pertama, sampai Minggu terakhir)
    $startOfMonth = $current->copy()->startOfMonth()->startOfWeek(Carbon::MONDAY);
    $endOfMonth = $current->copy()->endOfMonth()->endOfWeek(Carbon::SUNDAY);

    // Generate daftar tanggal
    $dates = collect();
    for ($date = $startOfMonth->copy(); $date->lte($endOfMonth); $date->addDay()) {
        $dates->push($date->copy());
    }

    // Ambil semua event dalam rentang ini
    $events = Event::whereBetween('starts_at', [$startOfMonth, $endOfMonth])
        ->orWhereBetween('ends_at', [$startOfMonth, $endOfMonth])
        ->get();

    // Data untuk navigasi
    $prevMonth = $current->copy()->subMonth();
    $nextMonth = $current->copy()->addMonth();

    return view('events.calendar', compact('dates', 'events', 'current', 'prevMonth', 'nextMonth'));
}

}
