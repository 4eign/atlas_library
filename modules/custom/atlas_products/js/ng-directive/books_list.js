myApp.directive('ngBooksList', ['$http', ngBooksList]);

function ngBooksList($http) {

  return {
    restrict: 'EA',
    controller: BooksController,
    link: linkFunc
  };

  function linkFunc(scope, el) {
    var config = drupalSettings.booksListBlockConfig[scope.uuid];
    retrieveInformation(scope, config, el);

    scope.apiIsLoading = function() {
      return $http.pendingRequests.length > 0;
    };

    scope.$watch(scope.apiIsLoading, function(v) {
      if (v == false) {
        if(undefined !== scope.books[scope.uuid]){
          if(scope.books[scope.uuid].error != true){
            jQuery(el).parents("section").fadeIn(400);
          }
        }
      }
    });

  }

  function retrieveInformation(scope, config) {
    if ( scope.resources.indexOf(config.url) == -1){
      var uuid = scope.uuid;
      $http.get(config.url)
        .then(function successCallback(resp) {
          scope.books[uuid] = resp.data;
        }, function errorCallback(resp){
          console.log(resp);
          drupal_set_message(Drupal.t("En este momento no podemos obtener tus productos, intenta de nuevo mas tarde."),"error", scope.uuid);
          scope.products[uuid].error = true;
        });
    }
  }
}

BooksController.$inject = ['$scope','$http'];

function BooksController($scope,$http) {
  // Init vars
  if(  typeof $scope.books == 'undefined'){
    $scope.books = [];
  }
  if(  typeof $scope.books[$scope.uuid] == 'undefined'){
    $scope.books[$scope.uuid] = [];
  }

  if (typeof $scope.resources == 'undefined') {
    $scope.resources = [];
  }

  $scope.bookFilter = function () {
    //Get config
    var config = drupalSettings.booksListBlockConfig[$scope.uuid];

    var filters = config.block_config.filters_fields;
    console.log(filters);
    //Get from filters values
    var parameters = {};
    for ( filter in filters) {
      if (filters.hasOwnProperty(filter)){
        var value = filters[filter];
        if (!$scope[value.id] == '' || !$scope[value.id] === undefined) {
          parameters[value.id] = $scope[value.id];
        }
      }
    }

    //Get drupal X-CSRF-Token
    $http.get('/rest/session/token').then(function(resp) {
        //Get Data For Filters;
        $http({
          method: 'POST',
          url: config.url,
          data: parameters,
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-Token': resp.data
          }
        }).then(function successCallback(response) {
          $scope.books[$scope.uuid] = response.data;
        }, function errorCallback(response) {
          console.log(response);
          console.log("Error obteniendo los datos del servicio");
        });
      }, function errorCallback(resp) {
        console.log(resp);
        console.log("Error obteniendo el X-CSRF-Token");
      }
    );

  }
}
