
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Kafka 集成</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
<div class="min-h-screen flex flex-col">
    <header class="bg-indigo-600 text-white p-4 shadow-lg">
        <div class="container mx-auto">
            <h1 class="text-2xl font-bold">Laravel Kafka 集成</h1>
            <p class="text-indigo-200">生产者和消费者示例</p>
        </div>
    </header>

    <main class="flex-grow container mx-auto p-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- 生产者面板 -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4 text-gray-800">
                    <i class="fas fa-paper-plane mr-2 text-indigo-600"></i>消息生产者
                </h2>

                <form id="producer-form" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">主题</label>
                        <input type="text" id="topic" name="topic" value="{{ config('kafka.topics.default') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">消息键 (可选)</label>
                        <input type="text" id="key" name="key"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">消息内容</label>
                        <textarea id="message" name="message" rows="4" required
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
                    </div>

                    <button type="submit"
                            class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 transition duration-300 flex items-center justify-center">
                        <i class="fas fa-paper-plane mr-2"></i>发送消息
                    </button>
                </form>

                <div id="producer-result" class="mt-4 hidden p-3 rounded-md"></div>
            </div>

            <!-- 消费者面板 -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4 text-gray-800">
                    <i class="fas fa-inbox mr-2 text-green-600"></i>消息
