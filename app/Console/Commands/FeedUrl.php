<?php

namespace App\Console\Commands;

use App\Category;
use App\Feed;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class FeedUrl extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'feedUrl {url} {logFile}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private $categoryModel;

    private $allowLogFileList = ['feed_log_1', 'feed_log_2', 'feed_log_3'];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->categoryModel = new Category();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        exec('php artisan initializeDatabase');
        $logFile = $this->argument('logFile');
        if (!in_array($logFile, $this->allowLogFileList)) {
            $this->error('logFile parameter is only allowed: ' . implode(', ', $this->allowLogFileList));

            return;
        }

        $url = $this->argument('url');

        $listCategory = $this->categoryModel->all();

        $listUrl = explode(',', $url);
        $insertTotal = 0;
        foreach ($listUrl as $url) {
            try {
                $rawContent = file_get_contents($url);
                $content = new \SimpleXMLElement($rawContent);
            } catch (\Exception $exception) {
                $this->error('Url is invalid to get XML data.');

                return;
            }

            if (!empty($content->channel->item)) {
                foreach ($content->channel->item as $item) {
                    $categoryName = $item->category->__toString() ?? '';
                    $categoryID = null;

                    if (!empty($categoryName)) {
                        // Create category if not exist
                        if (empty($listCategory[$categoryName])) {
                            $newCategory = new Category(['title' => $categoryName]);
                            $newCategory->save();
                            $listCategory[$categoryName] = $newCategory->id;
                        }
                        $categoryID = $listCategory[$categoryName];
                    }

                    $title = $item->title->__toString() ?? '';
                    $description = $item->description->__toString() ?? '';
                    $link = $item->link->__toString() ?? '';
                    $comments = $item->comments->__toString() ?? '';
                    $publishDate = $item->pubDate->__toString() ? date('Y-m-d H:i:s', strtotime($item->pubDate->__toString())) : '';

                    // Save new feed
                    $feed = new Feed([
                        'title' => $title,
                        'description' => $description,
                        'link' => $link,
                        'category_id' => $categoryID,
                        'comments' => $comments,
                        'publish_date' => $publishDate,
                    ]);
                    $feed->save();
                    $insertTotal++;

                    // Print result and write log
                    $logTitle = "Insert 1 feed successfully at " . date('Y-m-d H:i:s') . ".\nData:";
                    $logText = "Title: {$title}\nDescription: {$description}\nLink: {$link}\nCategory: {$categoryName}\nComments: {$comments}\nPublish Date: {$publishDate}\n";
                    $this->info($logTitle);
                    $this->line($logText);

                    Log::channel($logFile)->info($logTitle . "\n" . $logText);
                }
            }
        }
        $this->info("Process completed. {$insertTotal} records are inserted.");

        return;
    }
}
