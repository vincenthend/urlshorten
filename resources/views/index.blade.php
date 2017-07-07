<!doctype html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Localhost - URL Shortener</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">

    <!-- Styles -->
    <link href="{{asset('css/styles.css')}}" rel="stylesheet">

</head>
<body>
<div class="title">Localhost</div>
<div class="subtitle">another URL shortener</div>

<div class="warningBox" style="display: none">
    <div id="warningMessage">URL is invalid</div>
    <div id="warningClose">X</div>
</div>

<div class="wrapper">
    <input type="text" id="urlinput" name="url">
    <button type="submit" id="shortenbutton">shorten it!</button>
</div>

<div class="result">
    <div id="originalURL">http://google.com</div>
    <div id="shortenedURLwrapper">
        <div id="shortenedURL">http://localhost/blablabla</div>
        <button id="copyButton">copy</button>
    </div>
</div>
</body>
</html>
