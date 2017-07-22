var app = angular.module("urlShortener", []);

//Config for escape [[ to work with laravel
app.config(function ($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
});

app.controller('shortenerController', function ($scope, $http) {
        $scope.originalUrl = "";
        $scope.shortenedUrl = "";
        $scope.showResult = false;
        $scope.showWarning = false;
        $scope.isEditing = false;
        $scope.warningMessage = "URL tidak valid!";
        $scope.url = window.location;

        //Memvalidasi apakah string adalah URL dengan regex; true jika valid
        function validateUrl(url) {
            var pattern = new RegExp(/(^|\s)((https?:\/\/)?[\w-]+(\.[\w-]+)+\.?(:\d+)?(\/\S*)?)/);
            return pattern.test(url);
        }

        //Melakukan shorten pada URL yang valid, menampilkan warning jika tidak
        $scope.shortenLink = function () {
            console.log($scope.url["origin"]);
            if (validateUrl($scope.urlInput.valueOf())) {
                var shortURL = $http({
                    method: 'POST',
                    url: $scope.url["origin"],
                    data : {
                        url : $scope.urlInput.valueOf()
                    }
                }).then(function (response) {
                    console.log(response);
                    $scope.shortenedUrl = $scope.url + response.data.shortUrl;
                });
                $scope.originalUrl = $scope.urlInput.valueOf();
                $scope.showResult = true;
                $scope.showWarning = false;
            }
            else {
                $scope.showWarning = true;
            }
        };

        $scope.closeWarning = function () {
            $scope.showWarning = false;
        };

        $scope.copyLink = function(){

        }
    }
);
