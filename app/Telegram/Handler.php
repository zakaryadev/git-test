<?php

namespace App\Telegram;

use App\Models\User;
use DefStudio\Telegraph\Facades\Telegraph;
use DefStudio\Telegraph\Handlers\WebhookHandler;
use DefStudio\Telegraph\Keyboard\Button;
use DefStudio\Telegraph\Keyboard\Keyboard;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Stringable;

class Handler extends WebHookHandler
{
	public function hello(string $name): void
	{
		$this->reply('Hello ' . $name . '!');
	}

	public function start(): void
	{
		$user = User::all();
		$this->reply($user);
	}

    public function help(): void
    {
        $users = User::paginate(1);

        Telegraph::message('## ASD \n' . $users->currentPage() . ' of ' . $users->lastPage())
            ->keyboard(Keyboard::make()->buttons([
                Button::make("<<")->action('prev_page')->params([
                    'page' => $users->currentPage() - 1,
                ]),
                Button::make(">>")->action('next_page')->params([
                    'page' => $users->currentPage() + 1,
                ]),
            ]))->send();
    }

	public function izlew(string $name): void
	{
		$user = User::all()->first();
		$this->reply('String: ' . $name);
	}

	protected function handleChatMessage(Stringable $text): void
    {
        Log::info(json_encode($this->message->toArray(), JSON_UNESCAPED_UNICODE));
    }
}
