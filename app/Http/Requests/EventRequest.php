<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'image' => 'nullable|image|mimes:png,jpg',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'email_content' => 'required|string',
            'location' => 'nullable|string|max:500',
            'capacity' => 'required|integer|min:1',
            'price' => 'nullable|integer|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'has_certificate' => 'required',
            'is_online' => 'required',
            'user' => 'array|required',
            'start' => 'array|required',
            'end' => 'array|required',
            'session' => 'array|required',
            'user.*' => 'required',
            'event_date.*' => 'required',
            'start.*' => 'required',
            'end.*' => 'required',
            'session.*' => 'required',
        ];
    }
    public function messages(): array
    {
        return [
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Gambar harus berformat png atau jpg.',
            'title.required' => 'Judul harus diisi.',
            'title.string' => 'Judul harus berupa teks.',
            'title.max' => 'Judul tidak boleh lebih dari 255 karakter.',
            'description.required' => 'Deskripsi harus diisi.',
            'description.string' => 'Deskripsi harus berupa teks.',
            'email_content.required' => 'Konten email harus diisi.',
            'email_content.string' => 'Konten email harus berupa teks.',
            'description.max' => 'Deskripsi tidak boleh lebih dari 500 karakter.',
            'location.required' => 'Lokasi harus diisi.',
            'location.string' => 'Lokasi harus berupa teks.',
            'location.max' => 'Lokasi tidak boleh lebih dari 500 karakter.',
            'capacity.required' => 'Kapasitas harus diisi.',
            'capacity.integer' => 'Kapasitas harus berupa angka.',
            'capacity.min' => 'Kapasitas harus minimal 1.',
            'price.required' => 'Harga harus diisi.',
            'price.integer' => 'Harga harus berupa angka.',
            'price.min' => 'Harga harus minimal 1.',
            'start_date.required' => 'Tanggal mulai harus diisi.',
            'start_date.date' => 'Tanggal mulai harus berupa tanggal yang valid.',
            'end_date.required' => 'Tanggal berakhir harus diisi.',
            'end_date.date' => 'Tanggal berakhir harus berupa tanggal yang valid.',
            'has_certificate.required' => 'Status sertifikat harus diisi.',
            'is_online.required' => 'Status online harus diisi.',
            'user.*.required' => 'Pembawa acara wajib diisi',
            'event_date.*.required' => 'Tanggal acara wajib diisi',
            'start.*.required' => 'Waktu mulai wajib diisi',
            'end.*.required' => 'Waktu berakhir wajib diisi',
            'session.*.required' => 'Sesi wajib diisi',
        ];
    }
}
