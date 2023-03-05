<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ParsBase;
use Carbon\Carbon;
use Symfony\Component\DomCrawler\Crawler;

class DemoCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        
        ParsBase::whereNotNull('text')->delete();

        mb_internal_encoding('UTF-8');

        $http = new \GuzzleHttp\Client();
        $response = $http->get('https://lenta.ru/rubrics/wellness/');


        $htmlString = (string) $response->getBody();

        libxml_use_internal_errors(true);
        $doc = new Crawler();
        $doc->addHtmlContent($htmlString);
        //$xpath = new DOMXPath($doc);

        $titles = $doc->filter('.card-mini__title');
        $date = $doc->filter('.card-mini__date');
        $extracted = [];
        $extractedDate = [];
        $i = 0;

        foreach($date as $dat)
        {
            $extractedDate[] = $dat->textContent;
        }

        foreach ($titles as $title) {
            $extracted[] = ["text" => $title->textContent, "date" => $extractedDate[$i], "created_at" => Carbon::now()];
            
            $i++;
        }
        ParsBase::insert($extracted);

        $post_left = ParsBase::orderBy('text')->paginate(10);
        $post_right = ParsBase::where('created_at','<', Carbon::now()->addDays(-20))->get();;

        $j = 0;

        $arr = [];

        foreach($post_right as $value){
            if($j < 10){$arr[] = ["text" => $value->text, "date" => $value->date]; $j++;}
            else {break;}
        }
    }
}
