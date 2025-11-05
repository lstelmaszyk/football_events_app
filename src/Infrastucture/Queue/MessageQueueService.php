<?php


namespace App\Infrastucture\Queue;


use Enqueue\Fs\FsConnectionFactory;
use Interop\Queue\Consumer;
use Interop\Queue\Context;
use Interop\Queue\Message;
use Interop\Queue\Producer;
use Interop\Queue\Queue;

class MessageQueueService
{
    private Context $context;
    private Queue $queue;
    private Producer $producer;
    private Consumer $consumer;

    public function __construct(
        string $filePath,
        string $queueName,
    ) {
        $this->context = $this->createContext($filePath);
        $this->queue = $this->context->createQueue($queueName);
        $this->producer = $this->context->createProducer();
        $this->consumer = $this->context->createConsumer($this->queue);
    }

    public function sendMessage(string $messageBody): void
    {
        $message = $this->context->createMessage($messageBody);
        $this->producer->send($this->queue, $message);
    }

    public function consumeMessage(): ?Message
    {
        return $this->consumer->receive();
    }

    public function acknowledgeMessage(Message $message): void
    {
        $this->consumer->acknowledge($message);
    }

    public function rejectMessage(Message $message): void
    {
        $this->consumer->reject($message);
    }

    private function createContext(string $filePath): Context
    {
        $connectionFactory = new FsConnectionFactory($filePath);
        return $connectionFactory->createContext();
    }
}
