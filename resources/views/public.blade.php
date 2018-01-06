<!DOCTYPE html>
<html class="shaded">
<head>
    <title>{{ setting('app-name') }}</title>
    
    @include('inc.header')
    
    <script>
    	if ('serviceWorker' in navigator && navigator.userAgent.indexOf("Mobile") === -1) {
    		navigator.serviceWorker.register('/service-worker.js').then(function(registration) {
    			console.log('ServiceWorker registration successful with scope: ', registration.scope);
    			console.log('DocsPen ♥\'s web');
    		})
    		.catch(function(err) {
    			console.error('ServiceWorker registration failed: ', err);
    		});
    	} else if('serviceWorker' in navigator && navigator.userAgent.indexOf("Mobile") > -1){
            navigator.serviceWorker.getRegistration().then(function(registration) {
                var serviceWorkerUnregistered=false;
                if(registration) {
                    registration.unregister();
                    serviceWorkerUnregistered=true;
                }
                serviceWorkerUnregistered && window.location.reload();
            });
        }
    </script>
    
    @include('partials/custom-styles')

    <!-- Custom user content -->
    @if(setting('app-custom-head'))
        {!! setting('app-custom-head') !!}
    @endif
</head>
<body class="@yield('body-class')">

@include('partials.notifications')

<header id="header">
    <div class="container fluid">
        <div class="row">
            <div class="col-sm-6">

                <a href="{{ baseUrl('/') }}" class="logo">
                    @if(setting('app-logo', '') !== 'none')
                        <img class="logo-image" src="https://unpkg.com/docspen@1.0.0/imgs/logo-small.png" alt="Logo">
                    @endif
                    @if (setting('app-name-header'))
                        <span class="logo-text">{{ setting('app-name') }}</span>
                    @endif
                </a>
            </div>
            <div class="col-sm-6">
                <div class="float right">
                    <div class="links text-center">
                        @yield('header-buttons')
                    </div>
                    @if(isset($signedIn) && $signedIn)
                        @include('partials._header-dropdown', ['currentUser' => $currentUser])
                    @endif
                </div>
            </div>
        </div>
    </div>
</header>

<section class="container">
    @yield('content')
</section>

<script src="{{ hashed_asset('js/common.js') }}"></script>
</body>
</html>
