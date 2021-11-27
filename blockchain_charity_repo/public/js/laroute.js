(function () {

    var laroute = (function () {

        var routes = {

            absolute: false,
            rootUrl: 'http://localhost',
            routes : [{"host":null,"methods":["GET","HEAD"],"uri":"api\/user","name":null,"action":"Closure"},{"host":null,"methods":["POST"],"uri":"api\/store-blockchain-request","name":"store.blockchain.request","action":"App\Http\Controllers\Api\BlockchainController@storeBlockchainRequest"},{"host":null,"methods":["POST"],"uri":"api\/decide-blockchain-request","name":"decide.blockchain.request","action":"App\Http\Controllers\Api\BlockchainController@decideBlockchainRequest"},{"host":null,"methods":["POST"],"uri":"api\/store-transaction","name":"store.transaction","action":"App\Http\Controllers\Api\BlockchainController@storeTransaction"},{"host":null,"methods":["GET","HEAD"],"uri":"logout","name":"charity.logout","action":"Closure"},{"host":null,"methods":["GET","HEAD"],"uri":"admin\/login","name":"admin.login","action":"App\Http\Controllers\AdminController@login"},{"host":null,"methods":["POST"],"uri":"admin\/login","name":"admin.login.verify","action":"App\Http\Controllers\AdminController@verify"},{"host":null,"methods":["GET","HEAD"],"uri":"admin\/logout","name":"admin.logout","action":"App\Http\Controllers\AdminController@logout"},{"host":null,"methods":["GET","HEAD"],"uri":"admin","name":"admin.dashboard.index","action":"App\Http\Controllers\AdminController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"admin\/list\/host","name":"admin.host.list","action":"App\Http\Controllers\AdminController@listHost"},{"host":null,"methods":["GET","HEAD"],"uri":"admin\/list\/campaign","name":"admin.campaign.list","action":"App\Http\Controllers\AdminController@listCampaign"},{"host":null,"methods":["GET","HEAD"],"uri":"admin\/list\/open-campaign-request","name":"admin.open-campaign-request.list","action":"App\Http\Controllers\AdminController@listOpenCampaignRequest"},{"host":null,"methods":["GET","HEAD"],"uri":"admin\/list\/validate-host-request","name":"admin.validate-host-request.list","action":"App\Http\Controllers\AdminController@listValidateHostRequest"},{"host":null,"methods":["GET","HEAD"],"uri":"admin\/profile","name":"admin.profile.edit","action":"App\Http\Controllers\AdminController@profile"},{"host":null,"methods":["GET","HEAD"],"uri":"admin\/add\/account","name":"admin.create.account","action":"App\Http\Controllers\AdminController@createAccount"},{"host":null,"methods":["GET","HEAD"],"uri":"admin\/list\/withdraw-money-request","name":"admin.withdraw-money-request.list","action":"App\Http\Controllers\AdminController@listWithdrawMoneyRequest"},{"host":null,"methods":["POST"],"uri":"login\/tow-factor","name":"login.towfactor","action":"App\Http\Controllers\Auth\TowFactorController@sendOtp"},{"host":null,"methods":["POST"],"uri":"register\/custom","name":"register.custom","action":"App\Http\Controllers\Auth\RegisterController@storeAccount"},{"host":null,"methods":["GET","HEAD"],"uri":"verify\/otp","name":"verify.otp.index","action":"App\Http\Controllers\Auth\TowFactorController@redirectFormConfirmOtp"},{"host":null,"methods":["POST"],"uri":"verify\/otp","name":"verify.otp","action":"App\Http\Controllers\Auth\TowFactorController@verifyOtp"},{"host":null,"methods":["GET","HEAD"],"uri":"resend-otp","name":"resend.otp","action":"App\Http\Controllers\Auth\TowFactorController@reSendMailOtp"},{"host":null,"methods":["POST"],"uri":"api\/verify-otp","name":"api.verify.otp","action":"App\Http\Controllers\Api\VerifyOtpController@verify"},{"host":null,"methods":["POST"],"uri":"api\/confirm-password","name":"api.verify.password","action":"App\Http\Controllers\Api\VerifyOtpController@confirmPassword"},{"host":null,"methods":["GET","HEAD"],"uri":"api\/send-otp","name":"api.send.otp","action":"App\Http\Controllers\Api\VerifyOtpController@sendOtp"},{"host":null,"methods":["GET","HEAD"],"uri":"redirect-login","name":"redirect.error","action":"App\Http\Controllers\Auth\TowFactorController@redirectWhenErrorOtp"},{"host":null,"methods":["GET","HEAD"],"uri":"charity\/profile","name":"profile","action":"App\Http\Controllers\DonatorController@profile"},{"host":null,"methods":["GET","HEAD"],"uri":"charity\/donator","name":"donator.home","action":"App\Http\Controllers\DonatorController@home"},{"host":null,"methods":["GET","HEAD"],"uri":"charity\/donator\/campaign","name":"donator.campaign","action":"App\Http\Controllers\DonatorController@listCampaign"},{"host":null,"methods":["GET","HEAD"],"uri":"charity\/donator\/campaign-detail\/{id}","name":"donator.campaign.detail","action":"App\Http\Controllers\DonatorController@campaignDetail"},{"host":null,"methods":["GET","HEAD"],"uri":"charity\/donatorws","name":"donatorws.home","action":"App\Http\Controllers\DonatorController@home"},{"host":null,"methods":["GET","HEAD"],"uri":"charity\/donatorws\/campaign","name":"donatorws.campaign","action":"App\Http\Controllers\DonatorController@WS_listCampaign"},{"host":null,"methods":["GET","HEAD"],"uri":"charity\/donatorws\/campaign-detail\/{id}","name":"donatorws.campaign.detail","action":"App\Http\Controllers\DonatorController@WS_campaignDetail"},{"host":null,"methods":["POST"],"uri":"charity\/donatorws\/donate\/campaign","name":"donatorws.donate.campaign","action":"App\Http\Controllers\DonatorController@WS_donateToCampaign"},{"host":null,"methods":["GET","HEAD"],"uri":"charity\/host","name":"host.home","action":"App\Http\Controllers\HostController@home"},{"host":null,"methods":["GET","HEAD"],"uri":"charity\/host\/campaign","name":"host.campaign","action":"App\Http\Controllers\HostController@listCampaign"},{"host":null,"methods":["GET","HEAD"],"uri":"charity\/host\/create-campaign","name":"host.campaign.create","action":"App\Http\Controllers\HostController@createCampaign"},{"host":null,"methods":["GET","HEAD"],"uri":"charity\/host\/campaign_detail\/{blockchainAddress}","name":"host.campaign.detail","action":"App\Http\Controllers\HostController@campaignDetail"},{"host":null,"methods":["GET","HEAD"],"uri":"charity\/host\/validate-host","name":"host.validate.host","action":"App\Http\Controllers\HostController@validateHost"},{"host":null,"methods":["GET","HEAD"],"uri":"charity\/hostws","name":"hostws.home","action":"App\Http\Controllers\HostController@home"},{"host":null,"methods":["GET","HEAD"],"uri":"charity\/hostws\/campaign","name":"hostws.campaign","action":"App\Http\Controllers\HostController@WS_listCampaign"},{"host":null,"methods":["GET","HEAD"],"uri":"charity\/hostws\/create-campaign","name":"hostws.campaign.create","action":"App\Http\Controllers\HostController@WS_createCampaign"},{"host":null,"methods":["GET","HEAD"],"uri":"charity\/hostws\/campaign_detail\/{blockchainAddress}","name":"hostws.campaign.detail","action":"App\Http\Controllers\HostController@WS_campaignDetail"},{"host":null,"methods":["GET","HEAD"],"uri":"charity\/hostws\/validate-host","name":"hostws.validate.host","action":"App\Http\Controllers\HostController@WS_validateHost"},{"host":null,"methods":["POST"],"uri":"charity\/hostws\/donate\/campaign","name":"hostws.donate.campaign","action":"App\Http\Controllers\HostController@WS_donateToCampaign"},{"host":null,"methods":["POST"],"uri":"charity\/hostws\/withdraw\/campaign","name":"hostws.withdraw.campaign","action":"App\Http\Controllers\HostController@WS_withdrawCampaign"},{"host":null,"methods":["POST"],"uri":"charity\/hostws\/validate\/request","name":"hostws.validate.tobehost.request","action":"App\Http\Controllers\HostController@WS_hostValidateRequest"},{"host":null,"methods":["POST"],"uri":"charity\/hostws\/openCampaign\/request","name":"hostws.validate.openCampaign.request","action":"App\Http\Controllers\HostController@WS_hostOpenCampaignRequest"},{"host":null,"methods":["GET","HEAD"],"uri":"charity\/campaign\/list-donator","name":"campaign.donator","action":"App\Http\Controllers\DonatorController@listDonator"},{"host":null,"methods":["GET","HEAD"],"uri":"\/","name":"home","action":"App\Http\Controllers\FrontEndController@home"},{"host":null,"methods":["GET","HEAD"],"uri":"campaign","name":"campaign","action":"App\Http\Controllers\FrontendController@campaign"},{"host":null,"methods":["GET","HEAD"],"uri":"campaign\/{id}","name":"campaign.detail","action":"App\Http\Controllers\FrontendController@detail"},{"host":null,"methods":["GET","HEAD"],"uri":"login","name":"login","action":"App\Http\Controllers\Auth\LoginController@showLoginForm"},{"host":null,"methods":["POST"],"uri":"login","name":null,"action":"App\Http\Controllers\Auth\LoginController@login"},{"host":null,"methods":["POST"],"uri":"logout","name":"logout","action":"App\Http\Controllers\Auth\LoginController@logout"},{"host":null,"methods":["GET","HEAD"],"uri":"register","name":"register","action":"App\Http\Controllers\Auth\RegisterController@showRegistrationForm"},{"host":null,"methods":["POST"],"uri":"register","name":null,"action":"App\Http\Controllers\Auth\RegisterController@register"},{"host":null,"methods":["GET","HEAD"],"uri":"password\/reset","name":"password.request","action":"App\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm"},{"host":null,"methods":["POST"],"uri":"password\/email","name":"password.email","action":"App\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail"},{"host":null,"methods":["GET","HEAD"],"uri":"password\/reset\/{token}","name":"password.reset","action":"App\Http\Controllers\Auth\ResetPasswordController@showResetForm"},{"host":null,"methods":["POST"],"uri":"password\/reset","name":"password.update","action":"App\Http\Controllers\Auth\ResetPasswordController@reset"},{"host":null,"methods":["GET","HEAD"],"uri":"password\/confirm","name":"password.confirm","action":"App\Http\Controllers\Auth\ConfirmPasswordController@showConfirmForm"},{"host":null,"methods":["POST"],"uri":"password\/confirm","name":null,"action":"App\Http\Controllers\Auth\ConfirmPasswordController@confirm"},{"host":null,"methods":["GET","HEAD"],"uri":"email\/verify","name":"verification.notice","action":"App\Http\Controllers\Auth\VerificationController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"email\/verify\/{id}\/{hash}","name":"verification.verify","action":"App\Http\Controllers\Auth\VerificationController@verify"},{"host":null,"methods":["POST"],"uri":"email\/resend","name":"verification.resend","action":"App\Http\Controllers\Auth\VerificationController@resend"},{"host":null,"methods":["GET","HEAD"],"uri":"my-wallet","name":"wallet","action":"App\Http\Controllers\DonatorController@myWallet"},{"host":null,"methods":["POST"],"uri":"api\/change-key","name":"api.change.key","action":"App\Http\Controllers\Api\ResetKeyController@changeKey"}],
            prefix: '',

            route : function (name, parameters, route) {
                route = route || this.getByName(name);

                if ( ! route ) {
                    return undefined;
                }

                return this.toRoute(route, parameters);
            },

            url: function (url, parameters) {
                parameters = parameters || [];

                var uri = url + '/' + parameters.join('/');

                return this.getCorrectUrl(uri);
            },

            toRoute : function (route, parameters) {
                var uri = this.replaceNamedParameters(route.uri, parameters);
                var qs  = this.getRouteQueryString(parameters);

                if (this.absolute && this.isOtherHost(route)){
                    return "//" + route.host + "/" + uri + qs;
                }

                return this.getCorrectUrl(uri + qs);
            },

            isOtherHost: function (route){
                return route.host && route.host != window.location.hostname;
            },

            replaceNamedParameters : function (uri, parameters) {
                uri = uri.replace(/\{(.*?)\??\}/g, function(match, key) {
                    if (parameters.hasOwnProperty(key)) {
                        var value = parameters[key];
                        delete parameters[key];
                        return value;
                    } else {
                        return match;
                    }
                });

                // Strip out any optional parameters that were not given
                uri = uri.replace(/\/\{.*?\?\}/g, '');

                return uri;
            },

            getRouteQueryString : function (parameters) {
                var qs = [];
                for (var key in parameters) {
                    if (parameters.hasOwnProperty(key)) {
                        qs.push(key + '=' + parameters[key]);
                    }
                }

                if (qs.length < 1) {
                    return '';
                }

                return '?' + qs.join('&');
            },

            getByName : function (name) {
                for (var key in this.routes) {
                    if (this.routes.hasOwnProperty(key) && this.routes[key].name === name) {
                        return this.routes[key];
                    }
                }
            },

            getByAction : function(action) {
                for (var key in this.routes) {
                    if (this.routes.hasOwnProperty(key) && this.routes[key].action === action) {
                        return this.routes[key];
                    }
                }
            },

            getCorrectUrl: function (uri) {
                var url = this.prefix + '/' + uri.replace(/^\/?/, '');

                if ( ! this.absolute) {
                    return url;
                }

                return this.rootUrl.replace('/\/?$/', '') + url;
            }
        };

        var getLinkAttributes = function(attributes) {
            if ( ! attributes) {
                return '';
            }

            var attrs = [];
            for (var key in attributes) {
                if (attributes.hasOwnProperty(key)) {
                    attrs.push(key + '="' + attributes[key] + '"');
                }
            }

            return attrs.join(' ');
        };

        var getHtmlLink = function (url, title, attributes) {
            title      = title || url;
            attributes = getLinkAttributes(attributes);

            return '<a href="' + url + '" ' + attributes + '>' + title + '</a>';
        };

        return {
            // Generate a url for a given controller action.
            // laroute.action('HomeController@getIndex', [params = {}])
            action : function (name, parameters) {
                parameters = parameters || {};

                return routes.route(name, parameters, routes.getByAction(name));
            },

            // Generate a url for a given named route.
            // laroute.route('routeName', [params = {}])
            route : function (route, parameters) {
                parameters = parameters || {};

                return routes.route(route, parameters);
            },

            // Generate a fully qualified URL to the given path.
            // laroute.route('url', [params = {}])
            url : function (route, parameters) {
                parameters = parameters || {};

                return routes.url(route, parameters);
            },

            // Generate a html link to the given url.
            // laroute.link_to('foo/bar', [title = url], [attributes = {}])
            link_to : function (url, title, attributes) {
                url = this.url(url);

                return getHtmlLink(url, title, attributes);
            },

            // Generate a html link to the given route.
            // laroute.link_to_route('route.name', [title=url], [parameters = {}], [attributes = {}])
            link_to_route : function (route, title, parameters, attributes) {
                var url = this.route(route, parameters);

                return getHtmlLink(url, title, attributes);
            },

            // Generate a html link to the given controller action.
            // laroute.link_to_action('HomeController@getIndex', [title=url], [parameters = {}], [attributes = {}])
            link_to_action : function(action, title, parameters, attributes) {
                var url = this.action(action, parameters);

                return getHtmlLink(url, title, attributes);
            }

        };

    }).call(this);

    /**
     * Expose the class either via AMD, CommonJS or the global object
     */
    if (typeof define === 'function' && define.amd) {
        define(function () {
            return laroute;
        });
    }
    else if (typeof module === 'object' && module.exports){
        module.exports = laroute;
    }
    else {
        window.laroute = laroute;
    }

}).call(this);

