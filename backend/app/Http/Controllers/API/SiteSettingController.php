<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateFooterSettingsRequest;
use App\Models\SiteSetting;
use Illuminate\Http\JsonResponse;

class SiteSettingController extends Controller {
    private const FOOTER_KEY = 'footer_settings';

    public function footer(): JsonResponse {
        $defaults = $this->defaultFooterSettings();
        $record = SiteSetting::where('key', self::FOOTER_KEY)->first();

        if (!$record) {
            return response()->json($defaults);
        }

        $value = json_decode($record->value ?? '', true);
        if (!is_array($value)) {
            $value = [];
        }

        return response()->json(array_replace_recursive($defaults, $value));
    }

    public function updateFooter(UpdateFooterSettingsRequest $request): JsonResponse {
        $payload = $this->normalizePayload($request->validated());

        SiteSetting::updateOrCreate(
            ['key' => self::FOOTER_KEY],
            [
                'value' => json_encode($payload, JSON_UNESCAPED_UNICODE),
                'type' => 'json',
                'group' => 'footer',
            ]
        );

        return response()->json([
            'message' => 'Configuración del footer actualizada correctamente.',
            'data' => $payload,
        ]);
    }

    private function normalizePayload(array $data): array {
        $data['social_links'] = collect($data['social_links'] ?? [])
            ->map(function ($link) {
                return [
                    'label' => trim($link['label'] ?? ''),
                    'url' => trim($link['url'] ?? ''),
                ];
            })
            ->filter(function ($link) {
                return $link['label'] !== '' || $link['url'] !== '';
            })
            ->values()
            ->all();

        return array_replace_recursive($this->defaultFooterSettings(), $data);
    }

    private function defaultFooterSettings(): array {
        return [
            'slogan' => 'Transformando ideas en realidad digital desde 2013',
            'email' => 'info@penacom.com',
            'phone' => '+1 (555) 123-4567',
            'location' => 'Ciudad, País 12345',
            'whatsapp_number' => '529985401540',
            'whatsapp_message' => 'Hola, me gustaría obtener más información sobre sus servicios.',
            'social_links' => [
                ['label' => 'Facebook', 'url' => 'https://facebook.com/penacom'],
                ['label' => 'Twitter', 'url' => 'https://twitter.com/penacom'],
                ['label' => 'LinkedIn', 'url' => 'https://linkedin.com/company/penacom'],
                ['label' => 'Instagram', 'url' => 'https://instagram.com/penacom'],
            ],
        ];
    }
}
