<?php

namespace App\Http\Controllers;

use App\Models\ParsBase;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\DomCrawler\Crawler;

require '/Users/onyx/Laravel/parsing/vendor/autoload.php';

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function Get()
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
        $img = $doc->filter('.card-big__image')->attr('src');
        $extracted = [];
        $extractedDate = [];
        // $extractedImg = [];
        $i = 0;

        foreach($date as $dat)
        {
            $extractedDate[] = $dat->textContent;
        }

        // foreach((array)$img as $val)
        // {
        //     $extractedImg[] = $val; 
        // }

        // var_dump($extractedImg);

        foreach ($titles as $title) {
            $extracted[] = ['text' => $title->textContent, 'date' => $extractedDate[$i], 'created_at' => Carbon::now(), 'img' => $img];
            
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

        return view('home', ['post_l' => $post_left, 'post_r' => $arr, 'j' => $j, 'img' => $img]);

    }

    public function Search(Request $request)
    {
        $s = $request->s;

        $post = ParsBase::where('text', 'LIKE', "%{$s}%")->paginate(10);
        $post_right = ParsBase::orderBy('text')->limit(10)->paginate(10);
        $img = ParsBase::where('img')->get('img');
        $j = 0;

        return view('home', ['post_l' => $post, 'post_r' => $post_right, 'j' => $j, 'img' => $img]);
    }
}
