var app = angular.module("urlShortener", []);

//Config for escape [[ to work with laravel
app.config(function ($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
});

app.controller('shortenerController', function ($scope, $http) {
        $scope.originalURL = "";
        $scope.shortenedURL = "";
        $scope.showResult = false;
        $scope.showWarning = false;
        $scope.warningMessage = "URL tidak valid!";
        $scope.url = window.location;

        //Memvalidasi apakah string adalah URL dengan regex; true jika valid
        function validateURL(url) {
            var pattern = new RegExp(/(^|\s)((https?:\/\/)?[\w-]+(\.[\w-]+)+\.?(:\d+)?(\/\S*)?)/);
            return pattern.test(url);
        }

        //Melakukan shorten pada URL yang valid, menampilkan warning jika tidak
        $scope.shortenLink = function () {
            if (validateURL($scope.urlInput.valueOf())) {
                var shortURL;
                //http.ajax($scope.url, {url: $scope.urlInput.valueOf()}
                shortURL = $http({
                    method: 'POST',
                    url: $scope.url,
                    data: {url: $scope.urlInput.valueOf()}
                }).then(function (response) {
                    console.log(response);
                    $scope.shortenedURL = $scope.url + response.data.shortUrl;
                });
                $scope.originalURL = $scope.urlInput.valueOf();
                $scope.showResult = true;
                $scope.showWarning = false;
            }
            else {
                $scope.showWarning = true;
            }
        }

        $scope.closeWarning = function () {
            $scope.showWarning = false;
        }
    }
);
