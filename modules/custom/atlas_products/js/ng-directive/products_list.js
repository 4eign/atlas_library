myApp.directive('ngProductsList', ['$http', ngProductsList]);


function ngProductsList($http) {

    var directive = {
        restrict: 'EA',
        controller: ProductsController,
        link: linkFunc
    };

    return directive;

    function linkFunc(scope, el, attr, ctrl) {
        var config = drupalSettings.blockConfig[scope.uuid];
        retrieveInformation(scope, config, el);

        scope.apiIsLoading = function() {
            return $http.pendingRequests.length > 0;
        };

        scope.$watch(scope.apiIsLoading, function(v) {
            if (v == false) {
                jQuery(el).parents("section").fadeIn(400);
                if(scope.products[scope.uuid].error){
                    jQuery("div.actions", el).hide();
                }
            }
        });

    }

    function retrieveInformation(scope, config, el) {
        if ( scope.resources.indexOf(config.url) == -1){
            var uuid = scope.uuid;
            $http.get(config.url)
                .then(function (resp) {
                    scope.products[uuid] = resp.data;
                    //jQuery(el).parent().parent().parent().hide();
                    jQuery(el).parents("section").fadeIn('slow');
                }, function (resp){
                   drupal_set_message(Drupal.t("En este momento no podemos obtener tus productos, intenta de nuevo mas tarde."),"error", scope.uuid);
                   scope.products[uuid] = [];
                   scope.products[uuid].error = true;
                });
        };
    }
}

ProductsController.$inject = ['$scope'];

function ProductsController($scope) {
    // Init vars
    if(  typeof $scope.products == 'undefined'){
        $scope.products = [];
    }
    if(  typeof $scope.products[$scope.uuid] == 'undefined'){
        $scope.products[$scope.uuid] = [];
    }

    if (typeof $scope.resources == 'undefined') {
        $scope.resources = [];
    }
}
