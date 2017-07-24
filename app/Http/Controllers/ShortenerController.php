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
     * Menyimpan data longUrl dan shortUrl pada database. Prekondisi shortUrl tersedia
     * @param $longUrl string URL asli
     * @param $shortUrl string URL hasil pemendekan dari URL asli
     * @return int 1 jika data berhasil di save, 0 jika tidak (sudah ada shortLink)
     */
    private static function saveUrl($longUrl, $shortUrl) {
        $data = new UrlTable;
        $data->shortenedUrl = $shortUrl;
        $data->longUrl = $longUrl;
        $data->save();
    }

    /**
     * Menghasilkan URL yang sudah dipendekkan.
     * @param $url String URL yang akan dipendekkan
     * @return string hasil URL yang dipendekkan
     */
    public function shortenUrl(Request $request) {
        $longUrl = $request->input('url');
        //Cek apakah URL sudah memiliki protokol. Beri protokol bila belum.
        if (preg_match('/(https?:\/\/).*/', $longUrl) == 0) {
            $longUrl = 'http://' . $longUrl;
        }

        //Lakukan hashing pada URL
        $hashedUrl = hash("md5", $longUrl);

        //Lakukan pemendekan pada hasil hash
        $urlLength = ShortenerController::defaultUrlLength;
        $shortenedUrl = substr($hashedUrl, 0, $urlLength);

        //Cari hasil hash pada database, jika ditemukan perpanjang hasil hash
        $findResult = ShortenerController::findUrl($shortenedUrl);
        while ($findResult != $longUrl && $findResult != null) {
            $urlLength++;
            $shortenedUrl = substr($hashedUrl, 0, $urlLength);
            $findResult = ShortenerController::findUrl($shortenedUrl);
        }

        //Masukkan hasil hash pada database
        if ($findResult == null) {
            $this->saveUrl($longUrl, $shortenedUrl);
        }

        return response()->json(['shortUrl' => $shortenedUrl]);
    }

    /**
     * Mengembalikan alamat website yang dituju jika URL yang dipendekkan ada
     * dan halaman error jika URL tidak ada.
     * @param $shortUrl string Url yang sudah dipendekkan
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function normalizeUrl($shortUrl) {
        $longUrl = ShortenerController::findUrl($shortUrl);
        if ($longUrl == null) {
            //Return 404 page
            return view('error');
        } else {
            return Redirect::to($longUrl);
        }
    }

    /**
     * Membuat customUrl dengan shortUrl dan longUrl
     * @param $shortUrl isi dari shortUrl
     * @param Request $request request berisi longUrl
     * @return \Illuminate\Http\JsonResponse hasil apakah Url diterima
     */
    public function createCustomUrl($shortUrl, Request $request) {
        $longUrl = $request->input('url');

        if (preg_match('/(https?:\/\/).*/', $longUrl) == 0) {
            $longUrl = 'http://' . $longUrl;
        }

        if (ShortenerController::findUrl($shortUrl) == null || ShortenerController::findUrl($shortUrl) == $longUrl) {
            ShortenerController::saveUrl($longUrl,$shortUrl);
            return response()->json(['status' => 1]);
        }
        else{
            return response()->json(['status' => 0]);
        }
    }
}