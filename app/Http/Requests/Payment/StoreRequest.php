<?php

namespace App\Http\Requests\Payment;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Payment Store Request
 *
 * Validates payment submission data including customer and credit card information
 */
class StoreRequest extends FormRequest
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
            'customer_name' => 'required|string|max:255',
            'customer_surname' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'cc_number' => 'required|string|size:16',
            'cc_exp_month' => 'required|string|size:2',
            'cc_exp_year' => 'required|string|size:2',
            'cc_cvv' => 'required|string|size:3',
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
            'customer_name.required' => 'Ad alanı zorunludur.',
            'customer_surname.required' => 'Soyad alanı zorunludur.',
            'customer_email.required' => 'E-posta adresi zorunludur.',
            'customer_email.email' => 'Geçerli bir e-posta adresi giriniz.',
            'customer_phone.required' => 'Telefon numarası zorunludur.',
            'customer_phone.regex' => 'Telefon numarası sadece rakamlardan oluşmalıdır.',
            'cc_number.required' => 'Kart numarası zorunludur.',
            'cc_number.size' => 'Kart numarası 16 haneli olmalıdır.',
            'cc_number.regex' => 'Kart numarası sadece rakamlardan oluşmalıdır.',
            'cc_exp_month.required' => 'Son kullanma ayı zorunludur.',
            'cc_exp_month.size' => 'Ay 2 haneli olmalıdır.',
            'cc_exp_month.regex' => 'Geçerli bir ay giriniz (01-12).',
            'cc_exp_year.required' => 'Son kullanma yılı zorunludur.',
            'cc_exp_year.size' => 'Yıl 2 haneli olmalıdır.',
            'cc_exp_year.regex' => 'Geçerli bir yıl giriniz.',
            'cc_cvv.required' => 'CVV kodu zorunludur.',
            'cc_cvv.size' => 'CVV 3 haneli olmalıdır.',
            'cc_cvv.regex' => 'CVV sadece rakamlardan oluşmalıdır.',
        ];
    }
}
