<?php

namespace App\Http\Requests\Payment;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Payment Create Request
 *
 * Validates data for displaying the payment form
 */
class CreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'event_id' => 'required|exists:events,id',
            'ticket_category_id' => 'required|exists:ticket_categories,id',
            'seats' => 'nullable|array',
            'seats.*' => 'exists:seats,id',
        ];
    }

    public function messages(): array
    {
        return [
            'event_id.required' => 'Etkinlik seçilmelidir.',
            'event_id.exists' => 'Seçilen etkinlik bulunamadı.',
            'ticket_category_id.required' => 'Bilet kategorisi seçilmelidir.',
            'ticket_category_id.exists' => 'Seçilen bilet kategorisi bulunamadı.',
            'seats.array' => 'Koltuk bilgileri geçersiz.',
            'seats.*.exists' => 'Seçilen koltuk bulunamadı.',
        ];
    }
}
