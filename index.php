<?php
require_once('vendor/autoload.php');

use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Cache\DoctrineCache;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use BotMan\Drivers\CiscoSpark\CiscoSparkDriver;
use Doctrine\Common\Cache\FilesystemCache;
use Dotenv\Dotenv;
use App\Conversations\Beer;

$dotenv = new Dotenv(__DIR__);
$dotenv->load();

// Explicitly load Cisco Spark driver
DriverManager::loadDriver(CiscoSparkDriver::class);

$cache = __DIR__ . '/cache/';
if (!is_dir($cache)) {
	mkdir($cache, 0777);
}
$cacheDriver = new FilesystemCache('cache');

$botman = BotManFactory::create([
	'cisco-spark' => [
		'token' => getenv('CISCO_SPARK_TOKEN')
	]
], new DoctrineCache($cacheDriver));

// Conversations
$botman->hears('beer', function($bot) {
	$bot->startConversation(new Beer());
});

$botman->listen();
