<?php
namespace App;
use \Illuminate\Database\Eloquent\Model;

class UrlTable extends Model{
    //Config
    protected $table = 'UrlTable';
    public $timestamps = false;
    public $incrementing = false;

    public $primaryKey = 'shortenedUrl';
}
?>