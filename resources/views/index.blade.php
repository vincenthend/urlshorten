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
<div class="title">Local<font color="#c7254e">host</font></div>
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
        <div id="originalUrl">[[originalUrl]]</div>
        <div id="shortenedUrlwrapper">
            <div ng-show="!isEditing" id="shortenedUrl">
                <a id="shortenedUrl" ng-href="[[url]][[shortenedUrl]]">[[url]][[shortenedUrl]]</a>
            </div>
            <form ng-show="isEditing">
                <div id="shortenedUrl">[[url]]<input class="editField" type="text" ng-model=shortenedUrl></div>
                <button class="button" ng-click="saveLink()" ng-show="isEditing">save</button>
            </form>
            <button class="button" ng-click="copyLink()" ng-show="!isEditing">copy</button>
            <button class="button" ng-click="editLink()" ng-show="!isEditing">edit</button>
        </div>
    </div>
</div>

<!-- angularJS script -->
<script src="{{asset('js/angular.min.js')}}"></script>
<script src="{{asset('js/urlShorten.js')}}"></script>
</body>
</html>
