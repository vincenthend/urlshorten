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

        //Melakukan shorten pada URL yang valid.
        $scope.shortenLink = function () {
            if (validateUrl($scope.urlInput.valueOf())) {
                $http.post($scope.url["origin"], {url: $scope.urlInput.valueOf()})
                    .then(function (response) {
                        if (response.status == 200 || response.status == 201) {
                            $scope.shortenedUrl = response.data.shortUrl;
                            $scope.originalUrl = $scope.urlInput.valueOf();
                            $scope.showResult = true;
                            $scope.showWarning = false;
                            $scope.isEditing = false;
                        }
                    }, function (error) {
                        //Error message on unable to connect
                        $scope.showWarning = true;
                        $scope.warningMessage = "Connection Error";
                    });
            }
            else {
                $scope.warningMessage = "URL tidak valid!";
                $scope.showWarning = true;
            }
        };

        /*Melakukan copy shortenedUrl pada clipboard
         */
        $scope.copyLink = function () {
            var range = document.createRange();
            range.selectNode(document.getElementById("shortenedUrl"));
            window.getSelection().addRange(range);
            document.execCommand("Copy");
        };

        //Membuat shortenedUrl menjadi editable
        $scope.editLink = function () {
            $scope.isEditing = true;
            $scope.tempUrl = $scope.shortenedUrl;
        };

        //Menyimpan shortenedUrl
        $scope.saveLink = function () {
            //Send POST request
            if ($scope.tempUrl != $scope.shortenedUrl) {
                $http.post('/' + $scope.shortenedUrl, {url: $scope.originalUrl}).then(function (response) {
                    //If save request is accepted, save new data
                    //If save request is notAccepted, return using tempUrl
                    if (response.data.status === 1) {
                        $scope.isEditing = false;
                    }
                    else {
                        $scope.shortenedUrl = $scope.tempUrl;
                        $scope.warningMessage = "URL sudah ada!";
                        $scope.showWarning = true;
                    }
                });
            }
            else {
                $scope.isEditing = false;
            }
        };

        //Menutup pesan warning
        $scope.closeWarning = function () {
            $scope.showWarning = false;
        };
    }
);
