var app = angular.module("urlShortener", []);

//Config for escape [[ to work with laravel
app.config(function ($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
});

app.controller('shortenerController', function ($scope, $http) {
        $scope.originalUrl = "";
        $scope.shortenedUrl = "";
        $scope.tempUrl = "";
        $scope.showResult = false;
        $scope.showWarning = false;
        $scope.isEditing = false;
        $scope.warningMessage = "";
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
                $http.post($scope.url["origin"], {url: $scope.urlInput.valueOf()})
                    .then(function (response) {
                        console.log(response);
                        $scope.shortenedUrl = response.data.shortUrl;
                    });
                $scope.originalUrl = $scope.urlInput.valueOf();
                $scope.showResult = true;
                $scope.showWarning = false;
                $scope.isEditing = false;
            }
            else {
                $scope.warningMessage = "URL tidak valid!";
                $scope.showWarning = true;
            }
        };
        $scope.closeWarning = function () {
            $scope.showWarning = false;
        };
        $scope.copyLink = function () {
            //TODO : Fungsi copy ke clipboard
        };
        $scope.editLink = function () {
            $scope.isEditing = true;
        };
        $scope.saveLink = function () {
            $scope.tempUrl = $scope.shortenedUrl;
            //Send POST request
            $http.post('/'+$scope.shortenedUrl,{url: $scope.originalUrl}).then(function(response){
                //If save request is accepted, save new data
                //If save request is notAccepted, return using tempUrl
                if(response.data.status === 1){
                    $scope.isEditing = false;
                }
                else{
                    $scope.shortenedUrl = $scope.tempUrl;
                    $scope.warningMessage = "URL sudah ada!";
                    $scope.showWarning = true;
                }
            });
        };
    }
);
