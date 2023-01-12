<?php


namespace App\Http\Helpers;
use GuzzleHttp;


class PositiveQuotesHelper
{
    const QUOTES = [
        [ 'author' =>'Elbert Hubbard','text'=> 'Positive anything is better than negative nothing'],
        ['author' =>'Bernhard Berenson','text'=> 'Miracles happen to those who believe in them'],
        ['author' =>'Zig Ziglar', 'text'=> 'One small positive thought can change your whole day.'],
        ['author' =>'Teddy Roosevelt', 'text'=> 'Believe you can and you’re halfway there.'],
        ['author' =>'Roy T. Bennett', 'text'=> 'Be positive. Be true. Be kind.'],
        ['author' =>'Widad Akrawi', 'text'=> 'If you are positive, you’ll see opportunities instead of obstacles.'],
        ['author' =>'Ralph Waldo Emerson', 'text'=> 'Write it on your heart that every day is the best day in the year.'],
        ['author' =>'Bing Crosby', 'text'=> 'Accentuate the positive, Eliminate the Negative, latch onto the affirmative.'],
    ];
    public static function getQuoteForTheDay()
    {
        $key = array_rand(SELF::QUOTES);
        $quote = '<p class="card-text font-small-3">' .  self::QUOTES[$key]['text'] . '</p>
                    <p class="card-text font-small-3 float-sm-right">"' .  self::QUOTES[$key]['author'] . '" </p>';
       
        try {
            $httpClient = new GuzzleHttp\Client();
            $request =
                $httpClient
                    ->get("https://type.fit/api/quotes",[
                        'headers' => [
                            'Content-Type' => 'application/json'
                        ]]);

            if (isset($request) && $request->getStatusCode() == 200) {
                $response = json_decode($request->getBody()->getContents());
                if (! empty($response)) {
                    $key = array_rand($response);
                    $quote = '<p class="card-text font-small-3" style="width: 80%;">' .  $response[$key]->text . '</p>
                        <p class="card-text font-small-3 float-sm-right">- "' .  $response[$key]->author . '" </p>';
                }
            }
        } catch (\Exception $e) {
            $key = array_rand(SELF::QUOTES);
            $quote = '<p class="card-text font-small-3">' .  self::QUOTES[$key]['text'] . '</p>
                        <p class="card-text font-small-3 float-sm-right">"' .  self::QUOTES[$key]['author'] . '" </p>';
            
        }
        return $quote;
    }

}
