<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShipmentRequest extends FormRequest
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
            'student_id' => 'required|integer|exists:students,id',
            'shipment_id' => 'nullable|integer|exists:shipments,id',
            'document_ids' => 'required|array',
            'document_ids.*' => 'integer|exists:documents,id',
            'tracking_id' => 'required|string|max:255',
            'shipping_agent' => 'required|string|max:255',
            'shipping_address' => 'required|string|max:255',
            'dispatched_at' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'delivery_status' => 'required|string|in:shipped,delivered',
            'delivered_at' => 'nullable|date',
        ];
    }
}
