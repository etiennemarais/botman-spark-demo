<?php namespace App\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
	
class Beer extends Conversation
{
	protected $type;
	protected $area;

	public function run()
	{
        $this->ask('What type are you keen for?', function($answer) {
            $this->type = $answer->getText();
            $this->askArea();
		});
    }

    protected function askArea()
    {
        $this->ask('What area are you in?', function($answer) {
            $this->area = $answer->getText();
            $this->respond();
        });
    }

    protected function respond()
    {
        $this->say(sprintf('You can go to %s for %s', 'Taproom', 'Ale'));
    }
}
