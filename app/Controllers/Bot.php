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
        $rawPost = $this->request->getPost('question') ?: $this->request->getGet('question');
        $rawVar = $this->request->getVar('question') ?: $this->request->getVar('q') ?: $this->request->getVar('message');
        $json = $this->request->getJSON(true);
        $jsonQ = (is_array($json) && isset($json['question'])) ? $json['question'] : null;
        $superQ = isset($_POST['question']) ? $_POST['question'] : (isset($_GET['question']) ? $_GET['question'] : null);

        $question = trim((string)($rawPost ?: ($rawVar ?: ($jsonQ ?: ($superQ ?: '')))));

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
