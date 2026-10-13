<?php

namespace App\Controllers;

use App\Services\UfkaApiService;

/**
 * Ufyo AI Sohbet Botu Controller
 * Bot tamamen merkezi REST API (getBotKnowledge ve askBot) üzerinden çalışır.
 */
class Bot extends BaseController
{
    protected UfkaApiService $api;

    public function __construct()
    {
        $this->api = new UfkaApiService();
    }

    /**
     * Bot ayarlarını ve hızlı soru çiplerini döner
     * GET /bot/knowledge
     */
    public function knowledge()
    {
        $data = $this->api->getBotKnowledge(true);

        if (!$data || !is_array($data)) {
            return $this->response->setJSON([
                'status'         => false,
                'bot'            => [
                    'name'             => 'Ufyo AI Asistan',
                    'subtitle'         => 'Yapay Zeka Destek Sistemi',
                    'avatar_url'       => 'assets/images/icon6.png',
                    'bubble_text'      => 'Sorularını<br>sorabilirsin!',
                    'greeting_message' => 'Merhaba! Ben Ufka Yolculuk yapay zeka rehberiniz <strong>Ufyo</strong> 🤖',
                    'fallback_message' => 'Sorunuz için teşekkür ederim! Detaylı bilgi için menülerimizi inceleyebilirsiniz.',
                    'is_active'        => true
                ],
                'quick_chips'    => [],
                'knowledge_base' => []
            ]);
        }

        return $this->response->setJSON($data);
    }

    /**
     * Kullanıcı sorusunu alır ve bot cevabını döner
     * POST /bot/ask
     */
    public function ask()
    {
        $question = '';

        // 1. Standart Form POST veya GET parametreleri
        $rawPost = $this->request->getPost('question');
        $rawGet = $this->request->getGet('question');
        $rawVar = $this->request->getVar('question') ?: $this->request->getVar('q') ?: $this->request->getVar('message');

        if (!empty($rawPost)) {
            $question = (string)$rawPost;
        } elseif (!empty($rawGet)) {
            $question = (string)$rawGet;
        } elseif (!empty($rawVar)) {
            $question = (string)$rawVar;
        }

        // 2. JSON gövde ile istek geldiyse güvenli şekilde ayrıştır
        if (empty($question)) {
            $body = (string)$this->request->getBody();
            if (!empty($body) && (str_starts_with(trim($body), '{') || str_contains((string)$this->request->getHeaderLine('Content-Type'), 'json'))) {
                try {
                    $json = json_decode($body, true);
                    if (is_array($json)) {
                        $question = $json['question'] ?? ($json['q'] ?? ($json['message'] ?? ''));
                    }
                } catch (\Throwable $e) {
                    // JSON parse hatası yoksayılır
                }
            }
        }

        // 3. Fallback: $_POST / $_GET süper globalleri
        if (empty($question)) {
            $question = $_POST['question'] ?? ($_GET['question'] ?? ($_POST['q'] ?? ($_GET['q'] ?? '')));
        }

        $question = trim((string)$question);

        if (empty($question)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status'  => false,
                'code'    => 400,
                'message' => 'Lütfen bir soru belirtiniz.'
            ]);
        }

        $res = $this->api->askBot($question);
        return $this->response->setJSON($res);
    }
}
