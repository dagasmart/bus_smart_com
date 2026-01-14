<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use App\Services\KafkaService;

class KafkaController extends AdminController
{
    protected KafkaService $kafkaService;

    public function __construct(KafkaService $kafkaService)
    {
        parent::__construct();
        $this->kafkaService = $kafkaService;
    }

    public function produce(Request $request)
    {
        $topic = $request->input('topic', config('kafka.topics.default'));
        $message = $request->input('message');
        $key = $request->input('key');

        if (!$message) {
            return response()->json(['error' => '消息不能为空'], 400);
        }

        try {
            $this->kafkaService->produceMessage($topic, $message, $key);
            return response()->json(['status' => 'success', 'message' => '消息已发送']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
