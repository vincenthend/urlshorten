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

<div class="app" ng-app="urlShortener" ng-controller="shortenerController">
    <div class="warningBox" ng-show="showWarning">
        <div id="warningMessage">[[warningMessage]]</div>
        <div id="warningClose" ng-click="closeWarning()">X</div>
    </div>

    <div class="wrapper">
        <form>
            <input type="text" id="urlInput" name="url" ng-model="urlInput" placeholder="place your link here...">
            <button type="submit" id="shortenbutton" ng-click="shortenLink()">shorten it!</button>
        </form>
    </div>

    <div class="result" ng-show="showResult">
        <div id="originalURL">[[originalURL]]</div>
        <div id="shortenedURLwrapper">
            <div id="shortenedURL">[[shortenedURL]]</div>
            <button id="copyButton">copy</button>
        </div>
    </div>
</div>

<!-- angularJS script -->
<script src="{{asset('js/angular.min.js')}}"></script>
<script src="{{asset('js/urlShorten.js')}}"></script>
</body>
</html>
