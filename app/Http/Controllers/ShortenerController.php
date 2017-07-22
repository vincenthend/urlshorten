<?php

namespace App\Http\Controllers;

use App\UrlTable;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

class ShortenerController extends Controller
{
    const defaultUrlLength = 4;

    /**
     * Mencari URL panjang dari URL pendek.
     * @param $shortUrl String URL pendek yang dicari
     * @return mixed|null URL panjang jika ditemukan, null jika tidak.
     */
    private static function findUrl($shortUrl) {
        $urlData = UrlTable::find($shortUrl);

        if ($urlData == null) {
            $returnData = null;
        } else {
            $returnData = $urlData->longUrl;
        }
        return $returnData;
    }

    /**
     * Menghasilkan URL yang sudah dipendekkan.
     * @param $url String URL yang akan dipendekkan
     * @return string hasil URL yang dipendekkan
     */
    public function shortenUrl(Request $request) {
        $url = $request->input('url');
        //Cek apakah URL sudah memiliki protokol. Beri protokol bila belum.
        if (preg_match('/(https?:\/\/).*/', $url) == 0) {
            $url = 'http://' . $url;
        }

        //Lakukan hashing pada URL
        $hashedURL = hash("md5", $url);

        //Lakukan hash pada URL
        $urlLength = ShortenerController::defaultUrlLength;
        $shortenedURL = substr($hashedURL, 0, $urlLength);

        //Cari hasil hash pada database, jika ditemukan perpanjang $urlLength
        $findResult = ShortenerController::findUrl($shortenedURL);
        while ($findResult != $url && $findResult != null) {
            $urlLength++;
            $shortenedURL = substr($hashedURL, 0, $urlLength);
            $findResult = ShortenerController::findUrl($shortenedURL);
        }

        //Masukkan hasil hash pada database
        if ($findResult == null) {
            $data = new UrlTable;
            $data->shortenedUrl = $shortenedURL;
            $data->longUrl = $url;
            $data->save();
        }

        return response()->json(['shortUrl' => $shortenedURL]);
    }

    public function unshortenUrl($url){
        $longUrl = ShortenerController::findUrl($url);
        if ($longUrl == null){
            //Return 404 page
        }
        else{
            return Redirect::to($longUrl);
        }
    }
}